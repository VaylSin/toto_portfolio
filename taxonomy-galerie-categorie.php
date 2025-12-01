<?php
/**
 * The template for displaying galerie category archives
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toto_Portfolio
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					printf(
						/* translators: %s: search term. */
						esc_html__( 'Galeries : %s', 'toto-portfolio' ),
						'<span>' . single_term_title( '', false ) . '</span>'
					);
					?>
				</h1>
				
				<?php
				$term_description = term_description();
				if ( ! empty( $term_description ) ) :
					printf( '<div class="taxonomy-description">%s</div>', $term_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				endif;
				?>
				
				<?php
				// Afficher toutes les catégories de galerie pour navigation
				$categories = get_terms( array(
					'taxonomy' => 'galerie-categorie',
					'hide_empty' => true,
				) );

				if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
					?>
					<div class="galerie-category-filter">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'gallerie' ) ); ?>" class="filter-link">
							<?php esc_html_e( 'Toutes', 'toto-portfolio' ); ?>
						</a>
						<?php foreach ( $categories as $category ) : ?>
							<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" 
							   class="filter-link <?php echo is_tax( 'galerie-categorie', $category->term_id ) ? 'active' : ''; ?>">
								<?php echo esc_html( $category->name ); ?>
								<span class="count">(<?php echo $category->count; ?>)</span>
							</a>
						<?php endforeach; ?>
					</div>
					<?php
				endif;
				?>
			</header><!-- .page-header -->

			<div class="galerie-archive-grid">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'galerie-archive-item' ); ?>>
						<div class="galerie-card">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="galerie-thumbnail">
									<a href="<?php echo esc_url( get_permalink() ); ?>">
										<?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
									</a>
									
									<?php
									// Compter les images dans la galerie
									$gallery = get_post_gallery( get_the_ID(), false );
									$image_count = 0;
									if ( $gallery && isset( $gallery['ids'] ) ) {
										$image_ids = explode( ',', $gallery['ids'] );
										$image_count = count( $image_ids );
									}
									
									if ( $image_count > 0 ) :
										?>
										<div class="image-count">
											<span><?php echo esc_html( $image_count ); ?> <?php esc_html_e( 'photos', 'toto-portfolio' ); ?></span>
										</div>
										<?php
									endif;
									?>
								</div>
							<?php endif; ?>

							<div class="galerie-card-content">
								<header class="entry-header">
									<h2 class="entry-title">
										<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
											<?php the_title(); ?>
										</a>
									</h2>
									
									<?php
									// Afficher les catégories de cette galerie
									$post_categories = get_the_terms( get_the_ID(), 'galerie-categorie' );
									if ( $post_categories && ! is_wp_error( $post_categories ) ) :
										?>
										<div class="galerie-meta-categories">
											<?php foreach ( $post_categories as $category ) : ?>
												<span class="galerie-meta-category"><?php echo esc_html( $category->name ); ?></span>
											<?php endforeach; ?>
										</div>
										<?php
									endif;
									?>
								</header><!-- .entry-header -->

								<?php if ( has_excerpt() ) : ?>
									<div class="entry-summary">
										<?php the_excerpt(); ?>
									</div><!-- .entry-summary -->
								<?php endif; ?>

								<footer class="entry-footer">
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more">
										<?php esc_html_e( 'Voir la galerie', 'toto-portfolio' ); ?>
										<span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span>
									</a>
								</footer><!-- .entry-footer -->
							</div><!-- .galerie-card-content -->
						</div><!-- .galerie-card -->
					</article><!-- #post-<?php the_ID(); ?> -->

					<?php
				endwhile;
				?>
			</div><!-- .galerie-archive-grid -->

			<?php
			the_posts_navigation();

		else :
			?>
			<div class="no-galleries-found">
				<h2><?php esc_html_e( 'Aucune galerie trouvée dans cette catégorie', 'toto-portfolio' ); ?></h2>
				<p><?php esc_html_e( 'Il n\'y a actuellement aucune galerie dans cette catégorie.', 'toto-portfolio' ); ?></p>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'gallerie' ) ); ?>" class="read-more">
					<?php esc_html_e( 'Voir toutes les galeries', 'toto-portfolio' ); ?>
				</a>
			</div>
			<?php
		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();