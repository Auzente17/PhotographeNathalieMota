<?php

function theme_enqueue_scripts_and_styles() {

  
  wp_enqueue_style( 'thème-style', get_template_directory_uri() . '/style.css' );

  // Enregistrer le style principal du thème
  wp_enqueue_style('PhotographeNathalieMota-style', get_stylesheet_directory_uri() . '/sass/style.css', array(), time());

  // Enregistrer la feuille de script
  wp_enqueue_script( 'PhotographeNathalieMota-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true );
  
  // Enregistrer le script d'une fenêtre modale de contact qui est charge dans le pied de page (footer) du site. 
  wp_enqueue_script('contact-modal-js', get_theme_file_uri() . '/js/contact-modal.js', array(), time(), true);

  // Afficher les images miniature (script JQuery)
  wp_enqueue_script('miniature-js', get_stylesheet_directory_uri() . '/js/miniature.js', array('jquery'), '1.0.0', true);
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

// Fonction pour charger plus de photos via AJAX
function load_more_photos() {
   // Arguments de la requête pour récupérer les photos
   $args = array(
    'post_type'      => 'photo',     // Type de publication : photo
    'posts_per_page' => 8,          // Nombre de photos par page (-1 pour toutes)
    'orderby'        => 'date',      // Tri aléatoire
    'order'          => 'DESC',       // Ordre ascendant
    'offset' => $_POST['offset']
);

// Exécute la requête WP_Query avec les arguments
$photo_block = new WP_Query($args);
echo '<pre>';
print_r($photo_block);
echo '</pre>';


 // Vérifie s'il y a des photos dans la requête
 $compteur = 0; // initialisation de la variable $compteur à 0
 if ($photo_block->have_posts()) :
     // Boucle à travers les photos
     while ($photo_block->have_posts()) :
         $photo_block->the_post();
         echo 'Photo URL: ' . get_the_post_thumbnail_url() . '<br>';
         // Inclut la partie du modèle pour afficher un bloc de photo
         get_template_part('template-parts/block-photo', get_post_format());
     endwhile;
     

     // Réinitialise les données post
     wp_reset_postdata();
 else :
     // Aucune photo trouvée
     echo 'Aucune photo trouvée.';
 
 endif;
 
 // Termine l'exécution de la fonction
 die();
}
  
function remove_zero_clause_from_where($where) {
  $where = str_replace("AND (0 = 1)", "", $where);
  return $where;
}