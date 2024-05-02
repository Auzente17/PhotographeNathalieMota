<!-- Structure HTML de la lightbox -->
<div id="lightbox" class="lightbox">
    <!-- Overlay sombre qui s'affiche en arrière plan de la lightbox -->
    <div class="lightbox-overlay"></div>
    <div class="lightbox-content">
        <!-- Bouton de fermeture de la lightbox -->
        <img class="lightbox-close" src="<?= get_stylesheet_directory_uri() . '/assets/images/white-cross.svg'; ?>" alt="croix" loading="eager">
        <!-- Conteneur de l'image de la lightbox -->
        <div class="lightbox-image-container">
            <!-- Image affichée dans la lightbox -->
            <img id="lightbox-image" classe="lightbox-image" src="" alt="">
        </div>
        <!-- Conteneur de la légende de l'image -->
        <div class="lightbox-caption" id="lightbox-caption">
            <!-- Référence de l'image -->
            <span class="lightbox-reference"></span>
            <!-- Catégorie de l'image -->
            <span class="lightbox-category"></span>
        </div>
        <!-- Conteneur de la navigation entre les images -->
        <div class="lightbox-navigation">
            <!-- Bouton pour afficher l'image précédente -->
            <span class="lightbox-previous">&#8592; Précédente</span>
            <!-- Bouton pour afficher l'image suivante -->
            <span class="lightbox-next">Suivante &#8594;</span>
        </div>
    </div>
</div>