<?php

function theme_enqueue_scripts_and_styles() {

  
  wp_enqueue_style( 'thème-style', get_template_directory_uri() . '/style.css' );

  // Enregistrer le style principal du thème
  wp_enqueue_style('PhotographeNathalieMota-style', get_stylesheet_directory_uri() . '/css/style.css', array(), time());

  // Enregistrer la feuille de script
  wp_enqueue_script( 'PhotographeNathalieMota-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true );

  wp_enqueue_script('contact-modal-js', get_theme_file_uri() . '/js/contact-modal.js', array(), time(), true);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts_and_styles' );

// Enregistrer les emplacements de menus: Menu principal et Menu pied de page
function enregistrer_menus() {
    register_nav_menus(
      array(
        'menu-principal' => esc_html__( 'Menu principal', 'nathaliemota' ),
        'menu-pied-de-page' => esc_html__( 'Menu de pied de page', 'nathaliemota' )
      )
    );
  }
  add_action( 'init', 'enregistrer_menus' );



