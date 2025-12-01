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

	<header id="masthead" class="site-header">
		<div class="header-content">
			<div class="header-logo">
				<?php
				$custom_logo = toto_portfolio_get_custom_logo();
				if ( $custom_logo ) :
					echo $custom_logo;
				else :
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php
				endif;
				?>
			</div>

			<nav class="header-nav">
				<?php if ( is_front_page() ) : ?>
					<ul class="nav-menu">
						<li><a href="#home"><?php esc_html_e( 'ACCUEIL', 'toto-portfolio' ); ?></a></li>
						<li><a href="#about"><?php esc_html_e( 'À PROPOS', 'toto-portfolio' ); ?></a></li>
						<li><a href="#galleries"><?php esc_html_e( 'GALERIES', 'toto-portfolio' ); ?></a></li>
						<li><a href="#contact"><?php esc_html_e( 'RÉSERVATION', 'toto-portfolio' ); ?></a></li>
					</ul>
				<?php else : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_class'     => 'nav-menu',
							'container'      => false,
						)
					);
					?>
				<?php endif; ?>
			</nav>
		</div>
	</header>
