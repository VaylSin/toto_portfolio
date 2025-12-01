<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Toto_Portfolio
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="footer-content">
			<?php
			// Logo Footer depuis le customizer
			$footer_logo_id = get_theme_mod( 'toto_portfolio_footer_logo' );
			if ( $footer_logo_id ) {
				$footer_logo_url = wp_get_attachment_image_url( $footer_logo_id, 'medium' );
				$footer_logo_alt = get_post_meta( $footer_logo_id, '_wp_attachment_image_alt', true );
				if ( $footer_logo_url ) {
					?>
					<img src="<?php echo esc_url( $footer_logo_url ); ?>" alt="<?php echo esc_attr( $footer_logo_alt ?: get_bloginfo( 'name' ) ); ?>" class="footer-logo">
					<?php
				}
			} else {
				// Logo par défaut si aucun logo customizer
				?>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/img/logo_2.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="footer-logo">
				<?php
			}
			?>
			
			<?php
			// Réseaux sociaux
			$facebook_url = get_theme_mod( 'toto_portfolio_facebook_url' );
			$instagram_url = get_theme_mod( 'toto_portfolio_instagram_url' );
			
			if ( $facebook_url || $instagram_url ) :
				?>
				<div class="footer-social">
					<?php if ( $facebook_url ) : ?>
						<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="social-link facebook-link" aria-label="<?php esc_attr_e( 'Facebook', 'toto-portfolio' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" fill="currentColor"/>
							</svg>
						</a>
					<?php endif; ?>
					
					<?php if ( $instagram_url ) : ?>
						<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="social-link instagram-link" aria-label="<?php esc_attr_e( 'Instagram', 'toto-portfolio' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" fill="currentColor"/>
							</svg>
						</a>
					<?php endif; ?>
				</div>
				<?php
			endif;
			?>
		</div><!-- .footer-content -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
