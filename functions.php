<?php
/**
 * Toto Portfolio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Toto_Portfolio
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function toto_portfolio_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Toto Portfolio, use a find and replace
		* to change 'toto-portfolio' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'toto-portfolio', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'toto-portfolio' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'toto_portfolio_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'toto_portfolio_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function toto_portfolio_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'toto_portfolio_content_width', 640 );
}
add_action( 'after_setup_theme', 'toto_portfolio_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function toto_portfolio_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'toto-portfolio' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'toto-portfolio' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'toto_portfolio_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function toto_portfolio_scripts() {
	wp_enqueue_style( 'toto-portfolio-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'toto-portfolio-style', 'rtl', 'replace' );

	// Enqueue Google Fonts
	wp_enqueue_style( 'toto-portfolio-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap', array(), _S_VERSION );

	wp_enqueue_script( 'toto-portfolio-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	// Enqueue homepage script with mobile menu on all pages
	wp_enqueue_script( 'toto-portfolio-homepage', get_template_directory_uri() . '/js/homepage.js', array(), _S_VERSION, true );

	// Enqueue galerie lightbox script only on single galerie pages
	if ( is_singular( 'galerie' ) ) {
		wp_enqueue_script( 'toto-portfolio-galerie-lightbox', get_template_directory_uri() . '/js/galerie-lightbox.js', array(), _S_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'toto_portfolio_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Register custom post type Galerie
 */
