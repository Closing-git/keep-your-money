// ----------------------------------------------
// Récupération des éléments du DOM
// ----------------------------------------------

// sections
const sectionItems   = document.getElementById("items-list");
const sectionIntro   = document.getElementById("intro-qcm");
const sectionQuiz    = document.getElementById("quiz");
const sectionResult  = document.getElementById("resultat");
const sectionBravo   = document.getElementById("quiz-bravo");

// textes intro
const introTitre     = document.getElementById("intro-titre");
const introTexte     = document.getElementById("intro-texte");

// zone du qcm
const qTitre         = document.getElementById("q-titre");
const qChoixZone     = document.getElementById("q-choix");

// texte résultat + actions
const resTitre       = document.getElementById("res-titre");
const resTexte       = document.getElementById("res-texte");
const resActions     = document.getElementById("res-actions");

// boutons haut
const btnBack        = document.getElementById("btn-back");
const btnStart       = document.getElementById("btn-start");
const btnChangeCat   = document.getElementById("btn-change-cat");

// boutons résultat
const btnResNo       = document.getElementById("btn-res-no");
const btnResYes      = document.getElementById("btn-res-yes");

// popup
const popupConfirm   = document.getElementById("popup-confirm");
const popupNo        = document.getElementById("popup-no");
const popupYes       = document.getElementById("popup-yes");

// écran BRAVO
const spanArgentEvite = document.getElementById("argentEvite");
const spanJetons      = document.getElementById("jetonsGagnes");
const spanTotalArgent = document.getElementById("totalArgent");
const btnVoirAvatar   = document.getElementById("voirAvatar");
const btnAllerMagasin = document.getElementById("allerMagasin");
const btnRefaireQuiz  = document.getElementById("refaireQuiz");

// type de résultat par clé
const resultMeta = {
    res_biblio:      { type: "neg" },
    res_envie:       { type: "neg" },
    res_usage:       { type: "neg" },
    res_humeur:      { type: "neg" },
    res_trop:        { type: "neg" },
    res_pas_utilise: { type: "neg" },
    res_ok:          { type: "pos" },
    res_jetons:      { type: "neg" }
};

// état global
let currentView      = "items";
let currentCat       = null;
let currentQuestionId = null;
let questionHistory  = [];
let currentJetons    = 0;
let prixChoisi       = null;
let currentResultKey = null;

// ------------------------------------------------
// Affichage des sections
// ------------------------------------------------
function showSection(viewName)
{
    sectionItems.hidden  = true;
    sectionIntro.hidden  = true;
    sectionQuiz.hidden   = true;
    sectionResult.hidden = true;
    sectionBravo.hidden  = true;

    // fermer popup si ouverte
    if (popupConfirm) {
        popupConfirm.style.display = "none";
    }

    if (viewName === "items")  sectionItems.hidden  = false;
    if (viewName === "intro")  sectionIntro.hidden  = false;
    if (viewName === "quiz")   sectionQuiz.hidden   = false;
    if (viewName === "result") sectionResult.hidden = false;
    if (viewName === "bravo")  sectionBravo.hidden  = false;

    currentView = viewName;
}

// démarre sur la liste d’items
showSection("items");

// ------------------------------------------------
// Textes intro selon catégorie
// ------------------------------------------------
const introData =
{
    vetements:
    {
        titre: "Tu aimerais acheter un nouveau vêtement",
        texte: "On va t’aider à savoir si cet achat est vraiment indispensable."
    },
    livres:
    {
        titre: "Tu aimerais acheter un nouveau livre",
        texte: "On va voir si ce livre est un besoin réel ou juste une envie de plus dans la pile à lire."
    },
    jeux:
    {
        titre: "Tu aimerais acheter un nouveau jeu-vidéo",
        texte: "Regardons si ce jeu est vraiment nécessaire ou juste un énième jeu dans ta collection."
    },
    meubles:
    {
        titre: "Tu aimerais acheter un nouveau meuble",
        texte: "On va vérifier si ce meuble est indispensable ou juste une envie de déco."
    },
    loisirs:
    {
        titre: "Tu aimerais acheter quelque chose pour tes loisirs",
        texte: "Cette catégorie arrive bientôt !"
    }
};

// ------------------------------------------------
// Mots dynamiques (remplace {objet}, {conteneur}, {type})
// ------------------------------------------------
const motsCategorie = {
    livres:    { objet: "livre",     type: "livre",    conteneur: "bibliothèque" },
    vetements: { objet: "vêtement",  type: "vêtement", conteneur: "armoire" },
    jeux:      { objet: "jeu vidéo", type: "jeu vidéo",conteneur: "collection" },
    meubles:   { objet: "meuble",    type: "meuble",   conteneur: "maison" }
};

