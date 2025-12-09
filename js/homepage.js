/**
 * Homepage slider and navigation functionality
 */
document.addEventListener("DOMContentLoaded", function () {
	// Initialiser les backgrounds dynamiques
	function initDynamicBackgrounds() {
		// Slides du slider
		const slides = document.querySelectorAll(".slide[data-bg]");
		slides.forEach((slide) => {
			const bg = slide.getAttribute("data-bg");
			if (bg) {
				slide.style.backgroundImage = `url('${bg}')`;
			}
		});

		// Contact header image
		const contactHeader = document.querySelector(
			".contact-header-image[data-bg]"
		);
		if (contactHeader) {
			const bg = contactHeader.getAttribute("data-bg");
			if (bg) {
				contactHeader.style.backgroundImage = `url('${bg}')`;
			}
		}
	}

	// Page Loader
	function initPageLoader() {
		const loader = document.getElementById("page-loader");
		const progressFill = document.getElementById("progress-fill");

		if (!loader || !progressFill) return;

		let progress = 0;
		const interval = setInterval(() => {
			progress += Math.random() * 15 + 5; // Progression aléatoire entre 5% et 20%

			if (progress >= 100) {
				progress = 100;
				clearInterval(interval);

				// Compléter la barre
				progressFill.style.width = progress + "%";

				// Masquer le loader après un court délai
				setTimeout(() => {
					loader.classList.add("hidden");
					document.body.classList.remove("loading"); // Réactiver le scroll

					// Supprimer complètement le loader du DOM après la transition
					setTimeout(() => {
						loader.remove();
					}, 200);
				}, 300);
			} else {
				progressFill.style.width = progress + "%";
			}
		}, 100);

		// Forcer la fin du loading après 3 secondes maximum
		setTimeout(() => {
			if (progress < 100) {
				progress = 100;
				clearInterval(interval);
				progressFill.style.width = "100%";

				setTimeout(() => {
					loader.classList.add("hidden");
					document.body.classList.remove("loading"); // Réactiver le scroll
					setTimeout(() => {
						loader.remove();
					}, 200);
				}, 300);
			}
		}, 3000);
	}

	// Fonction supprimée - smooth scroll causait des conflits

	// Smooth scrolling for anchor links
	function initSmoothScrolling() {
		const anchorLinks = document.querySelectorAll('a[href^="#"]');

		anchorLinks.forEach((link) => {
			link.addEventListener("click", function (e) {
				e.preventDefault();

				const targetId = this.getAttribute("href");
				const targetElement = document.querySelector(targetId);

				if (targetElement) {
					// Scroll vers l'élément
					const headerHeight =
						document.querySelector(".site-header").offsetHeight;
					const targetPosition = targetElement.offsetTop - headerHeight;

					window.scrollTo({
						top: targetPosition,
						behavior: "smooth",
					});

					// Update active menu item
					updateActiveMenuItem(targetId);

					// Close mobile menu if open
					const navigation = document.querySelector(
						".header-nav, .main-navigation"
					);
					const menuToggle = document.querySelector(".menu-toggle");
					if (navigation && navigation.classList.contains("mobile-active")) {
						navigation.classList.remove("mobile-active");
						menuToggle.classList.remove("active");
						document.body.classList.remove("mobile-menu-open");
					}
				}
			});
		});
	}

	// Update active menu item
	function updateActiveMenuItem(targetId) {
		const menuLinks = document.querySelectorAll(
			".homepage-menu a, .fallback-menu a"
		);
		menuLinks.forEach((link) => {
			link.classList.remove("active");
			if (link.getAttribute("href") === targetId) {
				link.classList.add("active");
			}
		});
	}

	// Header scroll effect
	function initHeaderScrollEffect() {
		const header = document.querySelector(".site-header");
		if (!header) return;

		window.addEventListener("scroll", function () {
			const scrollTop =
				window.pageYOffset || document.documentElement.scrollTop;

			if (scrollTop > 50) {
				header.classList.add("scrolled");
			} else {
				header.classList.remove("scrolled");
			}

			// Update active menu item based on scroll position
			updateActiveMenuOnScroll();
		});
	}

	// Update active menu item based on scroll position
	function updateActiveMenuOnScroll() {
		const sections = document.querySelectorAll("section[id]");
		const headerHeight = document.querySelector(".site-header").offsetHeight;
		const scrollPos = window.pageYOffset + headerHeight + 50;

		sections.forEach((section) => {
			const sectionTop = section.offsetTop;
			const sectionHeight = section.offsetHeight;
			const sectionId = "#" + section.getAttribute("id");

			if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
				updateActiveMenuItem(sectionId);
			}
		});
	}

	// Menu mobile simple avec burger
	function initMobileMenu() {
		// Attendre que le DOM soit complètement chargé
		setTimeout(() => {
			const menuToggle = document.querySelector(".menu-toggle");
			const navigation = document.querySelector(
				".header-nav, .main-navigation"
			);
			const body = document.body;
			let isMenuOpen = false;

			if (!menuToggle || !navigation) {
				return;
			}

			// Toggle du menu
			function toggleMenu() {
				isMenuOpen = !isMenuOpen;

				if (isMenuOpen) {
					menuToggle.classList.add("active");
					navigation.classList.add("mobile-active");
					body.classList.add("mobile-menu-open");
				} else {
					menuToggle.classList.remove("active");
					navigation.classList.remove("mobile-active");
					body.classList.remove("mobile-menu-open");
				}
			}

			// Clic sur le bouton burger
			menuToggle.addEventListener("click", (e) => {
				e.preventDefault();
				e.stopPropagation();
				toggleMenu();
			});

			// Fermer en cliquant à l'extérieur
			document.addEventListener("click", (e) => {
				if (
					isMenuOpen &&
					!navigation.contains(e.target) &&
					!menuToggle.contains(e.target)
				) {
					toggleMenu();
				}
			});

			// Fermer avec Echap
			document.addEventListener("keydown", (e) => {
				if (e.key === "Escape" && isMenuOpen) {
					toggleMenu();
				}
			});

			// Fermer le menu au clic sur un lien
			const menuLinks = navigation.querySelectorAll("a");
			menuLinks.forEach((link) => {
				link.addEventListener("click", () => {
					if (isMenuOpen) {
						setTimeout(() => toggleMenu(), 200);
					}
				});
			});

			// Fermer si redimensionnement vers desktop
			window.addEventListener("resize", () => {
				if (window.innerWidth > 992 && isMenuOpen) {
					toggleMenu();
				}
			});

			console.log("Menu mobile initialisé avec succès");
		}, 100);
	}

	// Slider functionality
	function initSlider() {
		const slider = document.querySelector(".slider-wrapper");
		const slides = document.querySelectorAll(".slide");
		const prevButton = document.querySelector(".slider-prev");
		const nextButton = document.querySelector(".slider-next");
		const dots = document.querySelectorAll(".slider-dot");

		if (!slider || slides.length === 0) return;

		let currentSlide = 0;
		let autoplayInterval;

		// Show specific slide
		function showSlide(index) {
			slides.forEach((slide, i) => {
				slide.classList.toggle("active", i === index);
			});

			dots.forEach((dot, i) => {
				dot.classList.toggle("active", i === index);
			});

			currentSlide = index;
		}

		// Next slide
		function nextSlide() {
			const next = (currentSlide + 1) % slides.length;
			showSlide(next);
		}

		// Previous slide
		function prevSlide() {
			const prev = currentSlide === 0 ? slides.length - 1 : currentSlide - 1;
			showSlide(prev);
		}

		// Start autoplay
		function startAutoplay() {
			autoplayInterval = setInterval(nextSlide, 10000);
		}

		// Stop autoplay
		function stopAutoplay() {
			clearInterval(autoplayInterval);
		}

		// Initialize first slide
		if (slides.length > 0) {
			showSlide(0);
		}

		// Event listeners
		if (nextButton) {
			nextButton.addEventListener("click", () => {
				nextSlide();
				stopAutoplay();
				setTimeout(startAutoplay, 10000); // Restart autoplay after 10 seconds
			});
		}

		if (prevButton) {
			prevButton.addEventListener("click", () => {
				prevSlide();
				stopAutoplay();
				setTimeout(startAutoplay, 10000);
			});
		}

		dots.forEach((dot, index) => {
			dot.addEventListener("click", () => {
				showSlide(index);
				stopAutoplay();
				setTimeout(startAutoplay, 10000);
			});
		});

		// Pause autoplay on hover
		slider.addEventListener("mouseenter", stopAutoplay);
		slider.addEventListener("mouseleave", startAutoplay);

		// Keyboard navigation
		document.addEventListener("keydown", (e) => {
			if (e.key === "ArrowLeft") {
				prevSlide();
				stopAutoplay();
				setTimeout(startAutoplay, 10000);
			} else if (e.key === "ArrowRight") {
				nextSlide();
				stopAutoplay();
				setTimeout(startAutoplay, 10000);
			}
		});

		// Start autoplay
		if (slides.length > 1) {
			startAutoplay();
		}

		// Touch/swipe support for mobile
		let touchStartX = 0;
		let touchStartY = 0;

		slider.addEventListener("touchstart", (e) => {
			touchStartX = e.touches[0].clientX;
			touchStartY = e.touches[0].clientY;
		});

		slider.addEventListener("touchend", (e) => {
			if (!touchStartX || !touchStartY) return;

			const touchEndX = e.changedTouches[0].clientX;
			const touchEndY = e.changedTouches[0].clientY;

			const diffX = touchStartX - touchEndX;
			const diffY = touchStartY - touchEndY;

			// Only handle horizontal swipes
			if (Math.abs(diffX) > Math.abs(diffY)) {
				if (Math.abs(diffX) > 50) {
					// Minimum swipe distance
					if (diffX > 0) {
						nextSlide(); // Swipe left - next slide
					} else {
						prevSlide(); // Swipe right - previous slide
					}
					stopAutoplay();
					setTimeout(startAutoplay, 10000);
				}
			}

			touchStartX = 0;
			touchStartY = 0;
		});
	}

	// Scroll indicator
	function initScrollIndicator() {
		const scrollIndicator = document.querySelector(".scroll-indicator");

		if (scrollIndicator) {
			window.addEventListener("scroll", () => {
				const scrollPercentage = window.pageYOffset / window.innerHeight;

				if (scrollPercentage > 0.8) {
					scrollIndicator.style.opacity = "0";
				} else {
					scrollIndicator.style.opacity = "1";
				}
			});
		}
	}

	// Animations au scroll - version simple qui fonctionne
	function initScrollAnimations() {
		const elements = document.querySelectorAll(
			".scroll-animate, .fade-in-quick"
		);

		if (elements.length === 0) return;

		function checkScroll() {
			elements.forEach((element) => {
				const elementTop = element.getBoundingClientRect().top;
				const elementVisible = 150;

				if (elementTop < window.innerHeight - elementVisible) {
					element.classList.add("visible");
				}
			});
		}

		window.addEventListener("scroll", checkScroll);
		checkScroll(); // Check on load
	}

	// Initialize all functions
	initDynamicBackgrounds(); // Sur toutes les pages
	initPageLoader();
	initHeaderScrollEffect();
	initMobileMenu(); // Menu mobile sur toutes les pages

	// Fonctions spécifiques à la homepage
	if (document.body.classList.contains("home")) {
		initSmoothScrolling();
		initSlider();
		initScrollIndicator();
		initScrollAnimations();

		// Set initial active menu item
		if (window.location.hash) {
			updateActiveMenuItem(window.location.hash);
		} else {
			updateActiveMenuItem("#home");
		}
	}
});
