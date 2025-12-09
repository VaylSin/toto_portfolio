<?php
/**
 * Template for displaying the Contact page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'contact-page' ); ?>>
				
				<?php 
				// Image d'en-tête depuis ACF
				$image_entete = get_field('image_entete');
				if ( $image_entete ) : ?>
					<div class="contact-header-banner">
						<div class="contact-header-image" data-bg="<?php echo esc_url( $image_entete['url'] ); ?>">
							<div class="contact-header-overlay"></div>
							<?php if ( get_the_title() ) : ?>
								<h1 class="contact-header-title"><?php the_title(); ?></h1>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="contact-content-wrapper">
					<div class="section-container">
						
						<?php if ( get_the_title() ) : ?>
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->
						<?php endif; ?>

						<div class="entry-content">
							<?php
							the_content();

							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'toto-portfolio' ),
									'after'  => '</div>',
								)
							);
							?>
						</div><!-- .entry-content -->

						<?php 
						// Formulaire de contact depuis ACF
						$shortcode_formulaire = get_field('shortcode_du_formulaire');
						if ( $shortcode_formulaire ) : ?>
							<div class="contact-form-section">
								<div class="contact-form-wrapper">
									<?php echo do_shortcode( $shortcode_formulaire ); ?>
								</div>
							</div>
						<?php endif; ?>

					</div><!-- .section-container -->
				</div><!-- .contact-content-wrapper -->

			</article><!-- #post-<?php the_ID(); ?> -->

			<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();