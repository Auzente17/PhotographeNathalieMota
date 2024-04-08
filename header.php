<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>
    <header>
        <nav>
            <!-- Ajouter le menu ici -->
            <h1>Hello!</h1>
            <?php
            
            // fonction pour afficher le menu WP
            wp_nav_menu( array(
                'theme_location' => 'menu-principal',
                'menu_class'     => 'menu',
            ) );
            ?>
        </nav>
    </header>
