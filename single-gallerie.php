<?php
/**
 * The template for displaying single galerie posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Toto_Portfolio
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					
					<?php
					// Afficher les catégories de galerie
					$categories = get_the_terms( get_the_ID(), 'galerie-categorie' );
					if ( $categories && ! is_wp_error( $categories ) ) :
						?>
						<div class="galerie-categories">
							<?php foreach ( $categories as $category ) : ?>
								<span class="galerie-category"><?php echo esc_html( $category->name ); ?></span>
							<?php endforeach; ?>
						</div>
						<?php
					endif;
					?>
				</header><!-- .entry-header -->

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="galerie-featured-image">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( get_the_content() ) : ?>
					<div class="entry-content">
						<?php
						the_content();
						?>
					</div><!-- .entry-content -->
				<?php endif; ?>

				<?php
				// Récupérer la galerie d'images
				$gallery = get_post_gallery( get_the_ID(), false );
				if ( $gallery ) :
					$gallery_ids = explode( ',', $gallery['ids'] );
					if ( ! empty( $gallery_ids ) ) :
						?>
						<div class="galerie-masonry-container">
							<div class="galerie-masonry" id="galerie-masonry">
								<?php foreach ( $gallery_ids as $image_id ) :
									$image_url = wp_get_attachment_image_url( $image_id, 'large' );
									$image_full_url = wp_get_attachment_image_url( $image_id, 'full' );
									$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
									$image_caption = wp_get_attachment_caption( $image_id );
									
									if ( $image_url ) :
										?>
										<div class="galerie-item">
											<img src="<?php echo esc_url( $image_url ); ?>" 
												 alt="<?php echo esc_attr( $image_alt ); ?>"
												 data-full="<?php echo esc_url( $image_full_url ); ?>"
												 data-caption="<?php echo esc_attr( $image_caption ); ?>"
												 class="galerie-image">
											<?php if ( $image_caption ) : ?>
												<div class="galerie-caption"><?php echo esc_html( $image_caption ); ?></div>
											<?php endif; ?>
										</div>
										<?php
									endif;
								endforeach; ?>
							</div>
						</div>
						<?php
					endif;
				endif;
				?>

				<footer class="entry-footer">
					<?php
					// Navigation entre galeries
					$prev_post = get_previous_post( true, '', 'galerie-categorie' );
					$next_post = get_next_post( true, '', 'galerie-categorie' );
					
					if ( $prev_post || $next_post ) :
						?>
						<nav class="galerie-navigation">
							<?php if ( $prev_post ) : ?>
								<div class="nav-previous">
									<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
										<span class="nav-subtitle"><?php esc_html_e( 'Galerie précédente:', 'toto-portfolio' ); ?></span>
										<span class="nav-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
									</a>
								</div>
							<?php endif; ?>
							
							<?php if ( $next_post ) : ?>
								<div class="nav-next">
									<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
										<span class="nav-subtitle"><?php esc_html_e( 'Galerie suivante:', 'toto-portfolio' ); ?></span>
										<span class="nav-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
									</a>
								</div>
							<?php endif; ?>
						</nav>
						<?php
					endif;
					?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

	<!-- Lightbox Modal -->
	<div id="galerie-lightbox" class="galerie-lightbox">
		<span class="galerie-close">&times;</span>
		<img class="galerie-lightbox-content" id="galerie-lightbox-img">
		<div class="galerie-lightbox-caption" id="galerie-lightbox-caption"></div>
		
		<!-- Navigation arrows -->
		<a class="galerie-prev" id="galerie-prev">&#10094;</a>
		<a class="galerie-next" id="galerie-next">&#10095;</a>
	</div>

<?php
get_footer();