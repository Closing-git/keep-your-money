// ----------------------------------------------
// Récupération des éléments du DOM
// ----------------------------------------------

// sections
const sectionItems   = document.getElementById("items-list");
const sectionIntro   = document.getElementById("intro-qcm");
const sectionQuiz    = document.getElementById("quiz");
const sectionResult  = document.getElementById("resultat");

// textes intro
const introTitre     = document.getElementById("intro-titre");
const introTexte     = document.getElementById("intro-texte");

// zone du qcm
const qTitre         = document.getElementById("q-titre");
const qChoixZone     = document.getElementById("q-choix");

// texte résultat
const resTexte       = document.getElementById("res-texte");

// boutons
const btnBack        = document.getElementById("btn-back");
const btnStart       = document.getElementById("btn-start");
const btnChangeCat   = document.getElementById("btn-change-cat");

// état de la page
let currentView = "items";
showSection("items");

// ------------------------------------------------
// Affichage des sections
// ------------------------------------------------
function showSection(viewName)
{
    sectionItems.hidden  = true;
    sectionIntro.hidden  = true;
    sectionQuiz.hidden   = true;
    sectionResult.hidden = true;

    if (viewName === "items")  sectionItems.hidden = false;
    if (viewName === "intro")  sectionIntro.hidden = false;
    if (viewName === "quiz")   sectionQuiz.hidden = false;
    if (viewName === "result") sectionResult.hidden = false;

    currentView = viewName;
}

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
    collations: 
    {
        titre: "Tu aimerais acheter des collations",
        texte: "On va vérifier si tu en as vraiment besoin ou si c’est juste une envie du moment."
    },
    meubles: 
    {
        titre: "Tu aimerais acheter un nouveau meuble",
        texte: "On va vérifier si ce meuble est indispensable ou juste une envie de déco."
    },
    loisirs: 
    {
        titre: "Tu aimerais acheter quelque chose pour tes loisirs",
        texte: "In coming…"
    }
};

// ------------------------------------------------
// Mots dynamiques (remplace {objet}, {conteneur}, {type})
// ------------------------------------------------
const motsCategorie = {
    livres:      { objet: "livre",      type: "livre",      conteneur: "bibliothèque" },
    vetements:   { objet: "vêtement",   type: "vêtement",   conteneur: "armoire" },
    jeux:        { objet: "jeu vidéo",  type: "jeu vidéo",  conteneur: "collection" },
    meubles:     { objet: "meuble",     type: "meuble",     conteneur: "maison" },
    collations:  { objet: "collation",  type: "collation",  conteneur: "cuisine" }
};

// -----------------------------------------------------------
// CHEMIN QCM – AVEC TOUTES LES QUESTIONS/TEXTES DYNAMIQUES
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
                    { label: "Non, aucun risque", next: "q4"   }
                ]
            },

            // q4 - envie ancienne
            q4:
            {
                texte: "Est-ce un {objet} que tu souhaites depuis un moment ?",
                choix: [
                    { label: "Oui",                     next: "q5" },
                    { label: "C’est un désir spontané", next: "q41" }
                ]
            },

            // q41 - impulsif
            q41:
            {
                texte: "C’est un désir spontané. Tu veux attendre un peu pour voir si tu en as vraiment envie ?",
                choix: [
                    { label: "Oui, j’attends",         next: "res_envie" },
                    { label: "Non, je veux continuer", next: "q42" }
                ]
            },

            // q42 - usage réel
            q42:
            {
                texte: "Penses-tu vraiment utiliser ce {objet}, ou va-t-il juste rester dans ton/ta {conteneur} ?",
                choix: [
                    { label: "Oui, je vais l’utiliser", next: "q5" },
                    { label: "Non, probablement pas",   next: "res_usage" }
                ]
            },

            // q5 - similaire ?
            q5:
            {
                texte: "As-tu déjà un {objet} similaire ?",
                choix: [
                    { label: "Oui", next: "q50" },
                    { label: "Non", next: "q6" }
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
                    { label: "Joie",       next: "q5" },
                    { label: "Calme",      next: "q5" }
                ]
            },

            // q61
            q61:
            {
                texte: "Cet achat va-t-il réellement améliorer cette humeur ?",
                choix: [
                    { label: "Oui", next: "q50" },
                    { label: "Non", next: "res_humeur" }
                ]
            },

            // q50 - quantité
            q50:
            {
                texte: "En quelle quantité possèdes-tu déjà ce type de {objet} ?",
                choix: [
                    { label: "1",             next: "q90" },
                    { label: "1 à 3",         next: "q90" },
                    { label: "3 à 5",         next: "q90" },
                    { label: "10 ou plus",    next: "res_trop" },
                    { label: "Encore plus",   next: "res_pas_utilise" }
                ]
            },

            // q90 - fin
            q90:
            {
                texte: "Alors… tu l’as acheté ?",
                choix: [
                    { label: "Oui", next: "res_ok" },
                    { label: "Non", next: "res_jetons" }
                ]
            }
        },

        // résultats
        results:
        {
            res_biblio:
                "Voilà ce que je te propose : regarde si tu peux l’emprunter ou le récupérer autrement. Si ça te plaît vraiment, tu pourras l’acheter plus tard.",

            res_envie:
                "C’était un désir spontané. Attendre quelques jours est souvent une bonne idée avant d’acheter.",

            res_usage:
                "Demande-toi si tu vas vraiment l’utiliser ou si cela restera dans un coin.",

            res_humeur:
                "Si cet achat n’aide pas vraiment ton humeur, ce n’est peut-être pas le bon moment.",

            res_trop:
                "Tu en as déjà beaucoup. Peut-être utiliser ceux que tu as avant d’en acheter un nouveau.",

            res_pas_utilise:
                "Tu as déjà des objets similaires que tu utilises peu. Profite peut-être de ceux-là avant d’en racheter.",

            res_ok:
                "Ton achat semble cohérent. Tu peux acheter sans culpabiliser.",

            res_jetons:
                "Bravo ! Tu ne l’as pas acheté. Tu gagnes des jetons virtuels."
        }
    }
};

