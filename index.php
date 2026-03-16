<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lion Equipment Company</title>
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@700;900&display=swap" rel="stylesheet">
    <script src="js/main.js" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { 
            font-family: 'Prompt', 'Inter', sans-serif; 
            font-weight: 700;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        }
        .service-card {
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(220, 38, 38, 0.1);
        }
        .scroll-smooth {
            scroll-behavior: smooth;
        }
        
        /* Red Black Theme Styles */
        body {
            background-color: #000000;
            color: #ffffff;
        }
        
        .bg-white {
            background-color: #000000 !important;
        }
        
        .bg-gray-50 {
            background-color: #000000 !important;
        }
        
        .bg-red-50 {
            background-color: #000000 !important;
        }
        
        .bg-gray-100 {
            background-color: #000000 !important;
        }
        
        .text-gray-800 {
            color: #ffffff !important;
        }
        
        .text-gray-700 {
            color: #ffffff !important;
        }
        
        .text-gray-600 {
            color: #ffffff !important;
        }
        
        .text-gray-500 {
            color: #ffffff !important;
        }
        
        .text-gray-400 {
            color: #ff0000 !important;
        }
        
        .border-gray-200 {
            border-color: #ff0000 !important;
        }
        
        .border-gray-300 {
            border-color: #ff0000 !important;
        }
        
        .border-gray-800 {
            border-color: #ff0000 !important;
        }
        
        nav {
            background-color: #000000 !important;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(255, 0, 0, 0.3) !important;
        }
        
        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(255, 0, 0, 0.4) !important;
        }
        
        input, select, textarea {
            background-color: #000000 !important;
            color: #ffffff !important;
            border-color: #ff0000 !important;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #000000 0%, #ff0000 100%) !important;
        }
        
        /* Navigation Hover Styles */
        nav a:hover {
            color: #ff0000 !important;
        }
        
        nav a.text-gray-700 {
            color: #ffffff !important;
        }
        
        nav a.text-gray-700:hover {
            color: #ff0000 !important;
        }
        
        /* Red accents for important elements */
        .bg-red-600 {
            background-color: #ff0000 !important;
        }
        
        .text-red-600 {
            color: #ff0000 !important;
        }
        
        .text-red-400 {
            color: #ff0000 !important;
        }
        
        .hover\:bg-red-700:hover {
            background-color: #cc0000 !important;
        }
        
        .hover\:text-red-600:hover {
            color: #ff0000 !important;
        }
        
        .hover\:text-red-400:hover {
            color: #ff0000 !important;
        }
        
        /* Black and Red variations for depth */
        .bg-gradient-to-r {
            background: linear-gradient(to right, #000000, #000000) !important;
        }
        
        .from-gray-50 {
            background-color: #000000 !important;
        }
        
        .to-white {
            background-color: #000000 !important;
        }
        
        .bg-gray-900 {
            background-color: #000000 !important;
        }
        
        /* Footer specific styles */
        footer .text-gray-400 {
            color: #ffffff !important;
        }
        
        footer .border-gray-800 {
            border-color: #ff0000 !important;
        }
    </style>
</head>
<body class="scroll-smooth">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-lg z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img src="img/logo.jpg" alt="Lion Equipment Company" class="h-10 w-10 mr-3 rounded-full border-2 border-red-600">
                    <span class="text-2xl font-bold text-gray-800">Lion Equipment Company</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-red-600 transition">Home</a>
                    <a href="#services" class="text-gray-700 hover:text-red-600 transition">Services</a>
                    <a href="#crane-fleet" class="text-gray-700 hover:text-red-600 transition">Crane Fleet</a>
                    <a href="#past-projects" class="text-gray-700 hover:text-red-600 transition">Past Projects</a>
                    <a href="#about" class="text-gray-700 hover:text-red-600 transition">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-red-600 transition">Contact</a>
                    <a href="#" id="openLoginModal" class="text-red-600 hover:text-red-700 font-semibold transition">
                        <i class="fas fa-sign-in-alt mr-1"></i>Login
                    </a>
                </div>
                <button class="md:hidden">
                    <i class="fas fa-bars text-2xl text-gray-700"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient min-h-screen flex items-center pt-20">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6">
                        Crane Rental - Trucking - Rigging
                    </h1>
                    <p class="text-xl mb-8 text-red-100 text-justify">
                        Lion Equipment Co. specializes in crane rental and heavy equipment
                        services, including trucking, rigging, demolition, erection, skidding,
                        dismantling, and girder launching. Known for our reliability, safety, and
                        technical expertise, we support construction and infrastructure projects
                        across the Philippines.

                        Our team is committed to delivering results with efficiency,
                        professionalism, and long-term value. We take pride in being a
                        dependable partner for both public and private sector projects.
                    </div>
                <div class="hidden md:block">
                    <!-- Responsive Slideshow Container -->
                    <div class="relative rounded-lg shadow-2xl overflow-hidden">
                        <div id="responsiveSlideshow" class="relative h-64 md:h-80 lg:h-96 w-full">
                            <!-- Slide 1 -->
                            <div class="slide absolute inset-0 transition-opacity duration-1000" style="opacity: 1;">
                                <img src="img/Crane1.jpg" alt="Crane Service" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 md:p-6">
                                    <h3 class="text-white text-lg md:text-xl font-semibold">Heavy Lifting Operations</h3>
                                    <p class="text-white/80 text-xs md:text-sm">Professional crane services for all your lifting needs</p>
                                </div>
                            </div>
                            
                            <!-- Slide 2 -->
                            <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-0">
                                <img src="img/crane2.jpg" alt="Mobile Crane" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 md:p-6">
                                    <h3 class="text-white text-lg md:text-xl font-semibold">Mobile Crane Fleet</h3>
                                    <p class="text-white/80 text-xs md:text-sm">State-of-the-art mobile cranes for any project</p>
                                </div>
                            </div>
                            
                            <!-- Slide 3 -->
                            <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-0">
                                <img src="img/Crane3.jpg" alt="Trucking Services" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 md:p-6">
                                    <h3 class="text-white text-lg md:text-xl font-semibold">Heavy Equipment Transport</h3>
                                    <p class="text-white/80 text-xs md:text-sm">Safe and reliable trucking services</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Slideshow Controls -->
                        <div class="absolute bottom-2 md:bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            <button class="slideshow-dot w-2 h-2 md:w-3 md:h-3 bg-white rounded-full opacity-100 transition-opacity" data-slide="0"></button>
                            <button class="slideshow-dot w-2 h-2 md:w-3 md:h-3 bg-white/50 rounded-full transition-opacity" data-slide="1"></button>
                            <button class="slideshow-dot w-2 h-2 md:w-3 md:h-3 bg-white/50 rounded-full transition-opacity" data-slide="2"></button>
                        </div>
                        
                        <!-- Navigation Arrows -->
                        <button id="prevSlide" class="absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm text-white p-1.5 md:p-2 rounded-full hover:bg-white/30 transition">
                            <i class="fas fa-chevron-left text-sm md:text-base"></i>
                        </button>
                        <button id="nextSlide" class="absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm text-white p-1.5 md:p-2 rounded-full hover:bg-white/30 transition">
                            <i class="fas fa-chevron-right text-sm md:text-base"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Details Popup Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 p-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800"></h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6">
                <!-- Service Details Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Our Comprehensive Services</h3>
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-red-50 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-crane text-red-600 text-xl mr-3"></i>
                                <h4 class="font-semibold text-gray-800">Crane Services</h4>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Mobile Crane Operations (5-500 tons)</li>
                                <li>• Tower Crane Installation</li>
                                <li>• Rigging & Heavy Lifting</li>
                                <li>• Certified Operators Available</li>
                            </ul>
                        </div>
                        
                        <div class="bg-red-50 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-truck text-red-600 text-xl mr-3"></i>
                                <h4 class="font-semibold text-gray-800">Trucking Services</h4>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Heavy Equipment Transport</li>
                                <li>• Oversized Load Hauling</li>
                                <li>• Flatbed & Step Deck Services</li>
                                <li>• Route Planning & Permits</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-shield-alt text-red-600 text-xl mr-3"></i>
                            <h4 class="font-semibold text-gray-800">Safety & Certification</h4>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Fully Licensed & Insured</li>
                            <li>• OSHA Compliant Operations</li>
                            <li>• 24/7 Emergency Response Team</li>
                            <li>• 50+ Years Combined Experience</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Service Details Only -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Service Information</h3>
                    <div class="space-y-6">
                        <!-- Service Images Gallery -->
                        <div class="grid md:grid-cols-3 gap-4 mb-6">
                            <div class="rounded-lg overflow-hidden shadow-lg">
                                <img src="img/Crane1.jpg" alt="Crane Service" class="w-full h-40 object-cover">
                                <div class="bg-white p-3 text-center">
                                    <p class="font-semibold text-gray-800">Heavy Lifting</p>
                                </div>
                            </div>
                            <div class="rounded-lg overflow-hidden shadow-lg">
                                <img src="img/crane2.jpg" alt="Mobile Crane" class="w-full h-40 object-cover">
                                <div class="bg-white p-3 text-center">
                                    <p class="font-semibold text-gray-800">Mobile Crane</p>
                                </div>
                            </div>
                            <div class="rounded-lg overflow-hidden shadow-lg">
                                <img src="img/Crane3.jpg" alt="Trucking Services" class="w-full h-40 object-cover">
                                <div class="bg-white p-3 text-center">
                                    <p class="font-semibold text-gray-800">Transport</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-info-circle text-red-600 text-xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-800">How Our Service Works</h4>
                            </div>
                            <p class="text-gray-600 mb-4">
                                Contact us today for professional crane and trucking services. Our team is ready to assist with your heavy equipment needs.
                            </p>
                            <div class="grid md:grid-cols-3 gap-4 text-center">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <i class="fas fa-phone text-red-600 text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-800">Call Us</p>
                                    <p class="text-sm text-gray-600">24/7 Emergency Service</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <i class="fas fa-envelope text-red-600 text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-800">Email</p>
                                    <p class="text-sm text-gray-600">Quick Response</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <i class="fas fa-clock text-red-600 text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-800">Fast Service</p>
                                    <p class="text-sm text-gray-600">Same Day Available</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-red-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Why Choose Us?</h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800">50+ Years Experience</p>
                                        <p class="text-sm text-gray-600">Trusted industry leader</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800">Fully Licensed & Insured</p>
                                        <p class="text-sm text-gray-600">Complete peace of mind</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800">Safety First</p>
                                        <p class="text-sm text-gray-600">100% safety record</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800">24/7 Availability</p>
                                        <p class="text-sm text-gray-600">Always here when you need us</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Separator Line -->
    <div class="w-full h-1 bg-white"></div>

    <!-- Mission & Vision Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Mission & Vision</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    The core values that drive our commitment to excellence in every project
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Mission -->
                <div class="bg-red-50 rounded-xl p-8 border-l-4 border-red-600">
                    <div class="flex items-center mb-6">
                        <div class="bg-red-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-bullseye text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Our Mission</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        The mission of Lion Equipment Co.is to deliver safe, efficient, andhigh-quality lifting and transport solutions.
                        Inspired by the lion as a symbol of divine strength and leadership, we are committed to
                        serving with courage, integrity, and excellence in every project we undertake
                    </p>
                    
                </div>

                <!-- Vision -->
                <div class="bg-gray-50 rounded-xl p-8 border-l-4 border-gray-600">
                    <div class="flex items-center mb-6">
                        <div class="bg-gray-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-eye text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Our Vision</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed mb-4">
                       Our vision is to deliver reliable lifting and transport solutions that contribute to infrastructure development, while cultivating
                       long-term partnerships built on integrity, operational excellence, and performance-driven service.              
                    </p>
                   
                </div>
            </div>

            <!-- Core Values -->
            <div class="mt-16 text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-8">Our Core Values</h3>
                <div class="grid md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-2">Safety First</h4>
                        <p class="text-gray-600 text-sm">Zero compromise on safety standards</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-handshake text-red-600 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-2">Integrity</h4>
                        <p class="text-gray-600 text-sm">Honest and transparent business practices</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-award text-red-600 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-2">Excellence</h4>
                        <p class="text-gray-600 text-sm">Exceptional quality in every service</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-red-600 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-2">Teamwork</h4>
                        <p class="text-gray-600 text-sm">Collaborative approach to success</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    


    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">OUR SERVICES</h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto text-justify">
                    At Lion Equipment Co., we provide specialized heavy lifting and
                    construction support services designed to meet the needs of various
                    infrastructure and industrial projects. Our core services include:
                </p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-lg max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Service 1 -->
                    <div class="flex items-start">
                        <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-crane text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Crane Rental Services</h3>
                            <p class="text-gray-600">Professional crane operations for all your lifting needs</p>
                        </div>
                    </div>

                    <!-- Service 2 -->
                    <div class="flex items-start">
                        <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-tools text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Rigging and Heavy Lifting</h3>
                            <p class="text-gray-600">Expert rigging solutions for complex lifting operations</p>
                        </div>
                    </div>

                    <!-- Service 3 -->
                    <div class="flex items-start">
                        <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-hammer text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Demolition</h3>
                            <p class="text-gray-600">Safe and controlled demolition services</p>
                        </div>
                    </div>

                    <!-- Service 4 -->
                    <div class="flex items-start">
                        <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-building text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Erection Services</h3>
                            <p class="text-gray-600">Structural erection and assembly services</p>
                        </div>
                    </div>

                    <!-- Service 5 -->
                    <div class="flex items-start">
                        <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-arrows-alt-h text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Skidding</h3>
                            <p class="text-gray-600">Heavy equipment skidding and positioning</p>
                        </div>
                    </div>

                    <!-- Service 6 -->
                    <div class="flex items-start">
                        <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-bridge text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Girder Launching</h3>
                            <p class="text-gray-600">Bridge girder launching and installation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Crane Fleet Section -->
    <section id="crane-fleet" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-gray-400 mb-4">LION EQUIPMENT COMPANY.</h2>
                <div class="flex items-center justify-center mb-6">
                    <div class="h-px bg-red-600 w-20 mr-4"></div>
                    <p class="text-xl text-gray-400 font-medium">Crane rental • Trucking • Rigging</p>
                    <div class="h-px bg-red-600 w-20 ml-4"></div>
                </div>
                <h3 class="text-4xl font-bold text-red-600 mb-4">EQUIPMENT FLEET</h3>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">State-of-the-art heavy equipment solutions for every project requirement</p>
            </div>

            <!-- Fleet Overview Cards -->
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <!-- Hydraulic Cranes -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 p-6">
                        <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-crane text-red-600 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-white text-center">HYDRAULIC CRANES</h4>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Boom Trucks</span>
                                <span class="text-red-600 font-bold">15-300 Tons</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Mobile Cranes</span>
                                <span class="text-red-600 font-bold">20-200 Tons</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Rough Terrain</span>
                                <span class="text-red-600 font-bold">30-150 Tons</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Material Handling -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 p-6">
                        <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-truck-loading text-gray-700 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-white text-center">MATERIAL HANDLING</h4>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Forklifts</span>
                                <span class="text-gray-700 font-bold">7-19 Tons</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Telehandlers</span>
                                <span class="text-gray-700 font-bold">10-25 Tons</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Skidding Systems</span>
                                <span class="text-gray-700 font-bold">Custom</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transport Fleet -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6">
                        <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-truck text-blue-600 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-white text-center">TRANSPORT FLEET</h4>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Lowbed Trailers</span>
                                <span class="text-blue-600 font-bold">Heavy Duty</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Highbed Trailers</span>
                                <span class="text-blue-600 font-bold">Oversized</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700">Articulated Trucks</span>
                                <span class="text-blue-600 font-bold">Specialized</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Capacity Overview -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 text-white">
                <div class="text-center mb-8">
                    <h4 class="text-3xl font-bold mb-2">FLEET CAPACITY</h4>
                    <p class="text-red-100">Comprehensive equipment solutions for projects of any scale</p>
                </div>
                <div class="grid md:grid-cols-4 gap-6 text-center">
                    <div class="bg-white/10 backdrop-blur rounded-xl p-6">
                        <div class="text-4xl font-bold mb-2">25+</div>
                        <p class="text-red-100">Total Units</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl p-6">
                        <div class="text-4xl font-bold mb-2">5000+</div>
                        <p class="text-red-100">Ton Capacity</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl p-6">
                        <div class="text-4xl font-bold mb-2">12</div>
                        <p class="text-red-100">Equipment Types</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl p-6">
                        <div class="text-4xl font-bold mb-2">100%</div>
                        <p class="text-red-100">Certified</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Separator Line -->
    <div class="w-full h-1 bg-white"></div>

    <!-- Past Projects Section -->
    <section id="past-projects" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Past Projects</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Showcasing our expertise in heavy lifting and construction projects across the Philippines
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Project 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48">
                        <img src="img/LF1.png" alt="LIFTING WORKS Project" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-white text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                            Completed
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Lifting Works</h3>
                        <p class="text-gray-600 mb-4">High-rise building construction with 25-ton crane operations for structural steel installation.</p>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-calendar mr-2"></i>
                                2024
                            </div>
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-weight mr-2"></i>
                                25 Tons
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48">
                        <img src="img/TFC1.png" alt="Tandem Lifting Cranes Project" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-white text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                            Completed
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Tandem Lifting Cranes</h3>
                        <p class="text-gray-600 mb-4">Bridge girder launching and installation using 50-ton mobile crane with specialized rigging.</p>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-calendar mr-2"></i>
                                2024
                            </div>
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-weight mr-2"></i>
                                50 Tons
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48">
                        <img src="img/Erection.png" alt="Erection Project" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-white text-green-600 px-3 py-1 rounded-full text-sm font-semibold">
                            Completed
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Erection</h3>
                        <p class="text-gray-600 mb-4">Heavy equipment installation and positioning using 35-ton rough terrain crane in confined spaces.</p>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-calendar mr-2"></i>
                                2023
                            </div>
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-weight mr-2"></i>
                                35 Tons
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project 4 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48">
                        <img src="img/Discharging.png" alt="Discharging from vessel to stockpile Project" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Completed
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Discharging from vessel to stockpile</h3>
                        <p class="text-gray-600 mb-4">Multi-building construction project with 20-ton crane for material handling and structural work.</p>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-calendar mr-2"></i>
                                2023
                            </div>
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-weight mr-2"></i>
                                20 Tons
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project 5 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48">
                        <img src="img/Demolition.png" alt="Demolition Project" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Completed
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Demolition</h3>
                        <p class="text-gray-600 mb-4">Large-scale warehouse construction with 40-ton crane for steel structure erection and roof installation.</p>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-calendar mr-2"></i>
                                2023
                            </div>
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-weight mr-2"></i>
                                40 Tons
                            </div>
                        </div>
                    </div>
                </div>

                </div>

            <!-- Project Statistics -->
            <div class="mt-16 grid md:grid-cols-4 gap-6 text-center">
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-3xl font-bold text-red-600 mb-2">50+</div>
                    <p class="text-gray-600">Projects Completed</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-3xl font-bold text-red-600 mb-2">100%</div>
                    <p class="text-gray-600">On-Time Delivery</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-3xl font-bold text-red-600 mb-2">0</div>
                    <p class="text-gray-600">Safety Incidents</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-3xl font-bold text-red-600 mb-2">5.0</div>
                    <p class="text-gray-600">Client Rating</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Separator Line -->
    <div class="w-full h-1 bg-white"></div>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="img/crane2.jpg" alt="Team" class="rounded-lg shadow-xl">
                </div>
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">About Lion Equipment Company</h2>
                    <p class="text-lg text-gray-600 mb-6 text-justify">
                        <strong class="text-red-600">Building Tomorrow's Infrastructure Today</strong> - Lion Equipment Co. stands at the forefront of heavy lifting and structural support services in the Philippines. Founded on April 12, 2023, we combine innovative solutions with time-tested expertise to deliver exceptional results for every project.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 text-justify">
                        Our foundation is built on decades of industry excellence, led by the vision of the founder's son from Jamilcres Inc. - a respected name with over 20 years of proven success. From our humble beginnings with a single 25-ton crane, we've evolved into a trusted partner known for unwavering commitment to <strong class="text-red-600">safety, reliability, and long-term client success</strong> across the Philippines.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex items-center">
                            <i class="fas fa-award text-red-600 text-2xl mr-4"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800">Licensed & Insured</h4>
                                <p class="text-gray-600">Fully certified operations</p>
                            </div>

                            
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt text-red-600 text-2xl mr-4"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800">Safety First</h4>
                                <p class="text-gray-600">100% safety record maintained</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-red-600 text-2xl mr-4"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800">On-Time Delivery</h4>
                                <p class="text-gray-600">Punctual project completion</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users text-red-600 text-2xl mr-4"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800">Expert Team</h4>
                                <p class="text-gray-600">Skilled certified operators</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Get In Touch</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Ready to discuss your project? Contact us for a free consultation and quote
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                    <div class="bg-white rounded-xl p-4 md:p-8 shadow-lg text-center">
                        <div class="flex justify-center items-center mb-4">
                            <i class="fas fa-phone text-red-600 text-2xl md:text-3xl mr-3"></i>
                            <h3 class="text-lg md:text-xl font-semibold text-gray-800">Phone</h3>
                        </div>
                        <p class="text-gray-600 mb-2 text-sm md:text-base">Main: 09182563327</p>
                        <p class="text-gray-600 text-sm md:text-base">Second: 09189103808</p>
                    </div>
                    
                    <div class="bg-white rounded-xl p-4 md:p-8 shadow-lg text-center">
                        <div class="flex justify-center items-center mb-4">
                            <i class="fas fa-envelope text-red-600 text-2xl md:text-3xl mr-3"></i>
                            <h3 class="text-lg md:text-xl font-semibold text-gray-800">Email</h3>
                        </div>
                        <p class="text-gray-600 text-sm md:text-base">lionequipment@gmail.com</p>
                    </div>
                    
                    <div class="bg-white rounded-xl p-4 md:p-8 shadow-lg text-center">
                        <div class="flex justify-center items-center mb-4">
                            <i class="fas fa-map-marker-alt text-red-600 text-2xl md:text-3xl mr-3"></i>
                            <h3 class="text-lg md:text-xl font-semibold text-gray-800">Location</h3>
                        </div>
                        <p class="text-gray-600 text-sm md:text-base">640 Tatalon St.</p>
                        <p class="text-gray-600 text-sm md:text-base">Brgy. Ugong Valenzuela City.</p>
                    </div>
                </div>
                
                <div class="mt-8 md:mt-12 bg-white rounded-xl p-4 md:p-8 shadow-lg">
                    <div class="text-center">
                        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">Business Hours</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 max-w-2xl mx-auto">
                            <div class="text-left">
                                <p class="text-gray-600 mb-2 text-sm md:text-base"><strong>Monday - Friday:</strong> 7:00 AM - 5:00 PM</p>
                                <p class="text-gray-600 text-sm md:text-base"><strong>Saturday:</strong> 7:00 AM - 4:00 PM</p>
                            </div>
                            <div class="text-left">
                                <p class="text-gray-600 mb-2 text-sm md:text-base"><strong>Sunday:</strong> Emergency Only</p>
                                <p class="text-gray-600 text-sm md:text-base"><strong>Emergency:</strong> 24/7 Available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 p-6 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="img/logo.jpg" alt="Lion Equipment Company" class="h-10 w-10 mr-3 rounded-full border-2 border-red-600">
                    <h2 class="text-2xl font-bold text-gray-800">Sign In</h2>
                </div>
                <button id="closeLoginModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-600 mb-6">Sign in to your Lion Equipment account</p>
                
                <!-- Login Form -->
                <form id="loginModalForm" action="login.php" method="POST" class="space-y-6">
                    <?php
                    if (isset($_SESSION['login_errors']) && !empty($_SESSION['login_errors'])) {
                        echo '<div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">';
                        echo '<div class="flex items-center mb-2">';
                        echo '<i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>';
                        echo '<span class="text-red-800 font-semibold">Login Error</span>';
                        echo '</div>';
                        echo '<ul class="text-red-700 text-sm space-y-1">';
                        foreach ($_SESSION['login_errors'] as $error) {
                            echo '<li>• ' . htmlspecialchars($error) . '</li>';
                        }
                        echo '</ul>';
                        echo '</div>';
                        unset($_SESSION['login_errors']);
                    }
                    
                    if (isset($_SESSION['login_success'])) {
                        echo '<div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">';
                        echo '<div class="flex items-center">';
                        echo '<i class="fas fa-check-circle text-green-600 mr-2"></i>';
                        echo '<span class="text-green-800">' . htmlspecialchars($_SESSION['login_success']) . '</span>';
                        echo '</div>';
                        echo '</div>';
                        unset($_SESSION['login_success']);
                    }
                    ?>
                    <!-- Email Field -->
                    <div>
                        <label for="modalEmail" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-red-600"></i>Email Address
                        </label>
                        <input 
                            type="email" 
                            id="modalEmail" 
                            name="email" 
                            required
                            value="<?php echo isset($_SESSION['login_email']) ? htmlspecialchars($_SESSION['login_email']) : ''; ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-200"
                            placeholder="admin@lionequipment.com"
                        >
                        <?php unset($_SESSION['login_email']); ?>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="modalPassword" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-red-600"></i>Password
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="modalPassword" 
                                name="password" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-200"
                                placeholder="Enter your password"
                            >
                            <button 
                                type="button" 
                                id="toggleModalPassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-red-600 transition"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="modalRemember" 
                                name="remember" 
                                class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                            >
                            <label for="modalRemember" class="ml-2 text-sm text-gray-600">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-red-600 hover:text-red-700 transition">Forgot password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-3">
                    <button class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fab fa-google text-red-500 mr-2"></i>
                        <span class="text-sm font-medium">Google</span>
                    </button>
                    <button class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fab fa-microsoft text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium">Microsoft</span>
                    </button>
                </div>

                <!-- Sign Up Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Don't have an account? 
                        <a href="#" id="openRegisterModal" class="text-red-600 hover:text-red-700 font-semibold transition">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="registerModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[80vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 p-6 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="img/logo.jpg" alt="Lion Equipment Company" class="h-10 w-10 mr-3 rounded-full border-2 border-red-600">
                    <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                </div>
                <button id="closeRegisterModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-600 mb-6">Join Lion Equipment Company</p>
                
                <!-- Registration Form -->
                <form id="registerModalForm" action="register.php" method="POST" class="space-y-6">
                    <?php
                    if (isset($_SESSION['register_errors']) && !empty($_SESSION['register_errors'])) {
                        echo '<div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">';
                        echo '<div class="flex items-center mb-2">';
                        echo '<i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>';
                        echo '<span class="text-red-800 font-semibold">Registration Error</span>';
                        echo '</div>';
                        echo '<ul class="text-red-700 text-sm space-y-1">';
                        foreach ($_SESSION['register_errors'] as $error) {
                            echo '<li>• ' . htmlspecialchars($error) . '</li>';
                        }
                        echo '</ul>';
                        echo '</div>';
                        unset($_SESSION['register_errors']);
                    }
                    
                    if (isset($_SESSION['register_success'])) {
                        echo '<div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">';
                        echo '<div class="flex items-center">';
                        echo '<i class="fas fa-check-circle text-green-600 mr-2"></i>';
                        echo '<span class="text-green-800">' . htmlspecialchars($_SESSION['register_success']) . '</span>';
                        echo '</div>';
                        echo '</div>';
                        unset($_SESSION['register_success']);
                    }
                    
                    // Get form data from session if available
                    $form_data = $_SESSION['register_form_data'] ?? [];
                    unset($_SESSION['register_form_data']);
                    ?>

                    <!-- Form Fields in Landscape Layout -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Full Name -->
                            <div>
                                <label for="regFullName" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-red-600"></i>Full Name
                                </label>
                                <input 
                                    type="text" 
                                    id="regFullName" 
                                    name="full_name" 
                                    required
                                    value="<?php echo htmlspecialchars($form_data['full_name'] ?? ''); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-200"
                                    placeholder="John Doe"
                                >
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="regEmail" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-red-600"></i>Email Address
                                </label>
                                <input 
                                    type="email" 
                                    id="regEmail" 
                                    name="email" 
                                    required
                                    value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-200"
                                    placeholder="john@example.com"
                                >
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="regPhone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2 text-red-600"></i>Phone Number
                                </label>
                                <input 
                                    type="tel" 
                                    id="regPhone" 
                                    name="phone" 
                                    required
                                    value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-200"
                                    placeholder="+63 912 345 6789"
                                >
                            </div>

                            <!-- Company (Optional) -->
                            <div>
                                <label for="regCompany" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-building mr-2 text-red-600"></i>Company (Optional)
                                </label>
                                <input 
                                    type="text" 
                                    id="regCompany" 
                                    name="company"
                                    value="<?php echo htmlspecialchars($form_data['company'] ?? ''); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-200"
                                    placeholder="Your company name"
                                >
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Password -->
                            <div>
                                <label for="regPassword" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-red-600"></i>Password
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="regPassword" 
                                        name="password" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-200"
                                        placeholder="Min. 8 characters"
                                    >
                                    <button 
                                        type="button" 
                                        id="toggleRegPassword"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-red-600 transition"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="regConfirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-red-600"></i>Confirm Password
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="regConfirmPassword" 
                                        name="confirm_password" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-200"
                                        placeholder="Confirm your password"
                                    >
                                    <button 
                                        type="button" 
                                        id="toggleRegConfirmPassword"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-red-600 transition"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    id="regTerms" 
                                    name="terms" 
                                    required
                                    class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                                >
                                <label for="regTerms" class="ml-2 text-sm text-gray-600">
                                    I agree to the <a href="#" class="text-red-600 hover:text-red-700">Terms and Conditions</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit" 
                                class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2"
                            >
                                <i class="fas fa-user-plus mr-2"></i>Create Account
                            </button>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center mt-6 pt-6 border-t border-gray-200">
                        <p class="text-gray-600">
                            Already have an account? 
                            <a href="#" id="openLoginFromRegister" class="text-red-600 hover:text-red-700 font-semibold transition">Sign In</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-gray-800 py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <img src="img/logo.jpg" alt="Lion Equipment Company" class="h-8 w-8 mr-2 rounded-full border-2 border-red-600">
                        <span class="text-xl font-bold">Lion Equipment Company</span>
                    </div>
                    <p class="text-gray-600 mb-2">Your trusted partner for professional crane and trucking services.</p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#services" class="hover:text-red-400 transition">Crane Operations</a></li>
                        <li><a href="#services" class="hover:text-red-400 transition">Heavy Transport</a></li>
                        <li><a href="#services" class="hover:text-red-400 transition">Project Logistics</a></li>
                        <li><a href="#services" class="hover:text-red-400 transition">Emergency Services</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#about" class="hover:text-red-400 transition">About Us</a></li>
                        <li><a href="#past-projects" class="hover:text-red-400 transition">Safety</a></li>
                        <li><a href="#contact" class="hover:text-red-400 transition">Careers</a></li>
                        <li><a href="#contact" class="hover:text-red-400 transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4 mb-6">
                        <a href="#" class="bg-red-600 w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-red-600 w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-red-600 w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="bg-red-600 w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    <p class="text-gray-600">
                        Subscribe to our newsletter for updates and special offers.
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-300 mt-8 pt-8 text-center text-gray-600">
                <p>&copy; 2026 Lion Equipment Company. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auto-open registration modal if there are errors or success messages
        <?php if (isset($_SESSION['register_errors']) || isset($_SESSION['register_success'])): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const registerModal = document.getElementById('registerModal');
            if (registerModal) {
                registerModal.classList.remove('hidden');
                registerModal.classList.add('flex');
            }
        });
        <?php endif; ?>

        // Login Modal functionality
        const loginModal = document.getElementById('loginModal');
        const openLoginModal = document.getElementById('openLoginModal');
        const closeLoginModal = document.getElementById('closeLoginModal');

        if (openLoginModal) {
            openLoginModal.addEventListener('click', (e) => {
                e.preventDefault();
                loginModal.classList.remove('hidden');
                loginModal.classList.add('flex');
            });
        }

        if (closeLoginModal) {
            closeLoginModal.addEventListener('click', () => {
                loginModal.classList.add('hidden');
                loginModal.classList.remove('flex');
            });
        }

        // Registration Modal functionality
        const registerModal = document.getElementById('registerModal');
        const openRegisterModal = document.getElementById('openRegisterModal');
        const closeRegisterModal = document.getElementById('closeRegisterModal');
        const openLoginFromRegister = document.getElementById('openLoginFromRegister');

        if (openRegisterModal) {
            openRegisterModal.addEventListener('click', (e) => {
                e.preventDefault();
                registerModal.classList.remove('hidden');
                registerModal.classList.add('flex');
                // Close login modal if open
                loginModal.classList.add('hidden');
                loginModal.classList.remove('flex');
            });
        }

        if (closeRegisterModal) {
            closeRegisterModal.addEventListener('click', () => {
                registerModal.classList.add('hidden');
                registerModal.classList.remove('flex');
            });
        }

        if (openLoginFromRegister) {
            openLoginFromRegister.addEventListener('click', (e) => {
                e.preventDefault();
                registerModal.classList.add('hidden');
                registerModal.classList.remove('flex');
                loginModal.classList.remove('hidden');
                loginModal.classList.add('flex');
            });
        }

        // Close modals when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                loginModal.classList.add('hidden');
                loginModal.classList.remove('flex');
            }
            if (e.target === registerModal) {
                registerModal.classList.add('hidden');
                registerModal.classList.remove('flex');
            }
        });

        // Password visibility toggle for login
        const toggleModalPassword = document.getElementById('toggleModalPassword');
        const modalPassword = document.getElementById('modalPassword');

        if (toggleModalPassword && modalPassword) {
            toggleModalPassword.addEventListener('click', () => {
                const type = modalPassword.type === 'password' ? 'text' : 'password';
                modalPassword.type = type;
                const icon = toggleModalPassword.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }

        // Password visibility toggle for registration
        const toggleRegPassword = document.getElementById('toggleRegPassword');
        const regPassword = document.getElementById('regPassword');
        const toggleRegConfirmPassword = document.getElementById('toggleRegConfirmPassword');
        const regConfirmPassword = document.getElementById('regConfirmPassword');

        if (toggleRegPassword && regPassword) {
            toggleRegPassword.addEventListener('click', () => {
                const type = regPassword.type === 'password' ? 'text' : 'password';
                regPassword.type = type;
                const icon = toggleRegPassword.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }

        if (toggleRegConfirmPassword && regConfirmPassword) {
            toggleRegConfirmPassword.addEventListener('click', () => {
                const type = regConfirmPassword.type === 'password' ? 'text' : 'password';
                regConfirmPassword.type = type;
                const icon = toggleRegConfirmPassword.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    </script>

</body>
</html>
