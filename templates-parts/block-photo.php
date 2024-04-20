<?php
// Pour récupérer  l'ID de la photo
$photoId = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large'); $photoUrl =$photoId[0];

if ($photoId !== false) {
    $photoUrl = $photoId[0];
    // Le reste du code pour afficher l'image
} else {
    // Afficher un message d'erreur ou une image par défaut
}

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
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icon_eye.png" alt="Voir la photo">
            </a>
        </div>

        <!-- Ajout de l'icône fullscreen avec des attributs de données -->
        <div class="icon-fullscreen" data-full="<?php echo esc_attr($photoId); ?>" data-category="<?php echo esc_attr($categorie); ?>" data-reference="<?php echo esc_attr($reference); ?>">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/Icon_fullscreen.png" alt="Icone fullscreen">
        </div>
    </div>
</div>