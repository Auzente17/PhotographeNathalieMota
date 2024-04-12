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

<!-- Fonction pour appeler le fichier contact-modal.php -->
<?php get_template_part('templates-parts/contact-modal'); ?>


</nav>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
