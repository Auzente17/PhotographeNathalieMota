<?php
// Template Name: Hero Template
// Description: Modèle d'affichage de la section héros de la page d'accueil

get_header();

// Récupérer l'URL de l'image d'arrière-plan aléatoire
$background_image_url = get_random_background_image();
?>

<section class="hero" style="background-image: url('<?php echo $background_image_url; ?>');">
    <div class="hero__content">
        <h1><?php echo get_field('hero_title'); ?></h1>
        <!-- Autres éléments de la bannière héros -->
    </div>
</section>

