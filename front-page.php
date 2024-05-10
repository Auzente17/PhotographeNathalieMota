<?php get_header(); ?>

<?php get_template_part('templates-parts/hero'); ?>


    <!-- Section pour les filtres -->
    <section id="filtres-section"> 
      <?php get_template_part('templates-parts/filtres'); ?>
    </section>

    <!-- Section pour afficher la liste de photos -->
    <section id="liste__photo" class="photo-grid">
    <?php
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 8,
    'orderby' => 'date',
    'order' => 'DESC',
);
$query = new WP_Query($args);
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        get_template_part('templates-parts/block-photo', get_post_format());
    endwhile;
    wp_reset_postdata();
endif;
?>
    </section>

<div id="load-more-container">
    <!-- Bouton pour charger plus de photos -->
    <button id="load-more-btn" class="load-more-btn" data-offset="8">Charger plus</button>
</div>
 
<?php get_footer(); ?>