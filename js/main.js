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

    // Login Modal functionality
    const openLoginModal = document.getElementById('openLoginModal');
    const loginModal = document.getElementById('loginModal');
    const closeLoginModal = document.getElementById('closeLoginModal');
    const loginModalForm = document.getElementById('loginModalForm');
    const toggleModalPassword = document.getElementById('toggleModalPassword');
    const modalPasswordInput = document.getElementById('modalPassword');

    // Open login modal
    if (openLoginModal) {
        openLoginModal.addEventListener('click', function(e) {
            e.preventDefault();
            loginModal.classList.remove('hidden');
            loginModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    }

    // Close login modal
    function closeLoginModalFunction() {
        loginModal.classList.add('hidden');
        loginModal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    if (closeLoginModal) {
        closeLoginModal.addEventListener('click', closeLoginModalFunction);
    }

    // Close modal when clicking outside
    if (loginModal) {
        loginModal.addEventListener('click', function(e) {
            if (e.target === loginModal) {
                closeLoginModalFunction();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !loginModal.classList.contains('hidden')) {
            closeLoginModalFunction();
        }
    });

    // Toggle password visibility in modal
    if (toggleModalPassword) {
        toggleModalPassword.addEventListener('click', function() {
            const type = modalPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            modalPasswordInput.setAttribute('type', type);
            
            // Toggle eye icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    // Handle modal login form submission
    if (loginModalForm) {
        loginModalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('modalEmail').value;
            const password = document.getElementById('modalPassword').value;
            const remember = document.getElementById('modalRemember').checked;

            // Basic validation
            if (!email || !password) {
                showLoginError('Please fill in all fields');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showLoginError('Please enter a valid email address');
                return;
            }

            // Simulate login process
            simulateModalLogin(email, password, remember);
        });
    }

    // Simulate modal login function with PHP API connection
    async function simulateModalLogin(email, password, remember) {
        // Show loading state
        const submitButton = loginModalForm.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing in...';
        submitButton.disabled = true;

        try {
            // Call PHP API
            const response = await fetch('api/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'login',
                    email: email,
                    password: password,
                    remember: remember ? 'true' : 'false'
                })
            });

            const result = await response.json();

            if (result.success) {
                // Success
                showLoginSuccess();
                
                // Store session info in localStorage (for demo purposes)
                if (remember) {
                    localStorage.setItem('rememberedEmail', email);
                    localStorage.setItem('loginTime', new Date().toISOString());
                } else {
                    sessionStorage.setItem('currentUser', email);
                }

                // Store user info
                localStorage.setItem('currentUser', JSON.stringify(result.user));

                // Close modal and show success after delay
                setTimeout(() => {
                    closeLoginModalFunction();
                    showLoginSuccessMessage();
                    
                    // Update UI to show logged in state
                    updateLoginUI(result.user);
                }, 1000);
            } else {
                // Error
                showLoginError(result.message);
                
                // Reset button
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
        } catch (error) {
            console.error('Login Error:', error);
            showLoginError('Network error. Please try again.');
            
            // Reset button
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }
    }

    // Update UI when user is logged in
    function updateLoginUI(user) {
        // Update login link to show user info
        const loginLink = document.getElementById('openLoginModal');
        if (loginLink) {
            loginLink.innerHTML = `
                <i class="fas fa-user mr-1"></i>
                ${user.name}
                <a href="#" id="logoutLink" class="ml-2 text-gray-500 hover:text-red-600 transition">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            `;
            
            // Add logout functionality
            const logoutLink = document.getElementById('logoutLink');
            if (logoutLink) {
                logoutLink.addEventListener('click', async function(e) {
                    e.preventDefault();
                    await handleLogout();
                });
            }
        }
    }

    // Handle logout
    async function handleLogout() {
        try {
            const response = await fetch('api/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'logout'
                })
            });

            const result = await response.json();
            
            if (result.success) {
                // Clear local storage
                localStorage.removeItem('currentUser');
                localStorage.removeItem('rememberedEmail');
                sessionStorage.removeItem('currentUser');
                
                // Show success message
                showLoginSuccess('Logged out successfully!');
                
                // Reload page to reset UI
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showLoginError('Logout failed');
            }
        } catch (error) {
            console.error('Logout Error:', error);
            showLoginError('Network error during logout');
        }
    }

    // Check login status on page load
    async function checkLoginStatus() {
        try {
            const response = await fetch('api/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'check'
                })
            });

            const result = await response.json();
            
            if (result.loggedIn && result.user) {
                // User is logged in, update UI
                updateLoginUI(result.user);
            }
        } catch (error) {
            console.log('Could not check login status:', error);
        }
    }

    // Show login success message
    function showLoginSuccess() {
        const successDiv = document.createElement('div');
        successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        successDiv.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Login successful!';
        document.body.appendChild(successDiv);
        
        setTimeout(() => {
            successDiv.remove();
        }, 3000);
    }

    // Show login error message
    function showLoginError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>' + message;
        document.body.appendChild(errorDiv);
        
        setTimeout(() => {
            errorDiv.remove();
        }, 3000);
    }

    // Show login success message
    function showLoginSuccess(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        successDiv.innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + message;
        document.body.appendChild(successDiv);
        
        setTimeout(() => {
            successDiv.remove();
        }, 3000);
    }

    // Show registration error message
    function showRegistrationError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>' + message;
        document.body.appendChild(errorDiv);
        
        setTimeout(() => {
            errorDiv.remove();
        }, 4000);
    }

    // Show registration success message
    function showRegistrationSuccess(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        successDiv.innerHTML = '<i class="fas fa-user-plus mr-2"></i>' + message;
        document.body.appendChild(successDiv);
        
        setTimeout(() => {
            successDiv.remove();
        }, 4000);
    }

    // Show info message (for general notifications)
    function showInfoMessage(message) {
        const infoDiv = document.createElement('div');
        infoDiv.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        infoDiv.innerHTML = '<i class="fas fa-info-circle mr-2"></i>' + message;
        document.body.appendChild(infoDiv);
        
        setTimeout(() => {
            infoDiv.remove();
        }, 3000);
    }

    // Show warning message (for validation warnings)
    function showWarningMessage(message) {
        const warningDiv = document.createElement('div');
        warningDiv.className = 'fixed top-4 right-4 bg-yellow-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        warningDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>' + message;
        document.body.appendChild(warningDiv);
        
        setTimeout(() => {
            warningDiv.remove();
        }, 3000);
    }

    // Show login success message after modal closes
    function showLoginSuccessMessage() {
        showLoginSuccess('Welcome back! You are now logged in.');
    }

    // Registration form validation and submission
    const registerModalForm = document.getElementById('registerModalForm');
    if (registerModalForm) {
        registerModalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const fullName = document.getElementById('regFullName').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const phone = document.getElementById('regPhone').value.trim();
            const company = document.getElementById('regCompany').value.trim();
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;
            const terms = document.getElementById('regTerms').checked;
            
            // Validation
            if (!fullName) {
                showRegistrationError('Full name is required');
                return;
            }
            
            if (fullName.length < 2) {
                showRegistrationError('Full name must be at least 2 characters');
                return;
            }
            
            if (!email) {
                showRegistrationError('Email address is required');
                return;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showRegistrationError('Please enter a valid email address');
                return;
            }
            
            if (!phone) {
                showRegistrationError('Phone number is required');
                return;
            }
            
            if (phone.length < 10) {
                showRegistrationError('Please enter a valid phone number');
                return;
            }
            
            if (!password) {
                showRegistrationError('Password is required');
                return;
            }
            
            if (password.length < 8) {
                showRegistrationError('Password must be at least 8 characters long');
                return;
            }
            
            if (password !== confirmPassword) {
                showRegistrationError('Passwords do not match');
                return;
            }
            
            if (!terms) {
                showRegistrationError('You must agree to the Terms and Conditions');
                return;
            }
            
            // Show loading state
            const submitButton = registerModalForm.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Account...';
            submitButton.disabled = true;
            
            // Submit form
            const formData = new FormData(registerModalForm);
            
            fetch('register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Check if registration was successful by looking for redirect or success indicators
                if (data.includes('Account created successfully') || data.includes('index.php')) {
                    showRegistrationSuccess('Account created successfully! Your account is pending approval.');
                    // Reset form
                    registerModalForm.reset();
                    // Close modal after delay
                    setTimeout(() => {
                        const registerModal = document.getElementById('registerModal');
                        if (registerModal) {
                            registerModal.classList.add('hidden');
                            registerModal.classList.remove('flex');
                        }
                        // Open login modal
                        const loginModal = document.getElementById('loginModal');
                        if (loginModal) {
                            loginModal.classList.remove('hidden');
                            loginModal.classList.add('flex');
                        }
                    }, 2000);
                } else {
                    // Look for error messages in response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const errorElements = doc.querySelectorAll('.text-red-700 li');
                    
                    if (errorElements.length > 0) {
                        const errorText = Array.from(errorElements).map(el => el.textContent).join('; ');
                        showRegistrationError(errorText);
                    } else {
                        showRegistrationError('Registration failed. Please try again.');
                    }
                }
            })
            .catch(error => {
                console.error('Registration Error:', error);
                showRegistrationError('Network error. Please try again.');
            })
            .finally(() => {
                // Reset button
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    }

    // Registration modal form field validation on input
    const regPassword = document.getElementById('regPassword');
    const regConfirmPassword = document.getElementById('regConfirmPassword');
    
    if (regPassword && regConfirmPassword) {
        regConfirmPassword.addEventListener('input', function() {
            if (this.value && this.value !== regPassword.value) {
                this.setCustomValidity('Passwords do not match');
                showWarningMessage('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Check if user was remembered and pre-fill modal
    function checkRememberedUserForModal() {
        const rememberedEmail = localStorage.getItem('rememberedEmail');
        if (rememberedEmail) {
            const modalEmailInput = document.getElementById('modalEmail');
            if (modalEmailInput) {
                modalEmailInput.value = rememberedEmail;
                document.getElementById('modalRemember').checked = true;
            }
        }
    }

    // Handle social login buttons in modal
    document.querySelectorAll('#loginModal button').forEach(button => {
        if (button.textContent.includes('Google') || button.textContent.includes('Microsoft')) {
            button.addEventListener('click', function() {
                showLoginError('Social login not implemented yet');
            });
        }
    });

    // Handle forgot password link in modal
    document.querySelectorAll('#loginModal a[href="#"]').forEach(link => {
        if (link.textContent.includes('Forgot password')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showLoginError('Password reset feature coming soon');
            });
        }
        // Registration is now enabled - removed coming soon message
    });

    // Initialize modal functionality
    checkRememberedUserForModal();
    checkLoginStatus();

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
