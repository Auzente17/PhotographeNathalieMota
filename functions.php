<?php

function theme_enqueue_scripts_and_styles() {
  // Enregistrer le style
  wp_enqueue_style( 'PhotographeNathalieMota-style', get_stylesheet_directory_uri() . '/sass/style.css', array(), '1.0.0', true );

  // Enregistrer la feuille de script
  wp_enqueue_script( 'PhotographeNathalieMota-script', get_stylesheet_directory_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts_and_styles' );


// Enregistrer les emplacements de menus: Menu principal et Menu pied de page
function enregistrer_menus() {
    register_nav_menus(
      array(
        'menu-principal' => __( 'Menu principal', 'nathaliemota' ),
        'menu-pied-de-page' => __( 'Menu de pied de page', 'nathaliemota' )
      )
    );
  }
  add_action( 'init', 'enregistrer_menus' );



