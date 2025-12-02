<?php
/**
 * The front page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toto_Portfolio
 */

get_header();
?>

	<script>
		// Ajouter la classe loading au body pour désactiver le scroll
		document.body.classList.add('loading');
	</script>

	<!-- Page Loader -->
	<div id="page-loader" class="page-loader">
		<div class="loader-content">
			<div class="loader-logo">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/img/picto_pic.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="loader-logo-img">
			</div>
			<div class="loader-progress">
				<div class="progress-bar">
					<div class="progress-fill" id="progress-fill"></div>
				</div>
			</div>
		</div>
	</div>

	<main id="primary" class="site-main homepage">

		<!-- Photo Slider Section -->
		<section id="home" class="slider-section">
			<div class="slider-container">
				<?php
				// Récupérer les photos du slider depuis le champ ACF
				$slider_images = array();
				
				// Récupérer les images du champ ACF 'elements_photo'
				if ( function_exists( 'get_field' ) ) {
					$acf_images = get_field( 'elements_photo' );
					if ( $acf_images ) {
						foreach ( $acf_images as $image ) {
							if ( isset( $image['sizes']['full'] ) ) {
								$slider_images[] = $image['sizes']['full'];
							} elseif ( isset( $image['url'] ) ) {
								$slider_images[] = $image['url'];
							}
						}
					}
				}
				
				// Fallback : Si aucune image ACF, utiliser des images de galeries récentes
				if ( empty( $slider_images ) ) {
					$recent_galleries = get_posts( array(
						'post_type' => 'galerie',
						'posts_per_page' => 5,
						'meta_key' => '_thumbnail_id',
					) );
					
					foreach ( $recent_galleries as $gallery ) {
						$image_url = get_the_post_thumbnail_url( $gallery->ID, 'full' );
						if ( $image_url ) {
							$slider_images[] = $image_url;
						}
					}
				}
				
				if ( ! empty( $slider_images ) ) :
					?>
					<div class="slider-wrapper">
						<?php foreach ( $slider_images as $index => $image_url ) : ?>
							<div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" 
								 style="background-image: url('<?php echo esc_url( $image_url ); ?>');">
								<div class="slide-overlay"></div>
							</div>
						<?php endforeach; ?>
					</div>
					
					<!-- Slider Navigation -->
					<div class="slider-nav">
						<button class="slider-prev" aria-label="<?php esc_attr_e( 'Image précédente', 'toto-portfolio' ); ?>">
						</button>
						<button class="slider-next" aria-label="<?php esc_attr_e( 'Image suivante', 'toto-portfolio' ); ?>">
						</button>
					</div>
					
					<!-- Slider Dots -->
					<!-- <div class="slider-dots">
						<?php foreach ( $slider_images as $index => $image_url ) : ?>
							<button class="slider-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
									data-slide="<?php echo $index; ?>"
									aria-label="<?php printf( esc_attr__( 'Aller à l\'image %d', 'toto-portfolio' ), $index + 1 ); ?>">
							</button>
						<?php endforeach; ?>
					</div> -->
					<?php
				else :
					?>
					<!-- Fallback si aucune image -->
					<div class="slider-fallback">
						<div class="slider-content">
							<h1 class="slider-title"><?php bloginfo( 'name' ); ?></h1>
							<p class="slider-subtitle">
								<?php 
								$description = get_bloginfo( 'description', 'display' );
								echo $description ?: esc_html__( 'Portfolio de photographies', 'toto-portfolio' );
								?>
							</p>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
		</section>

		<!-- Section À propos -->
		<section id="about" class="about-section full-height">
			<div class="section-container">
				<div class="section-content">
					<!-- SVG Picto en haut -->
					<div class="section-picto fade-in-quick">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/img/picto_pic.svg' ); ?>" alt="<?php esc_attr_e( 'Icône photographie', 'toto-portfolio' ); ?>" class="picto-svg">
					</div>
					
					<!-- Bloc de deux colonnes centré -->
					<div class="about-content-wrapper scroll-animate">
						<div class="about-columns">
							<!-- Colonne gauche : Photo ACF -->
							<div class="about-photo-column">
								<?php
								if ( function_exists( 'get_field' ) ) {
									$about_photo = get_field( 'photo' );
									if ( $about_photo ) :
										?>
										<div class="about-photo">
											<img src="<?php echo esc_url( $about_photo['url'] ); ?>" alt="<?php echo esc_attr( $about_photo['alt'] ?: __( 'Photo à propos', 'toto-portfolio' ) ); ?>">
										</div>
										<?php
									endif;
								}
								?>
							</div>
							
							<!-- Colonne droite : Contenu textuel ACF -->
							<div class="about-text-column">
								<?php
								if ( function_exists( 'get_field' ) ) {
									$about_content = get_field( 'contenu_textuel' );
									if ( $about_content ) {
										echo wp_kses_post( $about_content );
									} else {
										// Contenu de fallback si le champ ACF n'est pas défini
										?>
										<h3><?php esc_html_e( 'À propos', 'toto-portfolio' ); ?></h3>
										<p class="lead">Photographe passionné, je capture les moments précieux de votre vie avec créativité et émotion.</p>
										<p>Fort de plusieurs années d'expérience dans le domaine de la photographie, je me spécialise dans les portraits, les événements et la photographie artistique. Mon approche se caractérise par une attention particulière aux détails et une recherche constante de l'authenticité.</p>
										<p>Chaque séance photo est unique et personnalisée selon vos besoins et vos envies. Mon objectif est de créer des images intemporelles qui racontent votre histoire.</p>
										<?php
									}
								}
								?>
							</div>
						</div>
					</div>
					
					<!-- SVG Séparateur en bas -->
					<div class="section-separator fade-in-quick">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/img/picto_separator.svg' ); ?>" alt="<?php esc_attr_e( 'Séparateur', 'toto-portfolio' ); ?>" class="separator-svg">
					</div>
				</div>
			</div>
		</section>

		<!-- Section Galeries -->
		<section id="galleries" class="galleries-section">
			<div class="section-container">
			<div class="section-content">
				<h2 class="section-title"><strong><em><?php esc_html_e( 'ILS M\'ONT FAIT CONFIANCE', 'toto-portfolio' ); ?></em></strong></h2>
				<div class="galleries-content scroll-animate">
						<div class="galleries-grid">
							<?php
							// Récupérer toutes les galeries
							$galleries = get_posts( array(
								'post_type' => 'galerie',
								'posts_per_page' => -1,
								'post_status' => 'publish',
								'meta_key' => '_thumbnail_id',
								'orderby' => 'date',
								'order' => 'DESC'
							) );
							
							if ( ! empty( $galleries ) ) :
								foreach ( $galleries as $gallery ) :
									$gallery_id = $gallery->ID;
									$gallery_title = get_the_title( $gallery_id );
									$gallery_url = get_permalink( $gallery_id );
									$gallery_image = get_the_post_thumbnail_url( $gallery_id, 'large' );
									
									if ( $gallery_image ) :
										?>
										<div class="gallery-item">
											<a href="<?php echo esc_url( $gallery_url ); ?>" class="gallery-link">
												<div class="gallery-image-container">
													<img src="<?php echo esc_url( $gallery_image ); ?>" alt="<?php echo esc_attr( $gallery_title ); ?>" class="gallery-image">
													<div class="gallery-overlay">
														<h3 class="gallery-title-overlay"><?php echo strtoupper( html_entity_decode( $gallery_title, ENT_QUOTES, 'UTF-8' ) ); ?></h3>
													</div>
												</div>
											</a>
										</div>
										<?php
									endif;
								endforeach;
							else :
								?>
								<div class="no-galleries">
									<p><?php esc_html_e( 'Aucune galerie n\'est encore disponible.', 'toto-portfolio' ); ?></p>
								</div>
								<?php
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Section Contact -->
		<section id="contact" class="contact-section">
			<div class="section-container">
			<div class="section-content">
				<h2 class="section-title scroll-animate"><strong><em><?php esc_html_e( 'RENCONTRONS-NOUS', 'toto-portfolio' ); ?></em></strong></h2>
				<div class="contact-content scroll-animate">
						<?php
						if ( function_exists( 'get_field' ) ) {
							$rencontre_content = get_field( 'rencontre-contenu-texte' );
							if ( $rencontre_content ) {
								echo '<div class="rencontre-content">' . wp_kses_post( $rencontre_content ) . '</div>';
							}
						}
						?>
						
						<div class="contact-button-wrapper">
							<a href="<?php echo esc_url( get_permalink( 112 ) ); ?>" class="contact-photographer-btn">
								<?php esc_html_e( 'Contacter mon futur photographe', 'toto-portfolio' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();