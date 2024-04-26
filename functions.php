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

  // Enregistrer le script pour la pagination dans la page d'accueil
  wp_enqueue_script('pagination-js', get_stylesheet_directory_uri() . '/js/pagination.js', array('jquery'), '1.0.0', true);

  // Include bibliothèque Select2 CSS
  wp_enqueue_style('select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    
  // Include bibliothèque Select2 JavaScript
  wp_enqueue_script('select2-script', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0', true);
  
  // Enregistrer le script Select2
  wp_enqueue_script('select2-js', get_stylesheet_directory_uri() . '/js/select2.js', array('jquery'), '1.0.0', true);

  // Enregistrer le script pour les filtres dans la page d'accueil
  wp_enqueue_script('filtres-js', get_stylesheet_directory_uri() . '/js/filtres.js', array('jquery'), '1.0.0', true);

  // Localiser l'url d'administration Ajax pour une utilisation dans les scripts JavaScript
  wp_localize_script('filtres-js', 'ajax_params', array('ajax_url' => admin_url('admin-ajax.php')
    ));
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

// Fonction pour récupérer les options des filtres à partir des taxonomies
function get_taxonomy_options($taxonomy_name) {
  $terms = get_terms(array(
      'taxonomy' => $taxonomy_name,
      'hide_empty' => false,
  ));

  $options = '<option value="">Tous</option>'; // Option par défaut

  if ($terms && !is_wp_error($terms)) {
      foreach ($terms as $term) {
          $options .= '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
      }
  }

  return $options;
}


// Fonction pour charger plus de photos via AJAX
function load_more_photos() {
  // Récupérer l'offset à partir de la requête AJAX
  $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
  $per_page = 8; // Nombre de photos à charger à chaque fois

  // Vérifier le jeton de sécurité 
  if ( ! check_ajax_referer('load-more-photos', 'security', false)) {
    // Si le jeton de sécurité est invalide, arrêtez l'executions de la fonction
  wp_die( 'Erreur de sécurité' );
  }

  // Arguments de la requête pour récupérer les photos
  $args = array(
    'post_type'      => 'photo',     // Type de publication : photo
    'posts_per_page' => $per_page,   // Nombre de photos par page (-1 pour toutes)
    'orderby'        => 'date',      // Tri aléatoire
    'order'          => 'DESC',      // Ordre ascendant
    'offset'         => $offset,   // Offset pour obtenir les prochaines photos
);

// Exécute la requête WP_Query avec les arguments
$photo_block = new WP_Query($args);

// Initialise la variable pour stocker le HTML des nouvelles photos
$output = '';

// Vérifie s'il y a des photos dans la requête
if ($photo_block->have_posts()) {
     // Boucle à travers les photos
     while ($photo_block->have_posts()) {
         $photo_block->the_post();
         // Inclure le template "block-photo.php"
        get_template_part('template-parts/block-photo');
      }
     
     // Réinitialise les données post
     wp_reset_postdata();
    } else {
      // Aucune photo trouvée
      $output = 'Aucune photo trouvée';
    }

  // Retourne le HTML des nouvelles photos
  echo $output;

  // Arrête l'exécution de la fonction
  wp_die();
}  

// Ajout des actions pour les requêtes AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// Fonction pour retirer la clause "AND (0 = 1)" de la requête WHERE
function remove_zero_clause_from_where($where) {
  $where = str_replace("AND (0 = 1)", "", $where);
  return $where;
}

// Fonction pour récupérer une image de fond aléatoire
function get_random_background_image() {
  // Arguments de la requête pour récupérer une photo aléatoire
  $args = array(
      'post_type'      => 'photo',      // Type de publication : photo
      'posts_per_page' => 1,            // Nombre de photos à récupérer (1 pour une photo aléatoire)
      'orderby'        => 'rand',       // Tri aléatoire
  );

  // Exécute la requête WP_Query avec les arguments
  $photo_query = new WP_Query($args);

  // Initialise la variable pour stocker l'URL de l'image
  $photo_url = '';

  // Vérifie s'il y a des photos dans la requête
  if ($photo_query->have_posts()) {
      // Boucle à travers les photos
      while ($photo_query->have_posts()) {
          $photo_query->the_post();
          // Récupère l'URL de l'image mise en avant
          $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
      }
      // Réinitialise les données post
      wp_reset_postdata();
  }

  // Retourne l'URL de l'image
  return $photo_url;
}