// -----------------------------------------------------------
// CHEMIN QCM – QUESTIONS / RÉSULTATS
// -----------------------------------------------------------
const qcmChemin = {

    livres:
    {
        start: "q1",

        questions:
        {
            // q1 - prix
            q1:
            {
                texte: "Quel est le prix de ce {objet} ?",
                choix: [
                    { label: "0–10 €",    next: "q2", jetons: 10 },
                    { label: "10–20 €",   next: "q2", jetons: 20 },
                    { label: "20–30 €",   next: "q2", jetons: 30 },
                    { label: "+ de 30 €", next: "q2", jetons: 40 }
                ]
            },

            // q2 - dépenses
            q2:
            {
                texte: "Combien as-tu dépensé en loisir/plaisir cette semaine ?",
                choix: [
                    { label: "0–10 €",    next: "q3" },
                    { label: "10–20 €",   next: "q3" },
                    { label: "20–30 €",   next: "q3" },
                    { label: "30–50 €",   next: "q3" },
                    { label: "+ de 50 €", next: "q3" }
                ]
            },

            // q3 - priorité
            q3:
            {
                texte: "Cet achat pourrait-il t'empêcher de payer quelque chose de plus utile cette semaine, ce mois-ci ou cette année (facture, réparation, sortie prévue depuis longtemps...) ?",
                choix: [
                    { label: "Oui, ça pourrait poser problème", next: "res_biblio" },
                    { label: "Non, aucun risque",               next: "q4"        }
                ]
            },

            // q4 - envie ancienne ou spontanée
            q4:
            {
                texte: "Est-ce un {objet} que tu souhaites depuis un moment ?",
                choix: [
                    { label: "Oui",                     next: "q5"  },
                    { label: "C’est un désir spontané", next: "q41" }
                ]
            },

            // q41 - impulsif
            q41:
            {
                texte: "C’est un désir spontané. Tu veux attendre un peu pour voir si tu en as vraiment envie ?",
                choix: [
                    { label: "Oui, j’attends",         next: "res_envie" },
                    { label: "Non, je veux continuer", next: "q42"       }
                ]
            },

            // q42 - usage réel
            q42:
            {
                texte: "Penses-tu vraiment utiliser ce {objet}, ou va-t-il juste rester dans ton/ta {conteneur} ?",
                choix: [
                    { label: "Oui, je vais l’utiliser", next: "q6"        },
                    { label: "Non, probablement pas",   next: "res_usage" }
                ]
            },

            // q5 - similaire ?
            q5:
            {
                texte: "As-tu déjà un {objet} similaire ?",
                choix: [
                    { label: "Oui", next: "q50" },
                    { label: "Non", next: "q90" }
                ]
            },

            // q6 - émotions
            q6:
            {
                texte: "Dans quelles émotions es-tu en ce moment ?",
                choix: [
                    { label: "Stress",     next: "q61" },
                    { label: "Colère",     next: "q61" },
                    { label: "Fatigue",    next: "q61" },
                    { label: "Tristesse",  next: "q61" },
                    { label: "Joie",       next: "q5"  },
                    { label: "Calme",      next: "q5"  }
                ]
            },

            // q61 - humeur réelle
            q61:
            {
                texte: "Cet achat va-t-il réellement améliorer cette humeur ?",
                choix: [
                    { label: "Oui", next: "q50"        },
                    { label: "Non", next: "res_humeur" }
                ]
            },

            // q50 - quantité
            q50:
            {
                texte: "En quelle quantité possèdes-tu déjà ce type de {objet} ?",
                choix: [
                    { label: "1",           next: "q90"           },
                    { label: "1 à 3",       next: "q90"           },
                    { label: "3 à 5",       next: "q90"           },
                    { label: "10 ou plus",  next: "res_trop"      },
                    { label: "Encore plus", next: "res_pas_utilise" }
                ]
            },

            // q90 - décision finale
            q90:
            {
                texte: "Alors… tu l’as acheté ?",
                choix: [
                    { label: "Oui", next: "res_ok"     },
                    { label: "Non", next: "res_jetons" }
                ]
            }
        },

        // résultats
        results:
        {
            res_biblio:
                "Tu peux peut-être l’emprunter ou l’avoir autrement, et l’acheter plus tard si c’est toujours important.",

            res_envie:
                "C’était une envie spontanée. Attendre un peu avant d’acheter peut aider à éviter les achats impulsifs.",

            res_usage:
                "Réfléchis si tu vas vraiment l’utiliser ou s’il va juste rester dans un coin.",

            res_humeur:
                "Si ça n’améliore pas vraiment ton humeur, ce n’est peut-être pas le bon moment pour acheter.",

            res_trop:
                "Tu en as déjà beaucoup. Peut-être utiliser ceux que tu as avant d’en acheter un nouveau.",

            res_pas_utilise:
                "Tu as déjà des objets du même type que tu utilises peu. Autant les utiliser d'abord.",

            res_ok:
                "Ton achat semble cohérent. Tu peux l’acheter si tu en as vraiment envie.",

            res_jetons:
                "Bravo ! Tu as décidé de ne pas l’acheter. Tu gagnes des jetons virtuels."
        }
    }
};

