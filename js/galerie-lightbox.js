/**
 * Galerie Lightbox functionality
 */
(function () {
	"use strict";

	// Variables globales
	let lightbox = null;
	let lightboxImg = null;
	let lightboxCaption = null;
	let prevBtn = null;
	let nextBtn = null;
	let closeBtn = null;
	let currentImages = [];
	let currentIndex = 0;

	/**
	 * Initialise la lightbox
	 */
	function initLightbox() {
		lightbox = document.getElementById("galerie-lightbox");
		lightboxImg = document.getElementById("galerie-lightbox-img");
		lightboxCaption = document.getElementById("galerie-lightbox-caption");
		prevBtn = document.getElementById("galerie-prev");
		nextBtn = document.getElementById("galerie-next");
		closeBtn = document.querySelector(".galerie-close");

		if (!lightbox || !lightboxImg) {
			return; // Pas de lightbox sur cette page
		}

		// Collecte toutes les images de la galerie
		collectGalleryImages();

		// Ajoute les événements
		addEventListeners();
	}

	/**
	 * Collecte toutes les images de la galerie
	 */
	function collectGalleryImages() {
		const galleryImages = document.querySelectorAll(".galerie-image");
		currentImages = Array.from(galleryImages).map((img) => ({
			src: img.getAttribute("data-full") || img.src,
			alt: img.alt,
			caption: img.getAttribute("data-caption") || "",
		}));
	}

	/**
	 * Ajoute les événements
	 */
	function addEventListeners() {
		// Clic sur les images de galerie
		document.querySelectorAll(".galerie-image").forEach((img, index) => {
			img.addEventListener("click", () => openLightbox(index));
		});

		// Bouton fermer
		if (closeBtn) {
			closeBtn.addEventListener("click", closeLightbox);
		}

		// Navigation
		if (prevBtn) {
			prevBtn.addEventListener("click", showPrevImage);
		}

		if (nextBtn) {
			nextBtn.addEventListener("click", showNextImage);
		}

		// Clic en dehors de l'image pour fermer
		lightbox.addEventListener("click", (e) => {
			if (e.target === lightbox) {
				closeLightbox();
			}
		});

		// Navigation au clavier
		document.addEventListener("keydown", handleKeyboard);
	}

	/**
	 * Ouvre la lightbox
	 */
	function openLightbox(index) {
		if (!lightbox || currentImages.length === 0) return;

		currentIndex = index;
		document.body.classList.add("galerie-lightbox-open");
		lightbox.style.display = "block";
		showImage();

		// Focus sur la lightbox pour l'accessibilité
		lightbox.focus();
	}

	/**
	 * Ferme la lightbox
	 */
	function closeLightbox() {
		if (!lightbox) return;

		document.body.classList.remove("galerie-lightbox-open");
		lightbox.style.display = "none";

		// Remet le focus sur l'image qui était cliquée
		const currentImg =
			document.querySelectorAll(".galerie-image")[currentIndex];
		if (currentImg) {
			currentImg.focus();
		}
	}

	/**
	 * Affiche l'image courante
	 */
	function showImage() {
		if (currentIndex < 0 || currentIndex >= currentImages.length) return;

		const currentImage = currentImages[currentIndex];

		// Précharge l'image
		const img = new Image();
		img.onload = () => {
			lightboxImg.src = currentImage.src;
			lightboxImg.alt = currentImage.alt;

			// Affiche la caption si elle existe
			if (lightboxCaption) {
				lightboxCaption.textContent = currentImage.caption;
				lightboxCaption.style.display = currentImage.caption ? "block" : "none";
			}

			updateNavigationButtons();
		};
		img.src = currentImage.src;
	}

	/**
	 * Met à jour la visibilité des boutons de navigation
	 */
	function updateNavigationButtons() {
		if (prevBtn) {
			prevBtn.style.display = currentIndex > 0 ? "flex" : "none";
		}

		if (nextBtn) {
			nextBtn.style.display =
				currentIndex < currentImages.length - 1 ? "flex" : "none";
		}
	}

	/**
	 * Affiche l'image précédente
	 */
	function showPrevImage() {
		if (currentIndex > 0) {
			currentIndex--;
			showImage();
		}
	}

	/**
	 * Affiche l'image suivante
	 */
	function showNextImage() {
		if (currentIndex < currentImages.length - 1) {
			currentIndex++;
			showImage();
		}
	}

	/**
	 * Gestion du clavier
	 */
	function handleKeyboard(e) {
		if (lightbox.style.display !== "block") return;

		switch (e.key) {
			case "Escape":
				e.preventDefault();
				closeLightbox();
				break;
			case "ArrowLeft":
				e.preventDefault();
				showPrevImage();
				break;
			case "ArrowRight":
				e.preventDefault();
				showNextImage();
				break;
		}
	}

	/**
	 * Support du swipe mobile (optionnel)
	 */
	function addTouchSupport() {
		let startX = 0;
		let endX = 0;

		lightbox.addEventListener("touchstart", (e) => {
			startX = e.changedTouches[0].screenX;
		});

		lightbox.addEventListener("touchend", (e) => {
			endX = e.changedTouches[0].screenX;
			handleSwipe();
		});

		function handleSwipe() {
			const threshold = 50; // Seuil minimum pour déclencher le swipe
			const diff = startX - endX;

			if (Math.abs(diff) > threshold) {
				if (diff > 0) {
					// Swipe vers la gauche - image suivante
					showNextImage();
				} else {
					// Swipe vers la droite - image précédente
					showPrevImage();
				}
			}
		}
	}

	/**
	 * Précharge les images adjacentes pour une meilleure performance
	 */
	function preloadAdjacentImages() {
		const preloadIndices = [];

		if (currentIndex > 0) preloadIndices.push(currentIndex - 1);
		if (currentIndex < currentImages.length - 1)
			preloadIndices.push(currentIndex + 1);

		preloadIndices.forEach((index) => {
			const img = new Image();
			img.src = currentImages[index].src;
		});
	}

	// Initialise quand le DOM est prêt
	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", initLightbox);
	} else {
		initLightbox();
	}

	// Ajoute le support tactile après l'initialisation
	document.addEventListener("DOMContentLoaded", addTouchSupport);
})();
