<?php get_header(); ?>

<?php get_template_part('templates-parts/hero'); ?>

<section id="liste__photo" class="photo-grid">
    <?php get_template_part('templates-parts/liste-photos'); ?>
</section>


<div id="btn-container">
<button class="load-more-btn" data-offset= "8">Charger plus</button>
</div>
 
<?php get_footer(); ?>