// Les autres catégories réutilisent le même QCM
qcmChemin.vetements = qcmChemin.livres;
qcmChemin.jeux      = qcmChemin.livres;
qcmChemin.meubles   = qcmChemin.livres;

// Loisirs → pas encore prêt
qcmChemin.loisirs = { start: null };

// -----------------------------------------------------------
// VARIABLES ÉTAT QCM
// -----------------------------------------------------------

// -----------------------------------------------------------
// CLICK SUR UNE CATÉGORIE
// -----------------------------------------------------------
const itemButtons = document.querySelectorAll("#items-list button[data-cat]");

itemButtons.forEach((btn) =>
{
    btn.addEventListener("click", () =>
    {
        currentCat = btn.dataset.cat;

        introTitre.textContent = introData[currentCat].titre;
        introTexte.textContent = introData[currentCat].texte;

        currentQuestionId = null;
        questionHistory   = [];
        currentJetons     = 0;
        prixChoisi        = null;

        showSection("intro");
    });
});

// -----------------------------------------------------------
// BOUTON : changer de catégorie
// -----------------------------------------------------------
btnChangeCat.addEventListener("click", () =>
{
    resetState();
    showSection("items");
});

// -----------------------------------------------------------
// BOUTON : commencer le QCM
// -----------------------------------------------------------
btnStart.addEventListener("click", () =>
{
    if (!currentCat) return;

    const dataCat = qcmChemin[currentCat];

    // catégorie non prête (loisirs)
    if (!dataCat || !dataCat.start)
    {
        resTitre.textContent = "Bientôt disponible";
        resTexte.textContent = "Cette catégorie n'est pas encore prête.";
        resActions.style.display = "none";
        showSection("result");
        return;
    }

    resActions.style.display = "flex";

    questionHistory = [];
    currentJetons   = 0;
    prixChoisi      = null;

    currentQuestionId = dataCat.start;
    showQuestionById(currentQuestionId);
});

// -----------------------------------------------------------
// AFFICHER QUESTION
// -----------------------------------------------------------
function showQuestionById(questionId)
{
    const dataCat   = qcmChemin[currentCat];
    const question  = dataCat.questions[questionId];
    currentQuestionId = questionId;

    const mots = motsCategorie[currentCat];

    let texte = question.texte
        .replaceAll("{objet}", mots.objet)
        .replaceAll("{conteneur}", mots.conteneur)
        .replaceAll("{type}", mots.type);

    qTitre.textContent = texte;

    // Boutons de réponse
    qChoixZone.innerHTML = "";

    question.choix.forEach((c) =>
    {
        const btn = document.createElement("button");
        btn.textContent = c.label;

        btn.addEventListener("click", () =>
        {
            if (typeof c.jetons === "number")
                currentJetons = c.jetons;

            // mémoriser la fourchette de prix pour BRAVO
            if (currentQuestionId === "q1")
                prixChoisi = c.label;

            onAnswer(c.next);
        });

        qChoixZone.appendChild(btn);
    });

    showSection("quiz");
}

// -----------------------------------------------------------
// GESTION DES RÉPONSES
// -----------------------------------------------------------
function onAnswer(nextKey)
{
    const dataCat = qcmChemin[currentCat];

    // mémoriser historique
    if (currentQuestionId)
        questionHistory.push(currentQuestionId);

    if (nextKey.startsWith("res_"))
    {
        showAdviceScreen(nextKey);
        return;
    }

    // question suivante
    showQuestionById(nextKey);
}

