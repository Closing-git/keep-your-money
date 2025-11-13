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
    } else if (viewName === "intro") 
    {
        sectionIntro.hidden = false;
    } else if (viewName === "quiz") 
    {
        sectionQuiz.hidden = false;
    } else if (viewName === "result") 
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

// Catégorie choisie 

let currentCat = null;

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

        showSection("intro");
    });
});
