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
  
  // Localiser les scripts pour AJAX
  wp_enqueue_script('pagination-js', get_stylesheet_directory_uri() . '/js/pagination.js', array('jquery'), '1.0.0', true);
  wp_localize_script('pagination-js', 'ajax_filtres', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'ajax_nonce' => wp_create_nonce('filtre_photos_nonce')
));
 
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


// Fonction pour charger plus de photos via AJAX
function load_more_photos() {
  // Vérifiez le nonce pour la sécurité
  check_ajax_referer('filtre_photos_nonce', 'nonce');
  error_log('Received nonce: ' . $_POST['nonce']);
$check_nonce = check_ajax_referer('filtre_photos_nonce', 'nonce', false);
error_log('Nonce check result: ' . ($check_nonce ? 'passed' : 'failed'));

  // Obtenez l'offset de la requête AJAX
  $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
  $filter = isset($_POST['filter']) ? $_POST['filter'] : []; // Assurez-vous de valider et de nettoyer ce contenu.

$args = [
  'post_type' => 'photo',
  'posts_per_page' => 8,
  'offset' => $offset,
  'orderby' => 'date',
  'order' => 'DESC'
];

// Ajoutez la taxonomie pour la catégorie si elle est spécifiée
if (!empty($filter['category'])) {
  $args['tax_query'][] = [
      'taxonomy' => 'categorie',
      'field'    => 'slug',
      'terms'    => $filter['category'],
    ];
}

// Ajoutez la taxonomie pour l'année si elle est spécifiée
if (!empty($filter['years'])) {
  $args['order'] = ($filter['years'] == 'date_desc') ? 'DESC' : 'ASC';
}

// Ajoutez la taxonomie pour le format si elle est spécifiée
if (!empty($filter['format'])) {
  $args['tax_query'][] = [
      'taxonomy' => 'format',
      'field'    => 'slug',
      'terms'    => $filter['format'],
    ];
}
    // Exécute la requête WP_Query avec les arguments
  $query = new WP_Query($args);
    // Log de la requête SQL générée
  error_log('WP_Query SQL: ' . $query->request);  // Assurez-vous que cette ligne est correctement placée
  
    // Vérifie s'il y a des photos dans la requête
  if ($query->have_posts()) {
    $output = '';
    // Boucle à travers les photos
      while ($query->have_posts()) {
          $query->the_post();
          ob_start();
          // Inclut la partie du modèle pour afficher un bloc de photo
          get_template_part('template-parts/block-photo', get_post_format()); // Assurez-vous que ce template part existe et est correct
          $output .= ob_get_clean();
        }
        // Réinitialise les données post
      wp_reset_postdata();
      wp_send_json_success($output);
    } else {
      wp_send_json_success(''); // Envoyer success avec une chaîne vide si pas de posts supplémentaires
  }

 
  wp_die(); // Termine toujours les fonctions AJAX correctement.
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

