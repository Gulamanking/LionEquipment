// Lion Equipment Company - Login Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle eye icon
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Handle form submission
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const remember = document.getElementById('remember').checked;

        // Basic validation
        if (!email || !password) {
            showError('Please fill in all fields');
            return;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showError('Please enter a valid email address');
            return;
        }

        // Simulate login process (in real app, this would be an API call)
        simulateLogin(email, password, remember);
    });

    // Simulate login function
    function simulateLogin(email, password, remember) {
        // Show loading state
        const submitButton = loginForm.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing in...';
        submitButton.disabled = true;

        // Simulate API call delay
        setTimeout(() => {
            // Demo credentials for testing
            const validCredentials = [
                { email: 'admin@lionequipment.com', password: 'admin123' },
                { email: 'user@lionequipment.com', password: 'user123' },
                { email: 'ronaldroldan101@gmail.com', password: 'password123' }
            ];

            const isValid = validCredentials.some(cred => 
                cred.email === email && cred.password === password
            );

            if (isValid) {
                // Success
                showSuccess();
                
                // Store session if remember me is checked
                if (remember) {
                    localStorage.setItem('rememberedEmail', email);
                    localStorage.setItem('loginTime', new Date().toISOString());
                } else {
                    sessionStorage.setItem('currentUser', email);
                }

                // Redirect after delay
                setTimeout(() => {
                    window.location.href = '../index.html';
                }, 2000);
            } else {
                // Error
                showError('Invalid email or password');
                
                // Reset button
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
        }, 1500);
    }

    // Show success message
    function showSuccess() {
        successMessage.classList.remove('hidden');
        errorMessage.classList.add('hidden');
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
            successMessage.classList.add('hidden');
        }, 3000);
    }

    // Show error message
    function showError(message) {
        errorText.textContent = message;
        errorMessage.classList.remove('hidden');
        successMessage.classList.add('hidden');
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
            errorMessage.classList.add('hidden');
        }, 3000);
    }

    // Check if user was remembered
    function checkRememberedUser() {
        const rememberedEmail = localStorage.getItem('rememberedEmail');
        if (rememberedEmail) {
            document.getElementById('email').value = rememberedEmail;
            document.getElementById('remember').checked = true;
        }
    }

    // Check if user is already logged in
    function checkLoginStatus() {
        const currentUser = sessionStorage.getItem('currentUser');
        const rememberedEmail = localStorage.getItem('rememberedEmail');
        
        if (currentUser || rememberedEmail) {
            // User is already logged in, redirect to dashboard or home
            window.location.href = '../index.html';
        }
    }

    // Handle social login buttons
    document.querySelectorAll('button').forEach(button => {
        if (button.textContent.includes('Google') || button.textContent.includes('Microsoft')) {
            button.addEventListener('click', function() {
                showError('Social login not implemented yet');
            });
        }
    });

    // Handle forgot password link
    document.querySelector('a[href="#"]').addEventListener('click', function(e) {
        if (this.textContent.includes('Forgot password')) {
            e.preventDefault();
            showError('Password reset feature coming soon');
        }
    });

    // Handle sign up link
    document.querySelectorAll('a[href="#"]').forEach(link => {
        if (link.textContent.includes('Sign up')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showError('Registration feature coming soon');
            });
        }
    });

    // Initialize
    checkLoginStatus();
    checkRememberedUser();

    // Add input validation feedback
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
            }
        });

        input.addEventListener('focus', function() {
            this.classList.remove('border-red-500');
        });
    });

    // Add form field animations
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('transform', 'scale-105');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('transform', 'scale-105');
        });
    });
});
