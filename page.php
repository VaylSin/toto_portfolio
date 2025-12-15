<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toto_Portfolio
 */

get_header();

// Récupérer les options du customizer pour le bandeau d'entête
$header_bg_id = get_theme_mod('toto_portfolio_page_header_bg');
$header_height = get_theme_mod('toto_portfolio_page_header_height', 300);
$header_overlay = get_theme_mod('toto_portfolio_page_header_overlay', 0.5);
?>

	<?php 
	// Bandeau d'entête depuis le customizer
	if ( $header_bg_id ) : 
		$header_bg_url = wp_get_attachment_image_url( $header_bg_id, 'full' );
	?>
		<div class="contact-header-banner" style="height: <?php echo esc_attr( $header_height ); ?>px;">
			<div class="contact-header-image" style="background-image: url('<?php echo esc_url( $header_bg_url ); ?>');">
				<div class="contact-header-overlay" style="background-color: rgba(0, 0, 0, <?php echo esc_attr( $header_overlay ); ?>);"></div>
				<?php if ( get_the_title() ) : ?>
					<h1 class="contact-header-title"><?php the_title(); ?></h1>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<main id="primary" class="site-main">
		<div class="contact-content-wrapper">
			<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( ! $header_bg_id ) : ?>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header>
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

				<?php if ( get_edit_post_link() ) : ?>
					<footer class="entry-footer">
						<?php
						edit_post_link(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Edit <span class="screen-reader-text">%s</span>', 'toto-portfolio' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								wp_kses_post( get_the_title() )
							),
							'<span class="edit-link">',
							'</span>'
						);
						?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
			</div><!-- .container -->
		</div><!-- .contact-content-wrapper -->

	</main><!-- #main -->

<?php
get_footer();
