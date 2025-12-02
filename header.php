<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Toto_Portfolio
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'toto-portfolio' ); ?></a>

	<header id="masthead" class="site-header"<?php if ( !is_front_page() ) : ?> style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 0 2rem;"<?php endif; ?>>
		<div class="header-content"<?php if ( !is_front_page() ) : ?> style="padding: 15px 0;"<?php endif; ?>>
			<div class="header-logo<?php echo !is_front_page() ? ' logo-black' : ''; ?>">
				<?php
				$custom_logo = toto_portfolio_get_custom_logo();
				if ( $custom_logo ) :
					if ( !is_front_page() ) {
						$custom_logo = str_replace('<svg', '<svg fill="#000"', $custom_logo);
					}
					echo $custom_logo;
				else :
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"<?php if ( !is_front_page() ) : ?> style="color: #333;"<?php endif; ?>>
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php
				endif;
				?>
			</div>

			<nav class="header-nav"<?php if ( !is_front_page() ) : ?> style="color: #333;"<?php endif; ?>>
				<ul class="nav-menu">
					<li><a href="<?php echo esc_url( home_url( '/#home' ) ); ?>"<?php if ( !is_front_page() ) : ?> style="color: #333 !important;"<?php endif; ?>><?php esc_html_e( 'ACCUEIL', 'toto-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"<?php if ( !is_front_page() ) : ?> style="color: #333 !important;"<?php endif; ?>><?php esc_html_e( 'À PROPOS', 'toto-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#galleries' ) ); ?>"<?php if ( !is_front_page() ) : ?> style="color: #333 !important;"<?php endif; ?>><?php esc_html_e( 'GALERIES', 'toto-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"<?php if ( !is_front_page() ) : ?> style="color: #333 !important;"<?php endif; ?>><?php esc_html_e( 'RÉSERVATION', 'toto-portfolio' ); ?></a></li>
				</ul>
			</nav>
		</div>
	</header>
