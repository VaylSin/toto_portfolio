/**
 * Homepage slider and navigation functionality
 */
document.addEventListener("DOMContentLoaded", function () {
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
					// Utiliser le smooth scroll personnalisé sur desktop
					if (
						window.smoothScrollTo &&
						document.body.classList.contains("smooth-scroll")
					) {
						window.smoothScrollTo(targetElement);
					} else {
						// Fallback scroll classique pour mobile/tablet
						const headerHeight =
							document.querySelector(".site-header").offsetHeight;
						const targetPosition = targetElement.offsetTop - headerHeight;

						window.scrollTo({
							top: targetPosition,
							behavior: "smooth",
						});
					}

					// Update active menu item
					updateActiveMenuItem(targetId);

					// Close mobile menu if open
					const navigation = document.querySelector(".main-navigation");
					const menuToggle = document.querySelector(".menu-toggle");
					if (navigation.classList.contains("active")) {
						navigation.classList.remove("active");
						menuToggle.classList.remove("active");
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
		let lastScrollTop = 0;

		window.addEventListener("scroll", function () {
			const scrollTop =
				window.pageYOffset || document.documentElement.scrollTop;

			if (scrollTop > 100) {
				header.classList.add("scrolled");
			} else {
				header.classList.remove("scrolled");
			}

			// Update active menu item based on scroll position
			updateActiveMenuOnScroll();

			lastScrollTop = scrollTop;
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

	// Mobile menu toggle
	function initMobileMenu() {
		const menuToggle = document.querySelector(".menu-toggle");
		const navigation = document.querySelector(".main-navigation");

		if (menuToggle) {
			menuToggle.addEventListener("click", function () {
				navigation.classList.toggle("active");
				menuToggle.classList.toggle("active");
			});
		}

		// Close menu when clicking outside
		document.addEventListener("click", function (e) {
			if (!navigation.contains(e.target) && !menuToggle.contains(e.target)) {
				navigation.classList.remove("active");
				menuToggle.classList.remove("active");
			}
		});

		// Close menu on escape key
		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape") {
				navigation.classList.remove("active");
				menuToggle.classList.remove("active");
			}
		});
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
	} // Initialize all functions
	initPageLoader();
	initSmoothScrolling();
	initHeaderScrollEffect();
	initMobileMenu();
	initSlider();
	initScrollIndicator();
	initScrollAnimations();

	// Set initial active menu item
	if (window.location.hash) {
		updateActiveMenuItem(window.location.hash);
	} else {
		updateActiveMenuItem("#home");
	}
});