// Les autres catégories réutilisent le même QCM
qcmChemin.vetements  = qcmChemin.livres;
qcmChemin.jeux       = qcmChemin.livres;
qcmChemin.meubles    = qcmChemin.livres;
qcmChemin.collations = qcmChemin.livres;

// -----------------------------------------------------------
// VARIABLES ÉTAT QCM
// -----------------------------------------------------------
let currentCat = null;
let currentQuestionId = null;
let questionHistory = [];
let currentJetons = 0;

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

        showSection("intro");
    });
});

// -----------------------------------------------------------
// BOUTON : changer de catégorie
// -----------------------------------------------------------
btnChangeCat.addEventListener("click", () =>
{
    currentCat = null;
    currentQuestionId = null;
    questionHistory = [];
    currentJetons = 0;

    showSection("items");
});

// -----------------------------------------------------------
// BOUTON : commencer le QCM
// -----------------------------------------------------------
btnStart.addEventListener("click", () =>
{
    if (!currentCat) return;

    const dataCat = qcmChemin[currentCat];

    if (!dataCat || !dataCat.start)
    {
        resTexte.textContent = "In coming…";
        showSection("result");
        return;
    }

    questionHistory = [];
    currentJetons = 0;

    currentQuestionId = dataCat.start;
    showQuestionById(currentQuestionId);
});

// -----------------------------------------------------------
// AFFICHER QUESTION
// -----------------------------------------------------------
function showQuestionById(questionId)
{
    const dataCat = qcmChemin[currentCat];
    const question = dataCat.questions[questionId];

    currentQuestionId = questionId;

    // remplacement des mots dynamiques
    const mots = motsCategorie[currentCat];

    let texte = question.texte
        .replaceAll("{objet}", mots.objet)
        .replaceAll("{conteneur}", mots.conteneur)
        .replaceAll("{type}", mots.type);

    qTitre.textContent = texte;

    // Boutons
    qChoixZone.innerHTML = "";

    question.choix.forEach((c) =>
    {
        const btn = document.createElement("button");
        btn.textContent = c.label;

        btn.addEventListener("click", () =>
        {
            if (typeof c.jetons === "number")
                currentJetons = c.jetons;

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

    // cas jetons
    if (nextKey === "res_jetons")
    {
        const mots = motsCategorie[currentCat];
        resTexte.textContent =
            "Bravo, tu as décidé de ne pas acheter ce " + mots.objet +
            ". Tu gagnes " + currentJetons + " jetons virtuels !";

        showSection("result");
        return;
    }

    // cas résultat normal
    if (nextKey.startsWith("res_"))
    {
        const mots = motsCategorie[currentCat];
        let texte = dataCat.results[nextKey];

        texte = texte
            .replaceAll("{objet}", mots.objet)
            .replaceAll("{conteneur}", mots.conteneur)
            .replaceAll("{type}", mots.type);

        resTexte.textContent = texte;
        showSection("result");
        return;
    }

    // question suivante
    showQuestionById(nextKey);
}

// -----------------------------------------------------------
// BOUTON RETOUR
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
        else showSection("intro");
    }
    else if (currentView === "intro" || currentView === "result")
    {
        currentCat = null;
        currentQuestionId = null;
        questionHistory = [];
        currentJetons = 0;

        showSection("items");
    }
});
