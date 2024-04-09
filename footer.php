<footer>
    <nav>
        <?php
        // Ajouter pied de page ici 
        // Fonction pour le menu footer
        wp_nav_menu( array(
  'theme_location' => 'menu-pied-de-page',
  'menu_class'     => 'footer-menu',
) );
?>
</nav>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
