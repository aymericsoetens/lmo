// Chargeur de contenu dynamique pour La Main Occulte
// Lit les fichiers JSON générés par le CMS

const CMSLoader = {
    // Extrait l'ID d'une URL YouTube
    getYouTubeId: function(url) {
        if (!url) return null;
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    },

    // Charge toutes les photos depuis photos.json
    chargerPhotos: async function() {
        try {
            const response = await fetch('/_data/photos.json');
            if (!response.ok) throw new Error('Fichier photos non trouvé');
            const data = await response.json();
            return data.photos || [];
        } catch (error) {
            console.log('📸 Aucune photo pour le moment');
            return [];
        }
    },

    // Charge toutes les vidéos depuis videos.json
    chargerVideos: async function() {
        try {
            const response = await fetch('/_data/videos.json');
            if (!response.ok) throw new Error('Fichier vidéos non trouvé');
            const data = await response.json();
            return data.videos || [];
        } catch (error) {
            console.log('🎬 Aucune vidéo pour le moment');
            return [];
        }
    },

    // Affiche les photos
    afficherPhotos: async function(conteneurId) {
        const conteneur = document.getElementById(conteneurId);
        if (!conteneur) return;

        const photos = await this.chargerPhotos();
        if (photos.length === 0) {
            conteneur.innerHTML = '<div class="no-content">✨ Aucune photo pour le moment. Connectez-vous à <a href="/admin/">l\'administration</a> pour en ajouter !</div>';
            return;
        }

        let html = '<div class="galerie-grid">';
        photos.forEach(photo => {
            html += `
                <div class="galerie-item">
                    <img src="${photo.url}" alt="${photo.legende || 'Photo'}" loading="lazy">
                    ${photo.legende ? `<p class="legende">${photo.legende}</p>` : ''}
                </div>
            `;
        });
        html += '</div>';
        conteneur.innerHTML = html;
    },

    // Affiche les vidéos
    afficherVideos: async function(conteneurId) {
        const conteneur = document.getElementById(conteneurId);
        if (!conteneur) return;

        const videos = await this.chargerVideos();
        if (videos.length === 0) {
            conteneur.innerHTML = '<div class="no-content">🎬 Aucune vidéo pour le moment. Connectez-vous à <a href="/admin/">l\'administration</a> pour en ajouter !</div>';
            return;
        }

        let html = '<div class="videos-grid">';
        videos.forEach(video => {
            const videoId = this.getYouTubeId(video.url);
            if (videoId) {
                html += `
                    <div class="video-item">
                        <div class="video-wrapper">
                            <iframe 
                                src="https://www.youtube.com/embed/${videoId}" 
                                title="${video.titre}"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                        <h4>${video.titre}</h4>
                        ${video.description ? `<p>${video.description}</p>` : ''}
                    </div>
                `;
            }
        });
        html += '</div>';
        conteneur.innerHTML = html;
    }
};

// Auto-initialisation
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('galerie-photos')) {
        CMSLoader.afficherPhotos('galerie-photos');
    }
    if (document.getElementById('galerie-videos')) {
        CMSLoader.afficherVideos('galerie-videos');
    }
});

window.CMSLoader = CMSLoader;