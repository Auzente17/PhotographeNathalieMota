<?php
// Récupère l'en-tête du thème
get_header();


// Vérifie s'il y a des articles à afficher
if ( have_posts() ) :
    // Boucle sur les articles
    while ( have_posts() ) :
        // Récupère l'article suivant
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <div class="entry-meta">
                    <?php the_author_posts_link(); ?>
                    <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
                    <?php if ( has_category() ) : ?>
                        <span class="cat-links">
                            <?php the_category( ', ' ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( has_tag() ) : ?>
                        <span class="tag-links">
                            <?php the_tags( '', ', ', '' ); ?>
                        </span>
                    <?php endif; ?>
                </div><!-- .entry-meta -->
            </header><!-- .entry-header -->


            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div><!-- .post-thumbnail -->
            <?php endif; ?>


            <div class="entry-content">
                <?php the_content(); ?>
                <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'textdomain' ),
                        'after'  => '</div>',
                    ) );
                ?>
            </div><!-- .entry-content -->


            <footer class="entry-footer">
                <?php edit_post_link( __( 'Edit', 'textdomain' ), '<span class="edit-link">', '</span>' ); ?>
            </footer><!-- .entry-footer -->
        </article><!-- #post-<?php the_ID(); ?> -->


        <?php
            // Si les commentaires sont activés ou s'il y a au moins un commentaire, charge le modèle de commentaires
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        ?>
    <?php
    endwhile;
endif;


// Récupère le pied de page du thème
get_footer();
