<?php get_header(); ?>

<?php get_template_part('templates-parts/hero'); ?>

<section id="liste__photo" class="photo-grid">
    <?php get_template_part('templates-parts/liste-photos'); ?>
</section>

<div id="btn-container">
<button id="load-more-btn" data-offset="0">Charger plus</button>
</div>

<?php get_footer(); ?>