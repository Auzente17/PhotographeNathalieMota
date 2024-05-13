<?php get_header(); ?>

<?php get_template_part('templates-parts/hero'); ?>


    <!-- Section pour les filtres -->
    <section id="filtres-section"> 
      <?php get_template_part('templates-parts/filtres'); ?>
    </section>

    <!-- Section pour afficher la liste de photos -->
    <section id="liste__photo" class="photo-grid">
        <?php get_template_part('templates-parts/liste-photos'); ?>
    </section>

<div id="load-more-container">
    <!-- Bouton pour charger plus de photos -->
    <button id="load-more-btn" class="load-more-btn" data-offset="8">Charger plus</button>
</div>
 
<?php get_footer(); ?>