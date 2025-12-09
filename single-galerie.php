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

				<?php if ( get_the_content() ) : ?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				<?php endif; ?>

				<?php
				// Récupérer les images du champ ACF
				$images = get_field('elements_galerie');
				if ( $images ) :
					?>
					<div class="galerie-masonry-container">
						<div class="galerie-masonry" id="galerie-masonry">
							<?php foreach ( $images as $image ) :
								$image_url = $image['sizes']['large'];
								$image_full_url = $image['url'];
								$image_alt = $image['alt'];
								$image_caption = $image['caption'];
								
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
				else :
					?>
					<p>Aucune image trouvée dans cette galerie.</p>
					<?php
				endif;
				?>

				<!-- Bouton de contact -->
				<div class="contact-button-wrapper">
					<a href="<?php echo esc_url( get_permalink( 112 ) ); ?>" class="contact-photographer-btn">
						Contacter mon futur photographe
					</a>
				</div>

			</article>

		<?php endwhile; ?>

	</main><!-- #main -->

	<!-- Lightbox pour la galerie -->
	<div id="galerie-lightbox" class="galerie-lightbox">
		<span class="galerie-close">&times;</span>
		<img class="galerie-lightbox-content" id="galerie-lightbox-img">
		<div class="galerie-lightbox-caption" id="galerie-lightbox-caption"></div>
		<a class="galerie-prev" id="galerie-prev">&#10094;</a>
		<a class="galerie-next" id="galerie-next">&#10095;</a>
	</div>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Variables de la lightbox
		const lightbox = document.getElementById('galerie-lightbox');
		const lightboxImg = document.getElementById('galerie-lightbox-img');
		const lightboxCaption = document.getElementById('galerie-lightbox-caption');
		const closeBtn = document.querySelector('.galerie-close');
		const prevBtn = document.getElementById('galerie-prev');
		const nextBtn = document.getElementById('galerie-next');
		
		// Récupérer toutes les images de la galerie
		const galerieImages = document.querySelectorAll('.galerie-image');
		let currentImageIndex = 0;
		
		// Fonction pour changer l'image avec effet fade uniquement sur la nouvelle image
		function changeImage(index) {
			const img = galerieImages[index];
			const fullUrl = img.getAttribute('data-full');
			const caption = img.getAttribute('data-caption');
			
			// Changer immédiatement l'image sans fade out
			lightboxImg.style.opacity = '0';
			lightboxImg.src = fullUrl;
			lightboxImg.alt = img.alt;
			lightboxCaption.textContent = caption || '';
			lightboxCaption.style.display = caption ? 'block' : 'none';
			
			// Effet fade in uniquement sur la nouvelle image
			setTimeout(() => {
				lightboxImg.style.opacity = '1';
			}, 50); // Délai très court pour que l'image se charge
		}
		
		// Fonction pour ouvrir la lightbox
		function openLightbox(index) {
			currentImageIndex = index;
			const img = galerieImages[index];
			const fullUrl = img.getAttribute('data-full');
			const caption = img.getAttribute('data-caption');
			
			lightboxImg.src = fullUrl;
			lightboxImg.alt = img.alt;
			lightboxCaption.textContent = caption || '';
			lightboxCaption.style.display = caption ? 'block' : 'none';
			
			lightbox.style.display = 'block';
			document.body.classList.add('galerie-lightbox-open');
			
			// Focus sur la lightbox pour l'accessibilité
			lightbox.focus();
		}
		
		// Fonction pour fermer la lightbox
		function closeLightbox() {
			lightbox.style.display = 'none';
			document.body.classList.remove('galerie-lightbox-open');
		}
		
		// Fonction pour naviguer vers l'image suivante
		function nextImage() {
			currentImageIndex = (currentImageIndex + 1) % galerieImages.length;
			changeImage(currentImageIndex);
		}
		
		// Fonction pour naviguer vers l'image précédente
		function prevImage() {
			currentImageIndex = (currentImageIndex - 1 + galerieImages.length) % galerieImages.length;
			changeImage(currentImageIndex);
		}
		
		// Event listeners
		galerieImages.forEach((img, index) => {
			img.addEventListener('click', function() {
				openLightbox(index);
			});
		});
		
		closeBtn.addEventListener('click', closeLightbox);
		nextBtn.addEventListener('click', nextImage);
		prevBtn.addEventListener('click', prevImage);
		
		// Fermer en cliquant en dehors de l'image
		lightbox.addEventListener('click', function(e) {
			if (e.target === lightbox) {
				closeLightbox();
			}
		});
		
		// Navigation au clavier
		document.addEventListener('keydown', function(e) {
			if (lightbox.style.display === 'block') {
				switch(e.key) {
					case 'Escape':
						closeLightbox();
						break;
					case 'ArrowRight':
						nextImage();
						break;
					case 'ArrowLeft':
						prevImage();
						break;
				}
			}
		});
	});
	</script>

<?php
get_footer();