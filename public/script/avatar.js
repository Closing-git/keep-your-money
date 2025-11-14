document.addEventListener('DOMContentLoaded', () => {
    // Sélection des éléments
    const fonds = document.querySelectorAll('.gardeRobe a[data-image]');
    const accessoires = document.querySelectorAll('.accessoires a[data-image]');
    const fond= document.querySelector('#fond');
    const accessoireContainer= document.querySelector('#accessoireContainer');
    const zoneAvatar = document.querySelector('.zoneAvatar img');
    const btnSave = document.querySelector('#Sauvegarder');
    
    fonds.forEach(fond => {
        fond.addEventListener('click', function(e) {
            e.preventDefault();
            if (zoneAvatar) {
                zoneAvatar.src = this.dataset.image;
            }
        });
    });

    
    accessoires.forEach(accessoire => {
        accessoire.addEventListener('click', function(e) {
            e.preventDefault();
            const imageUrl = this.dataset.image;
            
            // Vérifie si l'accessoire est déjà présent
            const existingAccessory = document.querySelector(`.zoneAvatar img[src="${imageUrl}"]`);
            
            if (!existingAccessory && zoneAvatar) {
                // Crée une nouvelle image pour l'accessoire
                const newAccessory = document.createElement('img');
                newAccessory.src = imageUrl;
                newAccessory.className = 'accessory';
                document.querySelector('.zoneAvatar').appendChild(newAccessory);
            }
        });
    });

    btnSave.addEventListener('click', () => {
        if (!zoneAvatar) return;
        
        // Récupère uniquement le nom du fichier, pas le chemin complet
        const fondActuel = zoneAvatar.src.split('/').pop(); 
        const accessoires = [];
        
        // Récupère tous les accessoires
        document.querySelectorAll('.zoneAvatar .accessory').forEach(acc => {
            accessoires.push(acc.src.split('/').pop());
        });

        fetch("{{ path('app_mon_avatar_sauvegarder') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                fond: fondActuel,
                accessoires: accessoires
            })
        })
        .then(r => r.json())
        .then(response => alert(response.message))
        .catch(err => {
            console.error('Erreur:', err);
            alert("Erreur lors de la sauvegarde.");
        });
    });
});
