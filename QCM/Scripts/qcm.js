//Récupération des éléments du DOM

//1 récupération des sections

const sectionItems   = document.getElementById("items-list");
const sectionIntro   = document.getElementById("intro-qcm");
const sectionQuiz    = document.getElementById("quiz");
const sectionResult  = document.getElementById("resultat");

// 2 récupération des textes de l'intro

const introTitre     = document.getElementById("intro-titre");
const introTexte     = document.getElementById("intro-texte");

// 3 récupération des zones du qcm

const qTitre         = document.getElementById("q-titre");
const qChoixZone     = document.getElementById("q-choix");

// 4 récupération des textes du résultat

const resTexte       = document.getElementById("res-texte");

// 5 récupération des boutons

const btnBack        = document.getElementById("btn-back");
const btnStart       = document.getElementById("btn-start");
const btnChangeCat   = document.getElementById("btn-change-cat");

// Etat de la page - pour savoir dans quelle section on est 

let currentView = "items";

// Catégorie choisie 

let currentCat = null;

// début du qcm - logique du qcm 

let currentQuestionId = null; 
let questionHistory   = [];

// nombre de jetons gagnés si la personne renonce à l'achat

let currentJetons     = 0;


// Affichage des sections 

function showSection(viewName) 
{
    // Tout cacher
    sectionItems.hidden  = true;
    sectionIntro.hidden  = true;
    sectionQuiz.hidden   = true;
    sectionResult.hidden = true;

    // Afficher selon le nom demandé
    if (viewName === "items") 
    {
        sectionItems.hidden = false;
    } 
    else if (viewName === "intro") 
    {
        sectionIntro.hidden = false;
    } 
    else if (viewName === "quiz") 
    {
        sectionQuiz.hidden = false;
    } 
    else if (viewName === "result") 
    {
        sectionResult.hidden = false;
    }

    currentView = viewName;
}

// affichage de base: les items

showSection("items");

// texte d'intro en fonction du thèmes

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
        texte: "Regardons si ce jeu est vraiment nécessaire ou juste un énième jeu dans ta bibliothèque."
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
        texte: "Regardons si cet achat va vraiment être utilisé ou finir dans un tiroir."
    }
};

// mot utilisé dans les questions/résultats selon la catégorie

const objetLabels = {
    livres:     "livre",
    vetements:  "vêtement",
    meubles:    "meuble",
    jeux:       "jeu-vidéo",
    collations: "collation",
    loisirs:    "activité de loisir"
};

// chemin qcm + questions + choix 

const qcmChemin = {

    // modèle de qcm commun (livres, vetements, etc.)

    livres: 
    {
        start: "q1",
        questions: 
        {
            // 1. Quel est son prix ?

            q1: {
                texte: "Quel est le prix de cet {{objet}} ?",
                choix: [
                    { label: "0–10 €",        next: "q2", jetons: 10 },
                    { label: "10–20 €",       next: "q2", jetons: 20 },
                    { label: "20–30 €",       next: "q3", jetons: 30 },
                    { label: "Plus de 30 €",  next: "q3", jetons: 40 }
                ]
            },

            // 2. Combien à tu dépensé en loisir/plaisir cette semaine ?

            q2: 
            {
                texte: "Combien as-tu déjà dépensé en loisir / plaisir cette semaine ?",
                choix: [
                    { label: "0–10 €",        next: "q3" },
                    { label: "10–20 €",       next: "q3" },
                    { label: "20–30 €",       next: "q4" },
                    { label: "30–50 €",       next: "res_non" },
                    { label: "Plus de 50 €",  next: "res_non" }
                ]
            },

            // 3. Cet achat pourrait-il t'empêcher de payer ... ?

            q3: 
            {
                texte: "Cet achat pourrait-il t'empêcher de payer quelque chose de plus utile cette semaine, ce mois-ci ou cette année (facture, réparation, sortie prévue depuis longtemps...) ?",
                choix: [
                    { label: "Non, aucun risque",                  next: "q4" },
                    { label: "Oui, ça pourrait poser problème",    next: "res_non" }
                ]
            },

            // 4. Est-ce un {{objet}} que tu souhaites depuis un moment ?

            q4: 
            {
                texte: "Est-ce un {{objet}} que tu souhaites depuis un moment ?",
                choix: [
                    { label: "Oui",                     next: "q5" },
                    { label: "C’est un désir spontané", next: "res_maybe" }
                ]
            },

            // 5. As-tu déjà un {{objet}} similaire ?

            q5: 
            {
                texte: "As-tu déjà un {{objet}} similaire ?",
                choix: [
                    { label: "Oui", next: "q6" },
                    { label: "Non", next: "q6" }
                ]
            },

            // 6. Dans quelles émotions es-tu ?

            q6: 
            {
                texte: "Dans quelles émotions es-tu au moment où tu veux acheter cet {{objet}} ?",
                choix: [
                    { label: "Stress",     next: "res_non" },
                    { label: "Colère",     next: "res_non" },
                    { label: "Fatigue",    next: "res_maybe" },
                    { label: "Tristesse",  next: "res_maybe" },
                    { label: "Joie",       next: "q8" },
                    { label: "Calme",      next: "q8" }
                ]
            },

            // 8. Alors tu l’as acheté ?

            q8:
            {
                texte: "Alors, finalement, as-tu acheté cet {{objet}} ?",
                choix: [
                    { label: "Oui",  next: "res_ok" },
                    { label: "Non",  next: "res_jetons" }
                ]
            }

            // TODO : tu pourras ajouter d'autres questions (quantité, propositions, etc.)
        },
        results: 
        {
            res_ok:
                "Cet achat de {{objet}} semble raisonnable : il te fait du bien et reste cohérent avec ton budget.",
            res_maybe:
                "Cet achat de {{objet}} n’est pas indispensable. Réfléchis encore un peu avant de te décider.",
            res_non:
                "Ce {{objet}} ne semble pas être un vrai besoin pour le moment. Tu peux garder ton argent.",
            // Pour res_jetons, le texte est généré dynamiquement en JS
            res_jetons:
                ""
        }
    }
};

