// Lion Equipment Company - Main JavaScript File

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu functionality
    const mobileMenuButton = document.querySelector('button.md\\:hidden');
    const mobileMenu = document.createElement('div');
    mobileMenu.className = 'hidden md:hidden bg-white shadow-lg absolute top-16 left-0 right-0';
    mobileMenu.innerHTML = `
        <div class="px-6 py-4 space-y-2">
            <a href="#home" class="block text-gray-700 hover:text-red-600 transition py-2">Home</a>
            <a href="#services" class="block text-gray-700 hover:text-red-600 transition py-2">Services</a>
            <a href="#crane-fleet" class="block text-gray-700 hover:text-red-600 transition py-2">Crane Fleet</a>
            <a href="#past-projects" class="block text-gray-700 hover:text-red-600 transition py-2">Past Projects</a>
            <a href="#about" class="block text-gray-700 hover:text-red-600 transition py-2">About</a>
            <a href="#contact" class="block text-gray-700 hover:text-red-600 transition py-2">Contact</a>
        </div>
    `;
    
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        document.querySelector('nav').appendChild(mobileMenu);
    }

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                // Close mobile menu if open
                if (mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
    });

    // Responsive Slideshow functionality
    let currentSlide = 0;
    let slideInterval;
    
    function showSlide(index) {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slideshow-dot');
        
        if (slides.length === 0) return;
        
        // Hide all slides
        slides.forEach((slide, i) => {
            slide.style.opacity = '0';
            if (dots[i]) {
                dots[i].classList.remove('bg-white', 'opacity-100');
                dots[i].classList.add('bg-white/50', 'opacity-50');
            }
        });
        
        // Show current slide
        if (slides[index]) {
            slides[index].style.opacity = '1';
            if (dots[index]) {
                dots[index].classList.remove('bg-white/50', 'opacity-50');
                dots[index].classList.add('bg-white', 'opacity-100');
            }
        }
        currentSlide = index;
    }
    
    function nextSlide() {
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }
    
    function prevSlide() {
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }
    
    function startSlideshow() {
        slideInterval = setInterval(nextSlide, 5000);
    }
    
    function stopSlideshow() {
        if (slideInterval) {
            clearInterval(slideInterval);
        }
    }
    
    // Initialize responsive slideshow
    const slides = document.querySelectorAll('.slide');
    
    if (slides.length > 0) {
        // Show first slide
        showSlide(0);
        
        // Start auto-advance
        startSlideshow();
        
        // Navigation arrow controls
        const nextBtn = document.getElementById('nextSlide');
        const prevBtn = document.getElementById('prevSlide');
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                stopSlideshow();
                nextSlide();
                startSlideshow();
            });
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                stopSlideshow();
                prevSlide();
                startSlideshow();
            });
        }
        
        // Dot navigation
        const dots = document.querySelectorAll('.slideshow-dot');
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function(e) {
                e.preventDefault();
                stopSlideshow();
                showSlide(index);
                startSlideshow();
            });
        });
    }

    // Modal functionality
    const viewDetailsBtn = document.getElementById('viewDetailsBtn');
    const detailsModal = document.getElementById('detailsModal');
    const closeModal = document.getElementById('closeModal');
    const viewFormBtns = document.querySelectorAll('.view-form-btn');

    // Open modal for View Details button
    if (viewDetailsBtn) {
        viewDetailsBtn.addEventListener('click', function() {
            detailsModal.classList.remove('hidden');
            detailsModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    }

    // Close modal functions
    function closeModalFunction() {
        detailsModal.classList.add('hidden');
        detailsModal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    if (closeModal) {
        closeModal.addEventListener('click', closeModalFunction);
    }

    // Close modal when clicking outside
    if (detailsModal) {
        detailsModal.addEventListener('click', function(e) {
            if (e.target === detailsModal) {
                closeModalFunction();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !detailsModal.classList.contains('hidden')) {
            closeModalFunction();
        }
    });

    // Form submission (if form exists)
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your message! We will contact you within 24 hours.');
            this.reset();
        });
    }
});
