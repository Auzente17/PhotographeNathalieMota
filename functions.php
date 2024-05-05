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
  wp_enqueue_script('pagination-js', get_stylesheet_directory_uri() . '/js/pagination.js', array('jquery'), '1.0.0', true);
  wp_enqueue_script('lightbox-js', get_stylesheet_directory_uri() . '/js/lightbox.js', array(), time(), true);
  
  // Enregistrer et localiser les scripts pour Select2
  wp_enqueue_script('select2-script', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0', true);
  wp_enqueue_style('select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
  wp_enqueue_script('select2-js', get_stylesheet_directory_uri() . '/js/select2.js', array('jquery'), '1.0.0', true);
  
  // Localiser les scripts pour AJAX
  wp_localize_script('pagination-js', 'ajax_params', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'security' => wp_create_nonce('load_more_photos')
));

// Localiser les scripts pour AJAX
wp_localize_script('pagination-js', 'ajax_params', array(
  'ajax_url' => admin_url('admin-ajax.php'),
  'security' => wp_create_nonce('load_more_photos')
));
  
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts_and_styles');


function load_scripts() {
  // Enregistrer le script pour les filtres dans la page d'accueil
  wp_enqueue_script('filtres-js', get_stylesheet_directory_uri() . '/js/filtres.js', array('jquery'), '1.0.0', true);
  // Enregistrez et localisez une seule fois pour tous les scripts nécessitant ajax_params
  wp_localize_script('filtres-js', 'ajax_params', array(
    'ajax_url' => admin_url('admin-ajax.php'), 
    'security' => wp_create_nonce('load_more_photos')
  ));

}

add_action( 'wp_enqueue_scripts', 'load_scripts' );


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
  error_log('Received security nonce: ' . $_POST['security']);
  error_log('Received offset: ' . $_POST['offset']);
  // Vérification de la sécurité
  if (!isset($_POST['security']) && wp_verify_nonce($_POST['security'], 'load_more_photos')) {
    wp_die('Sécurité de la requête non vérifiée.');
}
  // Récupérer l'offset à partir de la requête AJAX
  $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
  $per_page = 8; // Nombre de photos à charger à chaque fois
  // Arguments de la requête pour récupérer les photos
  $args = array(
    'post_type'      => 'photo',     // Type de publication : photo
    'posts_per_page' =>  $per_page,   // Nombre de photos par page (-1 pour toutes)
    'offset'         => $offset,     // Offset pour obtenir les prochaines photos
    'orderby'        => 'date',      // Tri aléatoire
    'order'          => 'DESC',      // Ordre ascendant
);
// Exécute la requête WP_Query avec les arguments
$photo_block = new WP_Query($args);
error_log('Requête SQL: ' . $photo_block->request);  // Log la requête SQL
error_log('Nombre de posts trouvés: ' . $photo_block->found_posts);  // Log le nombre de posts trouvés
// Initialise la variable pour stocker le HTML des nouvelles photos
$output = '';
// Vérifie s'il y a des photos dans la requête
if ($photo_block->have_posts()) {
     // Boucle à travers les photos
     while ($photo_block->have_posts()) {
         $photo_block->the_post();
         // Inclure le template "block-photo.php"
        ob_start();
        get_template_part('template-parts/block-photo');
        $output .= ob_get_clean();
      }
     // Réinitialise les données post
     wp_reset_postdata();
    } else {
      // Aucune photo trouvée
      error_log('Aucun post trouvé pour les critères donnés avec offset: ' . $offset);
      echo 'Aucune photo trouvée. Vérifiez les logs pour plus d\'informations.';
    }
  // Retourne le HTML des nouvelles photos
  echo $output;
  // Arrête l'exécution de la fonction
  wp_die();
}
// Ajout des actions pour les requêtes AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


// // Fonction pour filtrer les photos via AJAX
// function filter_photos() {
//   // Vérifier si la clé 'security' est présente et le nonce est valide
//   if (empty($_POST['security']) || !wp_verify_nonce($_POST['security'], 'load_more_photos')) {
//       error_log('Nonce absent ou invalide');
//       wp_die('Erreur de sécurité: Nonce absent ou invalide');
//   }

//  // Vérification de présence des champs de filtre
//  $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'Non spécifiée';
//  $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : 'Non spécifié';
//  $annees = isset($_POST['annees']) ? sanitize_text_field($_POST['annees']) : 'Non spécifiées';


//   error_log('Catégorie sélectionnée : ' . $category);
//   error_log('Format sélectionné : ' . $format);
//   error_log('Années sélectionnées : ' . $annees);

//   // Arguments de la requête pour récupérer les photos
//   $args = array(
//     'post_type'      => 'photo',
//     'posts_per_page' => -1,
//     'orderby'        => 'date',
//     'order'          => 'DESC',
//   );

//   // Ajouter les filtres aux arguments de la requête
//   if (!empty($category)) {
//     $args['tax_query'][] = array(
//       'taxonomy' => 'categorie',
//       'field'    => 'slug',
//       'terms'    => $category,
//     );
//   }

//   if (!empty($format)) {
//     $args['tax_query'][] = array(
//       'taxonomy' => 'format',
//       'field'    => 'slug',
//       'terms'    => $format,
//     );
//   }

//   if (!empty($annees)) {
//     $args['date_query'] = array(
//       'year' => $annees,
//     );
//   }

//   // Exécute la requête WP_Query avec les arguments
//   $query = new WP_Query($args);

//   $output = ''; // Initialiser la variable $output à une chaîne vide

//   // Vérifie si la requête a retourné des résultats
//   if ($query->have_posts()) {
//     while ($query->have_posts()) {
//         $query->the_post();
//         ob_start();
//         get_template_part('template-parts/block-photo');
//         $output .= ob_get_clean();
//     }
// } else {
//     error_log('Aucune photo trouvée');
//     $output = 'Aucune photo trouvée';
// }

// wp_reset_postdata();

// echo $output;

// wp_die();
// }

// Ajout des actions pour les requêtes AJAX de filtrage
//add_action('wp_ajax_filter_photos', 'filter_photos');
//add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');



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

