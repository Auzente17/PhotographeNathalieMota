<?php

function theme_enqueue_scripts_and_styles() {

  // Enregistrer les styles
  wp_enqueue_style( 'thème-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style('PhotographeNathalieMota-style', get_stylesheet_directory_uri() . '/sass/style.css', array(), time());
  
  // Enregistrer les scripts
  wp_enqueue_script('jquery');
  wp_enqueue_script( 'PhotographeNathalieMota-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script('contact-modal-js', get_theme_file_uri() . '/js/contact-modal.js', array(), time(), true);
  wp_enqueue_script('miniature-js', get_stylesheet_directory_uri() . '/js/miniature.js', array('jquery'), '1.0.0', true);
  wp_enqueue_script('lightbox-js', get_stylesheet_directory_uri() . '/js/lightbox.js', array(), time(), true);
  wp_enqueue_script('burger-js', get_stylesheet_directory_uri() . '/js/burger.js', array(), time(), true);

  // Enregistrer et localiser les scripts pour Select2
  wp_enqueue_script('select2-script', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0', true);
  wp_enqueue_style('select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
  wp_enqueue_script('select2-js', get_stylesheet_directory_uri() . '/js/select2.js', array('jquery'), '1.0.0', true);
}
  add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts_and_styles');
  
 

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

// Ajout du script load-more-photos.js pour la pagination et pour les filtres avec wp_localize_script pour passer des paramètres AJAX
function enqueue_load_more_photos_script() {
  // Enregistrer les scripts
  wp_enqueue_script('pagination', get_stylesheet_directory_uri() . '/js/pagination.js', array('jquery'), null, true);
  wp_enqueue_script('filtres', get_stylesheet_directory_uri() . '/js/filtres.js', array('jquery'), null, true);

  // Paramètres communs à passer aux scripts
  $ajax_params = array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'ajax_nonce' => wp_create_nonce('load_more_photos_nonce')
);

  // Localiser les scripts
  wp_localize_script('pagination', 'ajax_filtres', $ajax_params);
  wp_localize_script('filtres', 'ajax_filtres', $ajax_params);
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_photos_script');


// Fonction pour charger plus de photos via AJAX
function load_more_photos() {
  check_ajax_referer('load_more_photos_nonce', 'nonce'); // Vérifier le nonce
  $offset = isset($_POST['offset']) ? absint($_POST['offset']) : 0;
  $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
  $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
  $order = isset($_POST['order']) ? $_POST['order'] : 'DESC';
  error_log('Order parameter received: ' . $order);  // Log this to check what's received

  

  $args = [
  'post_type' => 'photo',
  'posts_per_page' => 8,
  'offset' => $offset,
  'orderby' => 'date',
  'order' => $order,
  'tax_query' => []
];

// Autres conditions de taxonomie si nécessaire
if (!empty($categorie) || !empty($format)) {
  $args['tax_query']['relation'] = 'AND';
  if (!empty($categorie)) {
      $args['tax_query'][] = array(
          'taxonomy' => 'categorie',
          'field' => 'slug',
          'terms' => $categorie
      );
  }

if (!empty($format)) {
  $args['tax_query'][] = [
      'taxonomy' => 'format',
      'field' => 'slug',
      'terms' => $format
  ];
}
}
  // Exécute la requête WP_Query avec les arguments
  $query = new WP_Query($args);
  $output = '';

    // Vérifie s'il y a des photos dans la requête
    if ($query->have_posts()) {
       // Boucle à travers les photos
      while ($query->have_posts()) {
          $query->the_post();
          ob_start();
          // Inclut la partie du modèle pour afficher un bloc de photo
          get_template_part('templates-parts/block-photo', get_post_format()); 
          $output .= ob_get_clean();
        }

        // Détermine si d'autres photos sont disponibles
    $has_more_photos = $query->found_posts > $offset + $query->post_count;

            // Réinitialise les données post
      wp_reset_postdata();
      wp_send_json_success($output);
    } else {
      wp_send_json_error('No posts found');
    }
    
  wp_die(); // Arrête l'exécution pour retourner une réponse propre
}

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

