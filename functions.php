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

// Fonction pour ajouter la prise en charge du logo personnalisé dans le thème
// prise en charge du logo personnalisé avec des dimensions flexibles
function nathaliemota_theme_setup() {
  add_theme_support( 'custom-logo', array(
    'height'      => 14,
    'width'       => 216,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description' ), // Afficher le titre et la description du site dans l'en-tête
    ) );
}
add_action( 'after_setup_theme', 'nathaliemota_theme_setup' );

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


  