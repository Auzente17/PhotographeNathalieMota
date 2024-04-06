<?php
/*
Template Name: Page personnalisée
*/


get_header();
?>


<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->


            <?php the_content(); ?>
        </article><!-- #post-<?php the_ID(); ?> -->
    <?php
    endwhile; // End of the loop.
    ?>
</main><!-- #main -->


<?php
get_footer();
