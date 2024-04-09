<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
<header>
        <nav id="nav-bar" class="navbar">
            <!-- Ajouter le menu ici -->
            <!-- Logo -->
            <div class="navbar__logo">
                <a href="<?php echo esc_url( home_url( '/')); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Logo">
                </a>
            </div>
            
            <!-- Menu principal -->
            <div class="navbar__menu">
                <?php
                // fonction pour afficher le menu WP
                wp_nav_menu( array(
                    'theme_location' => 'menu-principal',
                    'menu_class'     => 'menu',
                ) );
                ?>
            </div>
        </nav>
    </header>