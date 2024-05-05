<?php
// Définition des taxonomies et de leurs libellés
$taxonomy_labels = [
    'categorie' => 'CATÉGORIES',
    'format' => 'FORMATS',
    'annees' => 'TRIER PAR',
];

// Début du conteneur des filtres
echo "<div class='filtres-container'>";

// Section des filtres catégorie et format à gauche
echo "<div class='filters-left'>";

// Boucle sur les taxonomies pour la section gauche (catégorie et format)
foreach ($taxonomy_labels as $taxonomy_slug => $label) {
    // Je retire 'annees' de la section gauche
    if ($taxonomy_slug !== 'annees') {
        // Je récupère les termes de la taxonomie
        $terms = get_terms($taxonomy_slug);

        // Je vérifie si des termes existent et qu'il n'y a pas d'erreur WordPress
        if ($terms && !is_wp_error($terms)) {
            // J'ajoute une classe CSS spécifique pour chaque select
            $select_class = 'custom-select ' . $taxonomy_slug . '-select';

            // Début du conteneur pour la taxonomie
            echo "<div class='taxonomy-container'>";
            // J'affiche le select avec l'ID et la classe appropriée
            echo "<select id='$taxonomy_slug' class='$select_class'>";
            // Option par défaut avec le label de la taxonomie
            echo "<option value=''>$label</option>";

            // J'affiche chaque terme comme une option
            foreach ($terms as $term) {
                echo "<option value='$term->slug'>$term->name</option>";
            }

            // Fin du select 
            echo "</select>";
            // Fin du conteneur pour la taxonomie
            echo "</div>";
        }
    }
}

// Fin de la section des filtres catégorie et format à gauche
echo "</div>";

// Section du filtre "trier par" à droite
echo "<div class='filters-right'>";
// Début du conteneur pour la taxonomie 'annees'
echo "<div class='taxonomy-container'>";
// J'affiche le select avec l'ID et la classe appropriée
echo "<select id='annees' class='custom-select annees-select'>";
// Options spécifiques pour 'annees'
echo "<option value=''>{$taxonomy_labels['annees']}</option>";
echo "<option value='date_asc'>A partir des plus récentes</option>";
echo "<option value='date_desc'>A partir des plus anciennes</option>";
// Fin du select 
echo "</select>";
// Fin du conteneur pour la taxonomie 'annees'
echo "</div>";
// Fin de la section du filtre trier par à droite
echo "</div>";

// Fin du conteneur filtres-container
echo "</div>";

// J'ajoute le code JavaScript pour le filtrage des photos
echo "<script type='text/javascript'>
        jQuery(document).ready(function($) {
            // Je récupère les valeurs des filtres sélectionnés
            function getFilterValues() {
                var filters = {};
                $('.custom-select').each(function() {
                    var selectId = $(this).attr('id');
                    var selectValue = $(this).val();
                    if (selectValue !== null && selectValue !== '') {
                        filters[selectId] = selectValue;
                    }
                });
                return filters;
            }

            // Je charge les photos en fonction des filtres sélectionnés
            function loadPhotos() {
                // Je récupère les valeurs des filtres sélectionnés
                var filters = getFilterValues();
                // J'envoie une requête AJAX au serveur
                $.ajax({
                    url: '".admin_url('admin-ajax.php')."',
                    type: 'POST',
                    data: {
                        action: 'filter_photos',
                        filters: filters
                    },
                    success: function(response) {
                        // J'affiche les photos filtrées
                        $('#liste__photo').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // J'écoute les changements sur les filtres
            $('.custom-select').on('change', function() {
                loadPhotos();
            });

            // Je charge les photos au chargement de la page
            loadPhotos();
        });
      </script>";