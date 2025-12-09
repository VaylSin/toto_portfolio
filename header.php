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

			<nav class="header-nav main-navigation">
				<!-- Bouton burger mobile -->
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span></span>
					<span></span>
					<span></span>
				</button>
				
				<ul class="nav-menu">
					<li><a href="<?php echo esc_url( home_url( '/#home' ) ); ?>"><?php esc_html_e( 'ACCUEIL', 'toto-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'À PROPOS', 'toto-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#galleries' ) ); ?>"><?php esc_html_e( 'GALERIES', 'toto-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'RÉSERVATION', 'toto-portfolio' ); ?></a></li>
				</ul>
			</nav>
		</div>
	</header>
