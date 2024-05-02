<footer>
    <nav>
        <?php
       // Fonction pour le menu footer
        wp_nav_menu( array(
  'theme_location' => 'menu-pied-de-page',
  'container'      => 'false',
  'menu_class'     => 'footer-menu',
) );
?>

<!-- Fonction pour appeler le template contact-modal.php -->
<?php get_template_part('templates-parts/contact-modal'); ?>


<!-- Fonction pour appeler le template de la lightbox -->
<?php get_template_part('templates-parts/lightbox'); ?>

</nav>
    </footer>
    <?php wp_footer(); ?>
    
</body>
</html>
