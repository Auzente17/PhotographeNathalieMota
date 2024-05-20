<?php
// Pour récupérer l'URL de la photo
$photoUrl = get_the_post_thumbnail_url(get_the_ID(), 'large'); 

// vérifier si l'URL de l'image mise en avant a été récupéré avec succès
if ($photoUrl) {
       
   
// Pour récupérer le titre de la photo
$title_photo = get_the_title();

// Pour récupérer l'URL du post
$url_post = get_permalink();

// Pour récupérer la référence de la photo
$reference = get_field('reference');


// Pour récupérer les catégories de la photo
$categories = get_the_terms(get_the_ID(), 'categorie');
$categorie = !empty($categories) ? $categories[0]->name : '';

// Affichage du bloc de photo
?>

<div class="block__photo">
    <!-- Affichage de la photo avec son URL et son attribut alt -->
    <img src="<?php echo esc_url($photoUrl); ?>" alt="<?php the_title_attribute(); ?>">

    <div class="overlay">
        <!-- Affichage du titre de la photo -->
        <h2><?php echo esc_html($title_photo); ?></h2>

        <?php if (!empty($categorie)) : ?>
            <!-- Affichage de la catégorie si elle existe -->
            <h3><?php echo esc_html($categorie); ?></h3>
        <?php endif; ?>

        <!-- Ajout de l'icône pour voir la photo en détail -->
        <div class="eye-icon">
            <a href="<?php echo esc_url($url_post); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icon_eye.svg" alt="Voir la photo">
            </a>
        </div>

        <!-- Ajout de l'icône fullscreen avec des attributs de données -->
        <div class="icon-fullscreen" data-full ="<?php echo esc_attr($photoUrl); ?>" data-category ="<?php echo esc_attr($categorie); ?>" data-reference="<?php echo esc_attr($reference); ?>">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/Icon_fullscreen.svg" alt="Voir l'image en plein écran">
        </div>
    </div>
</div>

<?php
} else {
    //  l'URL de l'image n'a pas pu être récupérée
    echo 'Aucune URL d\'image trouvée.<br>';
}
