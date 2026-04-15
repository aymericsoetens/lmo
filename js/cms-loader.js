// Chargeur de contenu dynamique pour La Main Occulte
// Ce script lit les fichiers JSON générés par le CMS

const CMSLoader = {
    // Configuration
    config: {
        galeriePath: '/_data/galerie/',
        videosPath: '/_data/videos/'
    },

    // Extrait l'ID d'une URL YouTube
    getYouTubeId: function(url) {
        if (!url) return null;
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    },

    // Charge toutes les photos
    chargerPhotos: async function() {
        try {
            // On liste tous les fichiers JSON dans le dossier galerie
            const response = await fetch('/_data/galerie/index.json');
            if (!response.ok) throw new Error('Galerie non trouvée');
            const albums = await response.json();
            
            let toutesLesPhotos = [];
            for (const album of albums) {
                if (album.photos && album.photos.length) {
                    toutesLesPhotos = toutesLesPhotos.concat(album.photos);
                }
            }
            return toutesLesPhotos;
        } catch (error) {
            console.log('📸 Mode démo : pas encore de photos ajoutées');
            return [];
        }
    },

    // Charge toutes les vidéos
    chargerVideos: async function() {
        try {
            const response = await fetch('/_data/videos/videos.json');
            if (!response.ok) throw new Error('Vidéos non trouvées');
            const videos = await response.json();
            return Array.isArray(videos) ? videos : [];
        } catch (error) {
            console.log('🎬 Mode démo : pas encore de vidéos ajoutées');
            return [];
        }
    },

    // Affiche les photos dans un conteneur
    afficherPhotos: async function(conteneurId) {
        const conteneur = document.getElementById(conteneurId);
        if (!conteneur) return;

        const photos = await this.chargerPhotos();
        if (photos.length === 0) {
            conteneur.innerHTML = '<div class="no-content">✨ Aucune photo pour le moment. Connectez-vous à /admin/ pour en ajouter !</div>';
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

    // Affiche les vidéos dans un conteneur
    afficherVideos: async function(conteneurId) {
        const conteneur = document.getElementById(conteneurId);
        if (!conteneur) return;

        const videos = await this.chargerVideos();
        if (videos.length === 0) {
            conteneur.innerHTML = '<div class="no-content">🎬 Aucune vidéo pour le moment. Connectez-vous à /admin/ pour en ajouter !</div>';
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

// Auto-initialisation quand la page est chargée
document.addEventListener('DOMContentLoaded', function() {
    // Si on est sur la page galerie
    if (document.querySelector('.galerie-photos-container')) {
        CMSLoader.afficherPhotos('galerie-photos');
    }
    if (document.querySelector('.galerie-videos-container')) {
        CMSLoader.afficherVideos('galerie-videos');
    }
});

// Exporter pour utilisation globale
window.CMSLoader = CMSLoader;