<?php
	get_header();
	?>
  
  <div class="entry-content">
        <?php
            the_content();  // Affiche le contenu de la page

            wp_link_pages( array(  
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'textdomain'),
                'after'  => '</div>',
            ) );
        ?>
    </div><!-- .entry-content -->


  

<?php get_footer(); ?>