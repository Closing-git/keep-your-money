document.addEventListener('DOMContentLoaded', () => {
    const fonds = document.querySelectorAll('.gardeRobe a[data-image]');
    const zoneAvatar = document.querySelector('.zoneAvatar img');
    const btnSave = document.querySelector('#Sauvegarder');

    fonds.forEach(fond => {
        fond.addEventListener('click', function(e) {
            e.preventDefault(); 
            const image = this.dataset.image;
            zoneAvatar.src = image; 
        });
    });

    btnSave.addEventListener('click', () => {
        // Récupère uniquement le nom du fichier, pas le chemin complet
        const fondActuel = zoneAvatar.src.split('/').pop(); 

        fetch("{{ path('app_mon_avatar_sauvegarder') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ fond: fondActuel })
        })
        .then(r => r.json())
        .then(response => alert(response.message))
        .catch(err => {
            console.error(err);
            alert("Erreur lors de la sauvegarde.");
        });
    });
});
