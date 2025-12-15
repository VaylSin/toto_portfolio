<?php
/**
 * Toto Portfolio Theme Customizer
 *
 * @package Toto_Portfolio
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function toto_portfolio_customize_register_default( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'toto_portfolio_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'toto_portfolio_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'toto_portfolio_customize_register_default' );

/**
 * Add page header customization options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function toto_portfolio_customize_register_page_header( $wp_customize ) {
	// Section Bandeau d'entête des pages
	$wp_customize->add_section(
		'toto_portfolio_page_header_section',
		array(
			'title'    => __( 'Bandeau d\'entête des pages', 'toto-portfolio' ),
			'priority' => 125,
		)
	);

	// Image de fond du bandeau
	$wp_customize->add_setting(
		'toto_portfolio_page_header_bg',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'toto_portfolio_page_header_bg',
			array(
				'label'     => __( 'Image de fond du bandeau', 'toto-portfolio' ),
				'section'   => 'toto_portfolio_page_header_section',
				'mime_type' => 'image',
				'priority'  => 10,
			)
		)
	);

	// Hauteur du bandeau
	$wp_customize->add_setting(
		'toto_portfolio_page_header_height',
		array(
			'default'           => '300',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'toto_portfolio_page_header_height',
		array(
			'label'    => __( 'Hauteur du bandeau (en px)', 'toto-portfolio' ),
			'section'  => 'toto_portfolio_page_header_section',
			'type'     => 'number',
			'priority' => 20,
		)
	);

	// Opacité de l'overlay
	$wp_customize->add_setting(
		'toto_portfolio_page_header_overlay',
		array(
			'default'           => '0.5',
			'sanitize_callback' => 'toto_portfolio_sanitize_float',
		)
	);

	$wp_customize->add_control(
		'toto_portfolio_page_header_overlay',
		array(
			'label'    => __( 'Opacité de l\'overlay (0 à 1)', 'toto-portfolio' ),
			'section'  => 'toto_portfolio_page_header_section',
			'type'     => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 1,
				'step' => 0.1,
			),
			'priority' => 30,
		)
	);
}
add_action( 'customize_register', 'toto_portfolio_customize_register_page_header' );

/**
 * Add footer customization options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function toto_portfolio_customize_register_footer( $wp_customize ) {
	// Section Footer
	$wp_customize->add_section(
		'toto_portfolio_footer_section',
		array(
			'title'    => __( 'Footer', 'toto-portfolio' ),
			'priority' => 130,
		)
	);

	// Logo Footer
	$wp_customize->add_setting(
		'toto_portfolio_footer_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'toto_portfolio_footer_logo',
			array(
				'label'    => __( 'Logo Footer', 'toto-portfolio' ),
				'section'  => 'toto_portfolio_footer_section',
				'mime_type' => 'image',
				'priority' => 10,
			)
		)
	);

	// Section Réseaux Sociaux
	$wp_customize->add_section(
		'toto_portfolio_social_section',
		array(
			'title'    => __( 'Réseaux Sociaux', 'toto-portfolio' ),
			'priority' => 131,
		)
	);

	// Facebook URL
	$wp_customize->add_setting(
		'toto_portfolio_facebook_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'toto_portfolio_facebook_url',
		array(
			'label'   => __( 'URL Facebook', 'toto-portfolio' ),
			'section' => 'toto_portfolio_social_section',
			'type'    => 'url',
			'priority' => 10,
		)
	);

	// Instagram URL
	$wp_customize->add_setting(
		'toto_portfolio_instagram_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'toto_portfolio_instagram_url',
		array(
			'label'   => __( 'URL Instagram', 'toto-portfolio' ),
			'section' => 'toto_portfolio_social_section',
			'type'    => 'url',
			'priority' => 20,
		)
	);
}
add_action( 'customize_register', 'toto_portfolio_customize_register_footer' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function toto_portfolio_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function toto_portfolio_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function toto_portfolio_customize_preview_js() {
	wp_enqueue_script( 'toto-portfolio-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'toto_portfolio_customize_preview_js' );

/**
 * Sanitize float values for customizer
 */
function toto_portfolio_sanitize_float( $value ) {
	return floatval( $value );
}