// Réutiliser le même qcm pour les autres catégories

qcmChemin.vetements  = qcmChemin.livres;
qcmChemin.meubles    = qcmChemin.livres;
qcmChemin.jeux       = qcmChemin.livres;
qcmChemin.collations = qcmChemin.livres;


// Click sur bouton d'un item

const itemButtons = document.querySelectorAll("#items-list button[data-cat]");

itemButtons.forEach((btn) => 
{
    btn.addEventListener("click", () => {
        const catKey = btn.dataset.cat;  // ex : "vetements"
        currentCat = catKey;

        const data = introData[catKey];
        introTitre.textContent = data.titre;
        introTexte.textContent = data.texte;

        // reset de l'état du qcm quand on change de catégorie
        currentQuestionId = null;
        questionHistory   = [];
        currentJetons     = 0;

        showSection("intro");
    });
});

// Bouton changer de catégorie 

btnChangeCat.addEventListener("click", () => 
{
    currentCat        = null;
    currentQuestionId = null;
    questionHistory   = [];
    currentJetons     = 0;

    showSection("items");
});

// Bouton commencement du qcm

btnStart.addEventListener("click", () => {
    if (!currentCat) return;

    const dataCat = qcmChemin[currentCat];

    // Catégorie non encore traitée (sécurité)
    if (!dataCat || !dataCat.start) {
        resTexte.textContent = "In coming…";
        showSection("result");
        return;
    }

    // Catégorie prête → lancer le QCM
    questionHistory   = [];
    currentQuestionId = dataCat.start;
    currentJetons     = 0;

    showQuestionById(currentQuestionId);
});

// Afficher une question selon son id (q1, q2, q3, ...)

function showQuestionById(questionId) {
    const dataCat = qcmChemin[currentCat];
    if (!dataCat) {
        console.warn("Pas de QCM pour la catégorie", currentCat);
        return;
    }

    const question = dataCat.questions[questionId];
    if (!question) {
        console.warn("Question inconnue :", questionId);
        return;
    }

    currentQuestionId = questionId;

    const labelObjet = objetLabels[currentCat] || "objet";
    const texteQuestion = question.texte.replaceAll("{{objet}}", labelObjet);

    qTitre.textContent = texteQuestion;
    qChoixZone.innerHTML = "";

    question.choix.forEach((c) => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.textContent = c.label;

        btn.addEventListener("click", () => {

            // si cette réponse définit un nombre de jetons, on le mémorise

            if (typeof c.jetons === "number") {
                currentJetons = c.jetons;
            }

            onAnswer(c.next);
        });

        qChoixZone.appendChild(btn);
    });

    showSection("quiz");
}

// quand on choisit une réponse

function onAnswer(nextKey) {
    const dataCat = qcmChemin[currentCat];
    if (!dataCat) return;

    // On mémorise la question actuelle dans l'historique

    if (currentQuestionId) {
        questionHistory.push(currentQuestionId);
    }

    // Cas spécial : résultat avec gain de jetons

    if (nextKey === "res_jetons") {
        const labelObjet = objetLabels[currentCat] || "objet";
        resTexte.textContent = 
            "Bravo, tu as décidé de ne pas acheter ce " + labelObjet +
            ". Tu gagnes " + currentJetons + " jetons virtuels !";
        showSection("result");
        return;
    }

    // Si c'est un résultat final classique (res_ok, res_maybe, res_non)

    if (typeof nextKey === "string" && nextKey.startsWith("res_")) {
        const labelObjet = objetLabels[currentCat] || "objet";
        let texte = dataCat.results[nextKey] || "Fin du quiz.";
        texte = texte.replaceAll("{{objet}}", labelObjet);
        resTexte.textContent = texte;
        showSection("result");
        return;
    }

    // Sinon -> avancer vers la prochaine question

    showQuestionById(nextKey);
}

// bouton retour 

btnBack.addEventListener("click", () => 
{
    // Si on est dans le qcm -> revenir à la question précédente si possible
    if (currentView === "quiz") 
    {
        if (questionHistory.length > 0) 
        {
            // On récupère la dernière question visitée
            const previousQuestionId = questionHistory.pop();
            showQuestionById(previousQuestionId);
        } 
        else 
        {
            // Pas d'historique -> retour à l'intro
            showSection("intro");
        }
    } 
    // Si on est sur l'intro -> retour à la liste des catégories
    else if (currentView === "intro") 
    {
        currentCat        = null;
        currentQuestionId = null;
        questionHistory   = [];
        currentJetons     = 0;

        showSection("items");
    } 
    // Si on est sur le résultat -> retour à la liste des catégories
    else if (currentView === "result") 
    {
        currentCat        = null;
        currentQuestionId = null;
        questionHistory   = [];
        currentJetons     = 0;

        showSection("items");
    } 
    else 
    {
        // Si on est déjà sur la liste des items -> rien à faire
    }
});