function toto_portfolio_register_galerie_post_type() {
	$labels = array(
		'name'               => _x( 'Galeries', 'post type general name', 'toto-portfolio' ),
		'singular_name'      => _x( 'Galerie', 'post type singular name', 'toto-portfolio' ),
		'menu_name'          => _x( 'Galeries', 'admin menu', 'toto-portfolio' ),
		'name_admin_bar'     => _x( 'Galerie', 'add new on admin bar', 'toto-portfolio' ),
		'add_new'            => _x( 'Ajouter nouvelle', 'galerie', 'toto-portfolio' ),
		'add_new_item'       => __( 'Ajouter nouvelle galerie', 'toto-portfolio' ),
		'new_item'           => __( 'Nouvelle galerie', 'toto-portfolio' ),
		'edit_item'          => __( 'Modifier galerie', 'toto-portfolio' ),
		'view_item'          => __( 'Voir galerie', 'toto-portfolio' ),
		'all_items'          => __( 'Toutes les galleries', 'toto-portfolio' ),
		'search_items'       => __( 'Rechercher galleries', 'toto-portfolio' ),
		'parent_item_colon'  => __( 'Galerie parent:', 'toto-portfolio' ),
		'not_found'          => __( 'Aucune galerie trouvée.', 'toto-portfolio' ),
		'not_found_in_trash' => __( 'Aucune galerie trouvée dans la corbeille.', 'toto-portfolio' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'toto-portfolio' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'galerie' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-format-gallery',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'galerie', $args );
}
add_action( 'init', 'toto_portfolio_register_galerie_post_type' );

/**
 * Register custom taxonomy for Galerie
 */
function toto_portfolio_register_galerie_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Catégories de galerie', 'taxonomy general name', 'toto-portfolio' ),
		'singular_name'              => _x( 'Catégorie de galerie', 'taxonomy singular name', 'toto-portfolio' ),
		'search_items'               => __( 'Rechercher catégories', 'toto-portfolio' ),
		'popular_items'              => __( 'Catégories populaires', 'toto-portfolio' ),
		'all_items'                  => __( 'Toutes les catégories', 'toto-portfolio' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Modifier catégorie', 'toto-portfolio' ),
		'update_item'                => __( 'Mettre à jour catégorie', 'toto-portfolio' ),
		'add_new_item'               => __( 'Ajouter nouvelle catégorie', 'toto-portfolio' ),
		'new_item_name'              => __( 'Nom nouvelle catégorie', 'toto-portfolio' ),
		'separate_items_with_commas' => __( 'Séparer catégories avec virgules', 'toto-portfolio' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer catégories', 'toto-portfolio' ),
		'choose_from_most_used'      => __( 'Choisir parmi les plus utilisées', 'toto-portfolio' ),
		'not_found'                  => __( 'Aucune catégorie trouvée.', 'toto-portfolio' ),
		'menu_name'                  => __( 'Catégories', 'toto-portfolio' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'galerie-categorie' ),
		'show_in_rest'          => true,
	);

	register_taxonomy( 'galerie-categorie', array( 'galerie' ), $args );
}
add_action( 'init', 'toto_portfolio_register_galerie_taxonomy' );

/**
 * Flush rewrite rules on theme activation
 */
function toto_portfolio_flush_rewrites() {
	// First, we "add" the custom post type via the above written function.
	// Note: "add" is written with quotes because actually no rules are added here yet.
	toto_portfolio_register_galerie_post_type();
	toto_portfolio_register_galerie_taxonomy();

	// Flush the rewrite rules only if not already done
	if ( ! get_option( 'toto_portfolio_galerie_flushed_rewrite_rules' ) ) {
		flush_rewrite_rules();
		add_option( 'toto_portfolio_galerie_flushed_rewrite_rules', true );
	}
}
add_action( 'after_switch_theme', 'toto_portfolio_flush_rewrites' );

/**
 * Fallback menu for header
 */
function toto_portfolio_fallback_menu() {
	?>
	<ul id="primary-menu" class="fallback-menu">
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Accueil', 'toto-portfolio' ); ?></a></li>
		<li><a href="<?php echo esc_url( get_post_type_archive_link( 'galerie' ) ); ?>"><?php esc_html_e( 'Galeries', 'toto-portfolio' ); ?></a></li>
	</ul>
	<?php
}





/**
 * Handle contact form submission
 */
function toto_portfolio_handle_contact_form() {
	if ( isset( $_POST['contact_name'] ) && isset( $_POST['contact_email'] ) && isset( $_POST['contact_message'] ) ) {
		// Verify nonce for security (to be added)
		// $nonce = $_POST['contact_nonce'];
		// if ( ! wp_verify_nonce( $nonce, 'contact_form_nonce' ) ) {
		//     wp_die( 'Erreur de sécurité' );
		// }

		// Sanitize form data
		$name = sanitize_text_field( $_POST['contact_name'] );
		$email = sanitize_email( $_POST['contact_email'] );
		$phone = sanitize_text_field( $_POST['contact_phone'] );
		$service_type = sanitize_text_field( $_POST['service_type'] );
		$shoot_date = sanitize_text_field( $_POST['shoot_date'] );
		$message = sanitize_textarea_field( $_POST['contact_message'] );

		// Prepare email content
		$subject = sprintf( __( 'Nouvelle demande de devis de %s', 'toto-portfolio' ), $name );
		$body = sprintf(
			__( "Nouvelle demande de devis:\n\nNom: %s\nEmail: %s\nTéléphone: %s\nType de service: %s\nDate souhaitée: %s\n\nMessage:\n%s", 'toto-portfolio' ),
			$name,
			$email,
			$phone,
			$service_type,
			$shoot_date,
			$message
		);

		$admin_email = get_option( 'admin_email' );
		$headers = array( 'Reply-To: ' . $email );

		// Send email
		$sent = wp_mail( $admin_email, $subject, $body, $headers );

		if ( $sent ) {
			// Redirect with success message
			wp_redirect( add_query_arg( 'contact', 'success', home_url() . '#contact' ) );
			exit;
		} else {
			// Redirect with error message
			wp_redirect( add_query_arg( 'contact', 'error', home_url() . '#contact' ) );
			exit;
		}
	}
}
add_action( 'template_redirect', 'toto_portfolio_handle_contact_form' );

/**
 * Ajouter le support SVG dans WordPress
 */
function toto_portfolio_add_svg_support( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'toto_portfolio_add_svg_support' );

/**
 * Sécuriser l'upload SVG
 */
function toto_portfolio_sanitize_svg( $file ) {
	if ( $file['type'] === 'image/svg+xml' ) {
		$svg_content = file_get_contents( $file['tmp_name'] );
		// Vérification basique de sécurité
		if ( strpos( $svg_content, '<script' ) !== false || strpos( $svg_content, 'javascript:' ) !== false ) {
			$file['error'] = 'Ce fichier SVG contient du code potentiellement dangereux.';
		}
	}
	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'toto_portfolio_sanitize_svg' );

/**
 * Améliorer l'affichage du logo SVG
 */
function toto_portfolio_get_custom_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$logo_url = wp_get_attachment_url( $custom_logo_id );
		$logo_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
		if ( empty( $logo_alt ) ) {
			$logo_alt = get_bloginfo( 'name' );
		}
		
		$home_url = esc_url( home_url( '/' ) );
		
		if ( pathinfo( $logo_url, PATHINFO_EXTENSION ) === 'svg' ) {
			// Pour les SVG, on utilise une img tag avec classes spécifiques
			return '<a href="' . $home_url . '" class="custom-logo-link" rel="home"><img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $logo_alt ) . '" class="custom-logo svg-logo" /></a>';
		} else {
			// Pour les autres formats, comportement normal
			return wp_get_attachment_image( $custom_logo_id, 'full', false, array(
				'class' => 'custom-logo',
				'alt' => $logo_alt,
			) );
		}
	}
	return false;
}