// -----------------------------------------------------------
// ÉCRAN DE CONSEIL + BOUTONS
// -----------------------------------------------------------
function showAdviceScreen(resultKey)
{
    const dataCat = qcmChemin[currentCat];
    const mots    = motsCategorie[currentCat];
    let texte     = dataCat.results[resultKey] || "";
    const meta    = resultMeta[resultKey] || { type: "info" };

    currentResultKey = resultKey;

    texte = texte
        .replaceAll("{objet}", mots.objet)
        .replaceAll("{conteneur}", mots.conteneur)
        .replaceAll("{type}", mots.type);

    resTexte.textContent = texte;
    resActions.style.display = "flex";

    // POSITIF
    if (meta.type === "pos")
    {
        resTitre.textContent = "FRANCHEMENT, TU PEUX L’ACHETER !";

        btnResYes.textContent = "Je l’achète";
        btnResNo.textContent  = "Je ne l’achète finalement pas";

        // pas de popup en positif
        popupConfirm.style.display = "none";

        btnResNo.onclick  = () => onFinalChoice(false);
        btnResYes.onclick = () => onFinalChoice(true);
    }
    // NEGATIF
    else
    {
        resTitre.textContent = "ON TE CONSEILLE DE NE PAS L’ACHETER";

        btnResYes.textContent = "Je l’achète malgré vos conseils";
        btnResNo.textContent  = "JE NE L’ACHÈTE PAS";

        // clic sur "JE NE L’ACHÈTE PAS" -> directement BRAVO
        btnResNo.onclick = () =>
        {
            popupConfirm.style.display = "none";
            onFinalChoice(false);
        };

        // clic sur "Je l’achète malgré vos conseils" -> ouvrir popup
        btnResYes.onclick = () =>
        {
            popupConfirm.style.display = "flex";
        };

        // popup "Non, vous avez raison..."
        popupNo.onclick = () =>
        {
            popupConfirm.style.display = "none";
            onFinalChoice(false);
        };

        // popup "Oui, tant pis pour moi..."
        popupYes.onclick = () =>
        {
            popupConfirm.style.display = "none";
            onFinalChoice(true);
        };
    }

    showSection("result");
}

// -----------------------------------------------------------
// CHOIX FINAL
// -----------------------------------------------------------
function resetState()
{
    currentCat        = null;
    currentQuestionId = null;
    questionHistory   = [];
    currentJetons     = 0;
    prixChoisi        = null;
    currentResultKey  = null;
}

// aAchete = true si la personne décide d’acheter
function onFinalChoice(aAchete)
{
    const mots = motsCategorie[currentCat] || { objet: "objet" };

    // CAS : il ne l’achète pas -> ÉCRAN BRAVO
    if (!aAchete)
    {
        spanArgentEvite.textContent = prixChoisi || "ce montant";
        spanJetons.textContent      = currentJetons ;

        showSection("bravo");

        if (btnVoirAvatar)
            btnVoirAvatar.onclick = () => alert("TODO: écran avatar");

        if (btnAllerMagasin)
            btnAllerMagasin.onclick = () => alert("TODO: écran magasin");

        if (btnRefaireQuiz)
            btnRefaireQuiz.onclick = () =>
            {
                const dataCat = qcmChemin[currentCat];
                questionHistory = [];
                currentJetons   = 0;
                prixChoisi      = null;
                currentQuestionId = dataCat.start;
                showQuestionById(currentQuestionId);
            };

        return;
    }

    // CAS : il l’achète
    resTitre.textContent = "C’est noté !";
    resTexte.textContent =
        "Tu as choisi d’acheter ce " + mots.objet +
        ". L’important est que tu aies pris ta décision en conscience.";

    popupConfirm.style.display = "none";

    btnResNo.textContent  = "Retour au menu";
    btnResYes.textContent = "Refaire le questionnaire";

    btnResNo.onclick = () =>
    {
        resetState();
        showSection("items");
    };

    btnResYes.onclick = () =>
    {
        const dataCat = qcmChemin[currentCat];
        questionHistory = [];
        currentJetons   = 0;
        prixChoisi      = null;
        currentQuestionId = dataCat.start;
        showQuestionById(currentQuestionId);
    };

    showSection("result");
}

// -----------------------------------------------------------
// BOUTON RETOUR GLOBAL
// -----------------------------------------------------------
btnBack.addEventListener("click", () =>
{
    if (currentView === "quiz")
    {
        if (questionHistory.length > 0)
        {
            const prev = questionHistory.pop();
            showQuestionById(prev);
        }
        else {
            showSection("intro");
        }
    }
    else if (currentView === "intro" || currentView === "result" || currentView === "bravo")
    {
        resetState();
        showSection("items");
    }
});
