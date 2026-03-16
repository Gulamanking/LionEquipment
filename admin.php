<?php
session_start();

// Include database configuration
require_once 'database/config.php';

// Initialize database connection
$database = new Database();
$pdo = $database->pdo;

// Check if user is logged in and has admin role
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') {
    // If popup window, close it and redirect parent
    echo "<script>
        if (window.opener) {
            window.opener.location.href = 'index.php';
            window.close();
        } else {
            window.location.href = 'index.php';
        }
    </script>";
    exit();
}

// Get user data for display
$user_name = $_SESSION['user_name'] ?? 'Admin';
$user_email = $_SESSION['user_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - LION EQUIPMENT AND TRUCKING SERVICES</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(167, 34, 34, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200" x-data="{ sidebarOpen: false, darkMode: false }" x-init="darkMode = localStorage.getItem('darkMode') === 'true'; $watch('darkMode', value => localStorage.setItem('darkMode', value))">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 dark:border-gray-700 relative z-30 sticky top-0">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-red-600 rounded-lg flex items-center justify-center">
                            <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 0 0-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">LION EQUIPMENT AND TRUCKING SERVICES</h1>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Close Window Button (for popup) -->
                    <button onclick="if(window.opener) { window.close(); } else { window.location.href = 'index.php'; }" class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" title="Close Window">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg x-show="!darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 lg:hidden">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7-6h7m-7 6h7" />
                        </svg>
                    </button>
                    <div class="relative">
                        <button onclick="toggleUserDropdown()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <div class="h-8 w-8 bg-red-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium text-sm">A</span>
                            </div>
                            <span class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-300">Admin</span>
                            <svg class="hidden md:block h-4 w-4 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-900 dark:text-white"><?php echo htmlspecialchars($user_name); ?></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo htmlspecialchars($user_email); ?></p>
                            </div>
                            <div class="py-2">
                                <a href="#profile" onclick="showModule('profile')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                    <svg class="mr-3 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    Profile Management
                                </a>
                                <a href="#settings" onclick="showModule('settings')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                    <svg class="mr-3 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Account Settings
                                </a>
                                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 dark:hover:bg-opacity-20 flex items-center">
                                    <svg class="mr-3 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                    </svg>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-10 bg-gray-600 bg-opacity-50 lg:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-20 w-64 bg-white dark:bg-gray-800 shadow-lg transform sidebar-transition" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        <div class="h-full flex flex-col">
            <!-- Close button for mobile -->
            <div class="flex justify-between items-center p-4 lg:hidden">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Menu</h2>
                <button @click="sidebarOpen = false" class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 flex flex-col pt-2 lg:pt-20 pb-4 overflow-y-auto">
                <nav class="mt-5 px-2 space-y-1">
                    <div class="mb-4">
                        <p class="px-2 text-xs font-semibold text-red-500 uppercase tracking-wider mb-2">Dashboard</p>
                        <a href="#dashboard" class="bg-red-50 dark:bg-red-900 dark:bg-opacity-20 text-gray-700 dark:text-gray-300 group flex items-center px-2 py-2 text-sm font-medium rounded-md" onclick="showModule('dashboard')">
                            <svg class="text-gray-500 dark:text-gray-400 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            Dashboard
                        </a>
                    </div>
                    
                    <hr class="my-2 border-gray-200 dark:border-gray-700">
                    
                    <div class="mb-4">
                        <p class="px-2 text-xs font-semibold text-red-500 uppercase tracking-wider mb-2">Core Modules</p>
                        <a href="#timesheet" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md mb-2" onclick="showModule('timesheet')">
                            <svg class="text-gray-400 dark:text-gray-500 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2h6v4H7V4zm0 4h6v4H7v-4z" clip-rule="evenodd" />
                            </svg>
                            Timesheet Record
                        </a>
                        <div class="relative mb-2" onmouseenter="showQuotationDropdown()" onmouseleave="hideQuotationDropdown()">
                            <button onclick="toggleQuotationDropdown()" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full justify-between">
                                <div class="flex items-center">
                                    <svg class="text-gray-400 dark:text-gray-500 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                    Quotation for Crane Rental
                                </div>
                                <svg class="text-gray-400 dark:text-gray-500 h-4 w-4 transition-transform duration-200" id="dropdownArrow" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown List (Non-floating) -->
                            <div id="quotationDropdown" class="hidden overflow-hidden transition-all duration-300 ease-in-out">
                                <div class="ml-4 border-l-2 border-gray-200 dark:border-gray-700 pl-2 py-1">
                                    <a href="javascript:void(0)" onclick="openQuotationModal()" class="block px-3 py-2 text-sm text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition-colors duration-150 mb-1">
                                        <div class="flex items-center">
                                            <svg class="text-gray-400 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2a1 1 0 100-2h2a4 4 0 014 4v6a4 4 0 01-4 4H6a4 4 0 01-4-4V7a4 4 0 014-4z" clip-rule="evenodd" />
                                            </svg>
                                            Create Quotation
                                        </div>
                                    </a>
                                    
                                     <a href="#cranes" onclick="showModule('cranes')" class="block px-3 py-2 text-sm text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition-colors duration-150">
                                         <div class="flex items-center">
                                             <svg class="text-gray-400 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                            </svg>
                                            Crane Inventory
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="#employee" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md mb-2" onclick="showModule('employee')">
                            <svg class="text-gray-400 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            Employee Self Service
                        </a>
                    </div>
                    
                    <hr class="my-2 border-gray-200 dark:border-gray-700">
                    
                    <div class="mb-4">
                        <p class="px-2 text-xs font-semibold text-red-500 uppercase tracking-wider mb-2">Reports</p>
                        <a href="#reports" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md mb-2" onclick="showModule('reports')">
                            <svg class="text-gray-400 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                            </svg>
                            Reports
                        </a>
                    </div>
                    
                    <hr class="my-2 border-gray-200 dark:border-gray-700">
                    
                    <div class="mb-4">
                        <p class="px-2 text-xs font-semibold text-red-500 uppercase tracking-wider mb-2">Settings</p>
                        <a href="#settings" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" onclick="showModule('settings')">
                            <svg class="text-gray-400 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            Settings
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:pl-64 pt-20">
        <div class="p-4 sm:p-6 lg:p-8">
            <!-- Dashboard Module -->
            <div id="dashboard-module" class="module-content">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Data Analytics</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Comprehensive analytics and insights for your business.</p>
                </div>
                
                <!-- Key Metrics Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Revenue Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662V1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Revenue</h3>
                        </div>
                        <p class="text-3xl font-bold text-blue-600">₱245,678</p>
                        <p class="text-sm text-green-600">+12.5% from last month</p>
                        <div class="mt-4">
                            <button class="text-blue-600 hover:text-blue-700 font-medium text-sm">View Details →</button>
                        </div>
                    </div>
                    
                    <!-- Active Projects Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Active Projects</h3>
                        </div>
                        <p class="text-3xl font-bold text-orange-600">23</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">5 this month</p>
                        <div class="mt-4">
                            <button class="text-orange-600 hover:text-orange-700 font-medium text-sm">View All →</button>
                        </div>
                    </div>
                    
                    <!-- Equipment Status Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Equipment Status</h3>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mt-2">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-green-600">18</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Available</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600">4</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Rented</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-yellow-600">2</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Maintenance</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="text-green-600 hover:text-green-700 font-medium text-sm">Manage Equipment →</button>
                        </div>
                    </div>
                    
                    <!-- Recent Activity Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M12 4.354a1 1 0 00-1.414 0l-4 4a1 1 0 011.414 1.414l4 4a1 1 0 001.414 0l-4-4a1 1 0 010-1.414zM12 4a1 1 0 100 2h2a1 1 0 100-2h-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">New Quotation</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">QTN-2024-015</p>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">2 hours ago</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Equipment Rental</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">CRN-003</p>
                                </div>
                                <span class="text-sm text-gray-500">5 hours ago</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Project Complete</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Warehouse Project</p>
                                </div>
                                <span class="text-sm text-gray-500">1 day ago</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Maintenance Alert</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">CRN-007</p>
                                </div>
                                <span class="text-sm text-red-600">2 days ago</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="text-purple-600 hover:text-purple-700 font-medium text-sm">View All Activity →</button>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <button class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors">
                        Create New Quotation
                    </button>
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        View All Projects
                    </button>
                    <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                        Equipment Management
                    </button>
                    <button class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                        Generate Report
                    </button>
                </div>
                
                <!-- User Management Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Management</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-red-600">JD</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">John Doe</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">john@example.com</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-red-600 hover:text-red-900 mr-3">Edit</button>
                                        <button class="text-gray-600 hover:text-gray-900">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-red-600">JS</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Jane Smith</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">jane@example.com</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">User</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-red-600 hover:text-red-900 mr-3">Edit</button>
                                        <button class="text-gray-600 hover:text-gray-900">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Other modules (Timesheet, Quotation, etc.) would go here with similar structure -->
            <!-- For now, keeping only Dashboard module visible -->

            <!-- Timesheet Record Module -->
            <div id="timesheet-module" class="module-content hidden">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Timesheet Record</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Manage employee timesheets and work hours.</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="mb-6 flex justify-between items-center">
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            + Add Timesheet Entry
                        </button>
                        <div class="flex space-x-2">
                            <input type="file" id="timesheetFile" accept=".xlsx,.xls,.csv" class="hidden" onchange="handleTimesheetFile(event)">
                            <button onclick="document.getElementById('timesheetFile').click()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                📁 Import Timesheet
                            </button>
                            <button onclick="generateTimesheetReport()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                📄 Generate Report
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Employee</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hours</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Project</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">John Doe</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">2024-01-15</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">8</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Crane Operation</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Jane Smith</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">2024-01-15</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">7.5</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Maintenance</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quotation for Crane Rental Module -->
            <div id="quotation-module" class="module-content hidden">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Quotation for Crane Rental</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Create and manage crane rental quotations.</p>
                </div>
                
                <!-- Search and Filter Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Customer</label>
                            <input type="text" id="customerSearch" placeholder="Enter customer name..." 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Status</label>
                            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                <option value="">All Status</option>
                                <option value="draft">Draft</option>
                                <option value="sent">Sent</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Date</label>
                            <input type="date" id="dateFilter" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button onclick="filterQuotations()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Apply Filters
                        </button>
                        <button onclick="clearFilters()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                            Clear
                        </button>
                    </div>
                </div>
                
                <!-- Quotations Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Customer Quotations</h3>
                        <button onclick="openQuotationModal()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            + Create New Quotation
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quotation ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Project</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Crane Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="quotationsTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Q-2024-001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">ABC Construction</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Construction Site A</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">20 Ton Mobile</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">3 days</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">₱4,500</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Draft</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="viewQuotation('Q-2024-001')" class="text-red-600 hover:text-red-900 mr-3">View</button>
                                        <button onclick="editQuotation('Q-2024-001')" class="text-gray-600 hover:text-gray-900">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Q-2024-002</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">XYZ Logistics</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Warehouse Project</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">50 Ton Tower</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">1 week</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">₱12,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sent</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="viewQuotation('Q-2024-002')" class="text-red-600 hover:text-red-900 mr-3">View</button>
                                        <button onclick="editQuotation('Q-2024-002')" class="text-gray-600 hover:text-gray-900">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Q-2024-003</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Delta Builders</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">High Rise Building</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">35 Ton Crawler</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">2 weeks</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">₱18,500</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="viewQuotation('Q-2024-003')" class="text-red-600 hover:text-red-900 mr-3">View</button>
                                        <button onclick="editQuotation('Q-2024-003')" class="text-gray-600 hover:text-gray-900">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Quotation Details Modal (moved outside modules) -->
                <div id="quotationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quotation Details</h3>
                            <button onclick="closeQuotationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <form id="quotationForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quotation ID</label>
                                    <input type="text" id="quotationId" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer Name</label>
                                    <input type="text" id="customerName" placeholder="Enter customer name" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project Details</label>
                                    <input type="text" id="projectDetails" placeholder="Enter project details" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                    <select id="quotationStatus" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                        <option value="draft">Draft</option>
                                        <option value="sent">Sent</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Quotation Items Table -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-white">Quotation Items</h4>
                                    <button type="button" onclick="addQuotationItem()" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                                        + Add Item
                                    </button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Crane Type</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Duration</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Rate/Day</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="quotationItems" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            <tr>
                                                <td class="px-4 py-2">
                                                    <select class="w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white">
                                                        <option>20 Ton Mobile</option>
                                                        <option>35 Ton Crawler</option>
                                                        <option>50 Ton Tower</option>
                                                        <option>80 Ton All Terrain</option>
                                                    </select>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" placeholder="Days" class="w-20 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white" onchange="calculateItemTotal(this)">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" placeholder="Rate" class="w-24 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white" onchange="calculateItemTotal(this)">
                                                </td>
                                                <td class="px-4 py-2 font-semibold text-gray-900 dark:text-white">₱0</td>
                                                <td class="px-4 py-2">
                                                    <button type="button" onclick="removeQuotationItem(this)" class="text-red-600 hover:text-red-900 text-sm">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gray-50 dark:bg-gray-700">
                                                <td colspan="3" class="px-4 py-2 text-right font-semibold text-gray-900 dark:text-white">Total Amount:</td>
                                                <td id="totalAmount" class="px-4 py-2 font-bold text-lg text-gray-900 dark:text-white">₱0</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-2">
                                <button type="button" onclick="saveQuotation()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                    Save Quotation
                                </button>
                                <button type="button" onclick="closeQuotationModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Employee Self Service Module -->
            <div id="employee-module" class="module-content hidden">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Employee Self Service</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Manage employee information and self-service options.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900 dark:text-white">Leave Requests</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Submit and track leave requests.</p>
                        <div class="space-y-2">
                            <input type="file" id="leaveDocument" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="hidden" onchange="handleLeaveDocument(event)">
                            <button onclick="document.getElementById('leaveDocument').click()" class="w-full bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition-colors">
                                📁 Upload Document
                            </button>
                            <button class="w-full bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700 transition-colors">
                                Manage →
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h4v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900 dark:text-white">Timesheet</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">View and submit work hours.</p>
                        <div class="space-y-2">
                            <input type="file" id="timesheetDoc" accept=".xlsx,.xls,.csv" class="hidden" onchange="handleTimesheetDoc(event)">
                            <button onclick="document.getElementById('timesheetDoc').click()" class="w-full bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition-colors">
                                📁 Upload Timesheet
                            </button>
                            <button class="w-full bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                                View →
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900 dark:text-white">Documents</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Access company documents.</p>
                        <div class="space-y-2">
                            <input type="file" id="employeeDoc" accept=".pdf,.doc,.docx" multiple class="hidden" onchange="handleEmployeeDoc(event)">
                            <button onclick="document.getElementById('employeeDoc').click()" class="w-full bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition-colors">
                                📁 Upload Files
                            </button>
                            <button onclick="generateEmployeeReport()" class="w-full bg-purple-600 text-white px-3 py-2 rounded text-sm hover:bg-purple-700 transition-colors">
                                📄 Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crane Inventory Module -->
            <div id="cranes-module" class="module-content hidden">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Crane Inventory</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Manage and view all crane equipment in the fleet.</p>
                </div>
                
                <!-- Search and Filter -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Crane</label>
                            <input type="text" placeholder="Enter crane name or ID..." 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Type</label>
                            <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                <option value="">All Types</option>
                                <option value="mobile">Mobile Crane</option>
                                <option value="tower">Tower Crane</option>
                                <option value="crawler">Crawler Crane</option>
                                <option value="all-terrain">All Terrain</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Status</label>
                            <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                <option value="">All Status</option>
                                <option value="available">Available</option>
                                <option value="rented">Rented</option>
                                <option value="maintenance">Under Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Apply Filters
                        </button>
                        <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors ml-2">
                            Clear
                        </button>
                    </div>
                </div>
                
                <!-- Crane Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <!-- Crane 1 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 bg-gray-200 relative">
                            <img src="https://images.unsplash.com/photo-1586953208448-b95a79798f07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="20 Ton Mobile Crane" class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">CRN-001</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">20 Ton Mobile Crane</p>
                            <div class="space-y-1 text-sm text-gray-500 dark:text-gray-400">
                                <p><strong>Capacity:</strong> 20 Tons</p>
                                <p><strong>Year:</strong> 2020</p>
                                <p><strong>Rate:</strong> ₱1,500/day</p>
                                <p><strong>Location:</strong> Main Yard</p>
                            </div>
                            <div class="mt-3 flex space-x-2">
                                <button class="flex-1 bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                                    View Details
                                </button>
                                <button class="flex-1 bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300 transition-colors">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Crane 2 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 bg-gray-200 relative">
                            <img src="https://images.unsplash.com/photo-1577412647305-991150c7d163?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="35 Ton Crawler Crane" class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Rented</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">CRN-002</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">35 Ton Crawler Crane</p>
                            <div class="space-y-1 text-sm text-gray-500 dark:text-gray-400">
                                <p><strong>Capacity:</strong> 35 Tons</p>
                                <p><strong>Year:</strong> 2019</p>
                                <p><strong>Rate:</strong> ₱2,200/day</p>
                                <p><strong>Location:</strong> Construction Site A</p>
                            </div>
                            <div class="mt-3 flex space-x-2">
                                <button class="flex-1 bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                                    View Details
                                </button>
                                <button class="flex-1 bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300 transition-colors">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Crane 3 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 bg-gray-200 relative">
                            <img src="https://images.unsplash.com/photo-1541888933-9e9c4c5e6601?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="50 Ton Tower Crane" class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">CRN-003</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">50 Ton Tower Crane</p>
                            <div class="space-y-1 text-sm text-gray-500 dark:text-gray-400">
                                <p><strong>Capacity:</strong> 50 Tons</p>
                                <p><strong>Year:</strong> 2021</p>
                                <p><strong>Rate:</strong> ₱3,000/day</p>
                                <p><strong>Location:</strong> Main Yard</p>
                            </div>
                            <div class="mt-3 flex space-x-2">
                                <button class="flex-1 bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                                    View Details
                                </button>
                                <button class="flex-1 bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300 transition-colors">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Add New Crane Button -->
                <div class="mt-8 text-center">
                    <button class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors">
                        + Add New Crane
                    </button>
                </div>
            </div>

            <!-- Reports Module -->
            <div id="reports-module" class="module-content hidden">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Reports</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Generate and view various business reports.</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2a1 1 0 100-2h2a4 4 0 014 4v6a4 4 0 01-4 4H6a4 4 0 01-4-4V7a4 4 0 014-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Financial Reports</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Revenue, expenses, and profit analysis</p>
                            <button class="text-blue-600 hover:text-blue-700 font-medium text-sm">Generate →</button>
                        </div>
                        
                        <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Equipment Reports</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Crane utilization and maintenance</p>
                            <button class="text-green-600 hover:text-green-700 font-medium text-sm">Generate →</button>
                        </div>
                        
                        <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-6 w-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Employee Reports</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Timesheet and performance metrics</p>
                            <button class="text-purple-600 hover:text-purple-700 font-medium text-sm">Generate →</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Module -->
            <div id="profile-module" class="module-content hidden">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Management</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Manage your personal information, documents, and account settings.</p>
                </div>
                
                <form id="profileForm" onsubmit="validateAndSaveProfile(event)">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" id="fullName" name="fullName" value="Admin User" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                        <span class="text-red-500 text-xs hidden" id="fullNameError">Full name is required</span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email <span class="text-red-500">*</span></label>
                                        <input type="email" id="email" name="email" value="admin@lionequipment.com" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                        <span class="text-red-500 text-xs hidden" id="emailError">Valid email is required</span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone <span class="text-red-500">*</span></label>
                                        <input type="tel" id="phone" name="phone" value="+1 234 567 8900" required pattern="[+]?[0-9\s\-\(\)]+" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                        <span class="text-red-500 text-xs hidden" id="phoneError">Valid phone number is required</span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                                        <select id="department" name="department" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                            <option value="">Select Department</option>
                                            <option value="management">Management</option>
                                            <option value="operations">Operations</option>
                                            <option value="finance">Finance</option>
                                            <option value="hr">Human Resources</option>
                                            <option value="maintenance">Maintenance</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Security Settings -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Security Settings</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password</label>
                                        <input type="password" id="currentPassword" name="currentPassword" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                        <span class="text-red-500 text-xs hidden" id="currentPasswordError">Current password is required for password change</span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                                        <input type="password" id="newPassword" name="newPassword" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&]).{8,}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                        <span class="text-gray-500 text-xs">Min 8 chars: uppercase, lowercase, number, special char</span>
                                        <span class="text-red-500 text-xs hidden" id="newPasswordError">Password does not meet requirements</span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                                        <input type="password" id="confirmPassword" name="confirmPassword" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                                        <span class="text-red-500 text-xs hidden" id="confirmPasswordError">Passwords do not match</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Supporting Documents -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Supporting Documents</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Picture</label>
                                        <div class="flex items-center space-x-4">
                                            <div class="h-16 w-16 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <input type="file" id="profilePicture" name="profilePicture" accept="image/*" class="hidden" onchange="handleFileSelect(event, 'profilePicture')">
                                                <button type="button" onclick="document.getElementById('profilePicture').click()" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm hover:bg-gray-300 dark:hover:bg-gray-600">
                                                    Choose File
                                                </button>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1" id="profilePictureName">No file chosen</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ID Document</label>
                                        <input type="file" id="idDocument" name="idDocument" accept=".pdf,.jpg,.jpeg,.png" class="hidden" onchange="handleFileSelect(event, 'idDocument')">
                                        <button type="button" onclick="document.getElementById('idDocument').click()" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm hover:bg-gray-300 dark:hover:bg-gray-600">
                                            Choose File
                                        </button>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1" id="idDocumentName">No file chosen</span>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contract Document</label>
                                        <input type="file" id="contractDocument" name="contractDocument" accept=".pdf,.doc,.docx" class="hidden" onchange="handleFileSelect(event, 'contractDocument')">
                                        <button type="button" onclick="document.getElementById('contractDocument').click()" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm hover:bg-gray-300 dark:hover:bg-gray-600">
                                            Choose File
                                        </button>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1" id="contractDocumentName">No file chosen</span>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Documents</label>
                                        <input type="file" id="additionalDocuments" name="additionalDocuments" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple class="hidden" onchange="handleFileSelect(event, 'additionalDocuments')">
                                        <button type="button" onclick="document.getElementById('additionalDocuments').click()" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm hover:bg-gray-300 dark:hover:bg-gray-600">
                                            Choose Files
                                        </button>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1" id="additionalDocumentsName">No files chosen</span>
                                    </div>
                                </div>
                                
                                <!-- Current Documents List -->
                                <div id="currentDocuments" class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Documents</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">Employee_Contract_2024.pdf</span>
                                            <div class="space-x-2">
                                                <button type="button" class="text-blue-600 hover:text-blue-700 text-xs">View</button>
                                                <button type="button" class="text-red-600 hover:text-red-700 text-xs">Delete</button>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">ID_Document_Scan.jpg</span>
                                            <div class="space-x-2">
                                                <button type="button" class="text-blue-600 hover:text-blue-700 text-xs">View</button>
                                                <button type="button" class="text-red-600 hover:text-red-700 text-xs">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="text-red-500">*</span> Required fields
                            </div>
                            <div class="space-x-3">
                                <button type="button" onclick="resetProfileForm()" class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Settings Module -->
            <div id="settings-module" class="module-content hidden">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Settings</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Configure system settings and preferences.</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Company Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company Name</label>
                                    <input type="text" value="LION EQUIPMENT AND TRUCKING SERVICES" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Email</label>
                                    <input type="email" value="info@lionequipment.com" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">System Preferences</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input type="checkbox" id="notifications" class="h-4 w-4 text-red-600 border-gray-300 dark:border-gray-600 rounded">
                                    <label for="notifications" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enable email notifications</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="backup" class="h-4 w-4 text-red-600 border-gray-300 dark:border-gray-600 rounded">
                                    <label for="backup" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Automatic data backup</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                Save Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Module switching functionality
        function showModule(moduleId) {
            // Hide all modules
            const modules = document.querySelectorAll('.module-content');
            modules.forEach(module => module.classList.add('hidden'));
            
            // Show selected module
            const selectedModule = document.getElementById(moduleId + '-module');
            if (selectedModule) {
                selectedModule.classList.remove('hidden');
            }
            
            // Update sidebar active state
            const sidebarLinks = document.querySelectorAll('nav a');
            sidebarLinks.forEach(link => link.classList.remove('bg-red-50', 'text-gray-700'));
            sidebarLinks.forEach(link => link.classList.add('text-gray-600'));
            
            const activeLink = document.querySelector(`a[href="#${moduleId}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-gray-600');
                activeLink.classList.add('bg-red-50', 'text-gray-700');
            }
        }

        // User dropdown toggle
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        // Profile form validation and save
        function validateAndSaveProfile(event) {
            event.preventDefault();
            
            let isValid = true;
            
            // Reset error messages
            document.querySelectorAll('.text-red-500.text-xs').forEach(el => el.classList.add('hidden'));
            
            // Validate full name
            const fullName = document.getElementById('fullName').value.trim();
            if (!fullName) {
                document.getElementById('fullNameError').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate email
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || !emailRegex.test(email)) {
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate phone
            const phone = document.getElementById('phone').value.trim();
            const phoneRegex = /^[+]?[\d\s\-\(\)]+$/;
            if (!phone || !phoneRegex.test(phone)) {
                document.getElementById('phoneError').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate password if trying to change
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const currentPassword = document.getElementById('currentPassword').value;
            
            if (newPassword || confirmPassword || currentPassword) {
                if (!currentPassword) {
                    document.getElementById('currentPasswordError').classList.remove('hidden');
                    isValid = false;
                }
                
                const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&]).{8,}$/;
                if (!newPassword || !passwordRegex.test(newPassword)) {
                    document.getElementById('newPasswordError').classList.remove('hidden');
                    isValid = false;
                }
                
                if (newPassword !== confirmPassword) {
                    document.getElementById('confirmPasswordError').classList.remove('hidden');
                    isValid = false;
                }
            }
            
            if (isValid) {
                // Show success message
                showNotification('Profile updated successfully!', 'success');
                
                // Here you would normally submit the form to the server
                // For demo purposes, we'll just show the success message
                console.log('Form is valid, submitting...');
            }
        }
        
        // Handle file selection
        function handleFileSelect(event, fieldName) {
            const files = event.target.files;
            const nameElement = document.getElementById(fieldName + 'Name');
            
            if (files.length > 0) {
                if (files.length === 1) {
                    nameElement.textContent = files[0].name;
                } else {
                    nameElement.textContent = `${files.length} files selected`;
                }
            } else {
                nameElement.textContent = 'No file chosen';
            }
        }
        
        // Reset profile form
        function resetProfileForm() {
            document.getElementById('profileForm').reset();
            
            // Reset file name displays
            document.getElementById('profilePictureName').textContent = 'No file chosen';
            document.getElementById('idDocumentName').textContent = 'No file chosen';
            document.getElementById('contractDocumentName').textContent = 'No file chosen';
            document.getElementById('additionalDocumentsName').textContent = 'No files chosen';
            
            // Hide error messages
            document.querySelectorAll('.text-red-500.text-xs').forEach(el => el.classList.add('hidden'));
        }
        
        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Handle timesheet file upload
        function handleTimesheetFile(event) {
            const file = event.target.files[0];
            if (file) {
                showNotification(`Timesheet file "${file.name}" uploaded successfully!`, 'success');
                // Here you would normally process the file
                console.log('Processing timesheet file:', file.name);
            }
        }

        // Generate timesheet report
        function generateTimesheetReport() {
            showNotification('Generating timesheet report...', 'success');
            // Simulate report generation
            setTimeout(() => {
                // Create a sample CSV content
                const csvContent = "Employee,Date,Hours,Project,Status\nJohn Doe,2024-01-15,8,Construction Site A,Approved\nJane Smith,2024-01-15,7,Warehouse Project,Approved";
                
                // Create download link
                const blob = new Blob([csvContent], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `timesheet_report_${new Date().toISOString().split('T')[0]}.csv`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
                
                showNotification('Timesheet report downloaded successfully!', 'success');
            }, 1000);
        }

        // Generate quotation PDF
        function generateQuotationPDF() {
            const customerName = document.getElementById('customerName').value || 'Customer';
            const projectDetails = document.getElementById('projectDetails').value || 'Project Details';
            const totalAmount = document.getElementById('totalAmount').textContent;
            
            showNotification('Generating quotation PDF...', 'success');
            
            // Create a simple HTML content for the PDF
            const pdfContent = `
                <html>
                <head>
                    <title>Quotation - ${customerName}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; }
                        .customer-info { margin: 20px 0; }
                        .items-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                        .items-table th, .items-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        .items-table th { background-color: #f2f2f2; }
                        .total { text-align: right; font-weight: bold; font-size: 18px; }
                        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #666; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>LION EQUIPMENT RENTAL</h1>
                        <h2>Quotation</h2>
                        <p>Date: ${new Date().toLocaleDateString()}</p>
                    </div>
                    
                    <div class="customer-info">
                        <h3>Customer: ${customerName}</h3>
                        <p>Project: ${projectDetails}</p>
                    </div>
                    
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Equipment</th>
                                <th>Days</th>
                                <th>Rate</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="pdfItemsBody">
                            <!-- Items will be populated here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="total">Total Amount:</td>
                                <td class="total">${totalAmount}</td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <div class="footer">
                        <p>This quotation is valid for 30 days.</p>
                        <p>Thank you for your business!</p>
                    </div>
                </body>
                </html>
            `;
            
            // Populate items from the quotation table
            const items = [];
            const rows = document.querySelectorAll('#quotationItems tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 4) {
                    const equipment = cells[0].querySelector('select')?.value || 'Equipment';
                    const days = cells[1].querySelector('input')?.value || '0';
                    const rate = cells[2].querySelector('input')?.value || '0';
                    const total = cells[3].textContent;
                    items.push(`<tr><td>${equipment}</td><td>${days}</td><td>₱${rate}</td><td>₱${total}</td></tr>`);
                }
            });
            
            // Replace the placeholder with actual items
            const finalContent = pdfContent.replace('<!-- Items will be populated here -->', items.join(''));
            
            // Create and download the PDF (using a simple approach)
            const blob = new Blob([finalContent], { type: 'text/html' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `quotation_${customerName.replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            showNotification('Quotation document generated successfully!', 'success');
        }

        // Save quotation function
        function saveQuotation() {
            // Clear previous error messages
            clearValidationErrors();
            
            const customerName = document.getElementById('customerName').value.trim();
            const projectDetails = document.getElementById('projectDetails').value.trim();
            const totalAmount = document.getElementById('totalAmount').textContent;
            
            let hasErrors = false;
            
            // Validate customer name
            if (!customerName) {
                showFieldError('customerName', 'Customer name is required');
                hasErrors = true;
            } else if (customerName.length < 2) {
                showFieldError('customerName', 'Customer name must be at least 2 characters');
                hasErrors = true;
            }
            
            // Validate project details
            if (!projectDetails) {
                showFieldError('projectDetails', 'Project details are required');
                hasErrors = true;
            } else if (projectDetails.length < 5) {
                showFieldError('projectDetails', 'Project details must be at least 5 characters');
                hasErrors = true;
            }
            
            // Get and validate quotation items
            const items = [];
            const rows = document.querySelectorAll('#quotationItems tr');
            let hasValidItems = false;
            
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 4) {
                    const equipment = cells[0].querySelector('select')?.value;
                    const days = cells[1].querySelector('input')?.value;
                    const rate = cells[2].querySelector('input')?.value;
                    
                    if (!equipment) {
                        showFieldError(`equipment_${index}`, 'Please select equipment');
                        hasErrors = true;
                    }
                    
                    if (!days || days <= 0) {
                        showFieldError(`days_${index}`, 'Please enter valid days');
                        hasErrors = true;
                    }
                    
                    if (!rate || rate <= 0) {
                        showFieldError(`rate_${index}`, 'Please enter valid rate');
                        hasErrors = true;
                    }
                    
                    if (equipment && days && rate) {
                        items.push({
                            equipment: equipment,
                            days: days,
                            rate: rate,
                            total: cells[3].textContent
                        });
                        hasValidItems = true;
                    }
                }
            });
            
            if (!hasValidItems) {
                showNotification('Please add at least one valid item to the quotation', 'error');
                hasErrors = true;
            }
            
            if (hasErrors) {
                showNotification('Please correct the errors below', 'error');
                return;
            }
            
            // Create quotation object
            const quotation = {
                id: 'Q-' + Date.now(),
                customerName: customerName,
                projectDetails: projectDetails,
                items: items,
                totalAmount: totalAmount,
                date: new Date().toLocaleDateString(),
                status: 'Draft'
            };
            
            // Show loading state
            const saveButton = document.querySelector('button[onclick="saveQuotation()"]');
            const originalText = saveButton.textContent;
            saveButton.textContent = 'Saving...';
            saveButton.disabled = true;
            
            // Save to database via AJAX
            const formData = new FormData();
            formData.append('action', 'save_quotation');
            formData.append('quotation_id', quotation.id);
            formData.append('customer_name', quotation.customerName);
            formData.append('project_details', quotation.projectDetails);
            formData.append('items', JSON.stringify(quotation.items));
            formData.append('total_amount', quotation.totalAmount);
            
            fetch('save_quotation.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Quotation ${quotation.id} saved successfully!`, 'success');
                    
                    // Add to the quotations table
                    addQuotationToTable(quotation);
                    
                    // Close modal and reset form
                    closeQuotationModal();
                } else {
                    showNotification(data.message || 'Error saving quotation', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error saving quotation. Please try again.', 'error');
            })
            .finally(() => {
                // Restore button state
                saveButton.textContent = originalText;
                saveButton.disabled = false;
            });
        }

        // Show field error
        function showFieldError(fieldId, message) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.add('border-red-500');
                
                // Create or update error message
                let errorElement = document.getElementById(fieldId + '_error');
                if (!errorElement) {
                    errorElement = document.createElement('span');
                    errorElement.id = fieldId + '_error';
                    errorElement.className = 'text-red-500 text-xs mt-1 block';
                    field.parentNode.appendChild(errorElement);
                }
                errorElement.textContent = message;
            }
        }

        // Clear validation errors
        function clearValidationErrors() {
            // Remove error classes
            document.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
            
            // Remove error messages
            document.querySelectorAll('[id$="_error"]').forEach(el => {
                el.remove();
            });
        }

        // Add quotation item
        function addQuotationItem() {
            const itemsBody = document.getElementById('quotationItems');
            const itemCount = itemsBody.querySelectorAll('tr').length;
            
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="px-4 py-2">
                    <select id="equipment_${itemCount}" class="w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Select Equipment</option>
                        <option>20 Ton Mobile</option>
                        <option>35 Ton Crawler</option>
                        <option>50 Ton Tower</option>
                        <option>80 Ton All Terrain</option>
                    </select>
                </td>
                <td class="px-4 py-2">
                    <input type="number" id="days_${itemCount}" placeholder="Days" min="1" class="w-20 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white" onchange="calculateItemTotal(this)">
                </td>
                <td class="px-4 py-2">
                    <input type="number" id="rate_${itemCount}" placeholder="Rate" min="1" step="100" class="w-24 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white" onchange="calculateItemTotal(this)">
                </td>
                <td class="px-4 py-2 font-semibold text-gray-900 dark:text-white">₱0</td>
                <td class="px-4 py-2">
                    <button type="button" onclick="removeQuotationItem(this)" class="text-red-600 hover:text-red-900 text-sm">Remove</button>
                </td>
            `;
            
            itemsBody.appendChild(newRow);
        }

        // Remove quotation item
        function removeQuotationItem(button) {
            const row = button.closest('tr');
            row.remove();
            updateGrandTotal();
        }

        // Open quotation modal
        function openQuotationModal() {
            const modal = document.getElementById('quotationModal');
            if (modal) {
                modal.classList.remove('hidden');
                // Generate new quotation ID
                document.getElementById('quotationId').value = 'Q-' + Date.now();
                // Add one initial item
                const itemsBody = document.getElementById('quotationItems');
                itemsBody.innerHTML = '';
                addQuotationItem();
            }
        }

        // View quotation
        function viewQuotation(id) {
            showNotification(`Viewing quotation ${id}`, 'success');
            // Here you would load and display the quotation details
        }

        // Edit quotation
        function editQuotation(id) {
            showNotification(`Editing quotation ${id}`, 'success');
            // Here you would load the quotation for editing
        }

        // Enhanced calculate item total with validation
        function calculateItemTotal(input) {
            const row = input.closest('tr');
            const inputs = row.querySelectorAll('input[type="number"]');
            const daysInput = inputs[0]; // First number input (days)
            const rateInput = inputs[1]; // Second number input (rate)
            const totalCell = row.querySelector('td:nth-child(4)');
            
            const days = parseFloat(daysInput.value) || 0;
            const rate = parseFloat(rateInput.value) || 0;
            const total = days * rate;
            
            totalCell.textContent = '₱' + total.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            
            // Update grand total
            updateGrandTotal();
        }

        // Update grand total
        function updateGrandTotal() {
            const totalCells = document.querySelectorAll('#quotationItems td:nth-child(4)');
            let grandTotal = 0;
            
            totalCells.forEach(cell => {
                const value = cell.textContent.replace('₱', '').replace(',', '');
                grandTotal += parseFloat(value) || 0;
            });
            
            document.getElementById('totalAmount').textContent = '₱' + grandTotal.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Add quotation to table
        function addQuotationToTable(quotation) {
            const tableBody = document.getElementById('quotationsTableBody');
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">${quotation.id}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${quotation.customerName}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${quotation.projectDetails}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${quotation.items[0]?.equipment || 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${quotation.items[0]?.days || '0'} days</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">${quotation.totalAmount}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Draft</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="viewQuotation('${quotation.id}')" class="text-red-600 hover:text-red-900 mr-3">View</button>
                    <button onclick="editQuotation('${quotation.id}')" class="text-gray-600 hover:text-gray-900">Edit</button>
                </td>
            `;
            
            tableBody.appendChild(row);
        }

        // Load quotations from database
        function loadQuotations() {
            fetch('save_quotation.php?action=get_quotations')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const tableBody = document.getElementById('quotationsTableBody');
                        // Clear existing rows except the sample ones
                        const existingRows = tableBody.querySelectorAll('tr');
                        existingRows.forEach(row => row.remove());
                        
                        // Add quotations from database
                        data.quotations.forEach(quotation => {
                            const items = JSON.parse(quotation.items);
                            const row = document.createElement('tr');
                            
                            row.innerHTML = `
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">${quotation.quotation_id}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${quotation.customer_name}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${quotation.project_details}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${items[0]?.equipment || 'N/A'}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${items[0]?.days || '0'} days</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">${quotation.total_amount}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-${quotation.status === 'Draft' ? 'blue' : 'green'}-100 text-${quotation.status === 'Draft' ? 'blue' : 'green'}-800">${quotation.status}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="viewQuotation('${quotation.quotation_id}')" class="text-red-600 hover:text-red-900 mr-3">View</button>
                                    <button onclick="editQuotation('${quotation.quotation_id}')" class="text-gray-600 hover:text-gray-900">Edit</button>
                                </td>
                            `;
                            
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading quotations:', error);
                });
        }

        // Load quotations when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadQuotations();
        });

        // Close quotation modal
        function closeQuotationModal() {
            const modal = document.getElementById('quotationModal');
            if (modal) {
                modal.classList.add('hidden');
            }
            // Reset form
            document.getElementById('customerName').value = '';
            document.getElementById('projectDetails').value = '';
            
            // Clear items
            const itemsBody = document.getElementById('quotationItems');
            if (itemsBody) {
                itemsBody.innerHTML = '';
            }
            
            // Reset total
            document.getElementById('totalAmount').textContent = '₱0';
        }

        // Handle leave document upload
        function handleLeaveDocument(event) {
            const file = event.target.files[0];
            if (file) {
                showNotification(`Leave document "${file.name}" uploaded successfully!`, 'success');
                console.log('Processing leave document:', file.name);
            }
        }

        // Handle timesheet document upload
        function handleTimesheetDoc(event) {
            const file = event.target.files[0];
            if (file) {
                showNotification(`Timesheet document "${file.name}" uploaded successfully!`, 'success');
                console.log('Processing timesheet document:', file.name);
            }
        }

        // Handle employee documents upload
        function handleEmployeeDoc(event) {
            const files = event.target.files;
            if (files.length > 0) {
                const fileNames = Array.from(files).map(f => f.name).join(', ');
                showNotification(`${files.length} employee document(s) uploaded successfully!`, 'success');
                console.log('Processing employee documents:', fileNames);
            }
        }

        // Generate employee report
        function generateEmployeeReport() {
            showNotification('Generating employee report...', 'success');
            
            setTimeout(() => {
                const reportContent = `
                    EMPLOYEE REPORT - ${new Date().toLocaleDateString()}
                    =====================================
                    
                    Leave Requests:
                    - John Doe: Annual Leave (3 days) - Approved
                    - Jane Smith: Sick Leave (1 day) - Pending
                    
                    Timesheet Summary:
                    - Total Hours This Month: 168
                    - Overtime Hours: 24
                    - Approved Timesheets: 15
                    
                    Documents Uploaded:
                    - Employee Contract: 1
                    - ID Documents: 2
                    - Training Certificates: 3
                `;
                
                const blob = new Blob([reportContent], { type: 'text/plain' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `employee_report_${new Date().toISOString().split('T')[0]}.txt`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
                
                showNotification('Employee report generated successfully!', 'success');
            }, 1000);
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const userDropdown = document.getElementById('userDropdown');
            const userButton = event.target.closest('button[onclick="toggleUserDropdown()"]');
            
            if (!userButton && userDropdown && !userDropdown.classList.contains('hidden')) {
                userDropdown.classList.add('hidden');
            }
        });

        // Quotation dropdown toggle
        function toggleQuotationDropdown() {
            const dropdown = document.getElementById('quotationDropdown');
            const arrow = document.getElementById('dropdownArrow');
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                dropdown.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }

        // Show quotation dropdown on hover
        function showQuotationDropdown() {
            const dropdown = document.getElementById('quotationDropdown');
            const arrow = document.getElementById('dropdownArrow');
            dropdown.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        }

        // Hide quotation dropdown on mouse leave
        function hideQuotationDropdown() {
            const dropdown = document.getElementById('quotationDropdown');
            const arrow = document.getElementById('dropdownArrow');
            dropdown.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }

        // Quotation modal functions
        function openQuotationModal() {
            const modal = document.getElementById('quotationModal');
            if (modal) {
                modal.classList.remove('hidden');
                // Generate new quotation ID
                document.getElementById('quotationId').value = 'Q-' + Date.now();
                // Clear form fields
                document.getElementById('customerName').value = '';
                document.getElementById('projectDetails').value = '';
                document.getElementById('quotationStatus').value = 'draft';
                // Clear items and add one initial item
                const itemsBody = document.getElementById('quotationItems');
                itemsBody.innerHTML = `
                    <tr>
                        <td class="px-4 py-2">
                            <select class="w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white">
                                <option value="">Select Equipment</option>
                                <option>20 Ton Mobile</option>
                                <option>35 Ton Crawler</option>
                                <option>50 Ton Tower</option>
                                <option>80 Ton All Terrain</option>
                            </select>
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" placeholder="Days" min="1" class="w-20 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white" onchange="calculateItemTotal(this)">
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" placeholder="Rate" min="1" step="100" class="w-24 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white" onchange="calculateItemTotal(this)">
                        </td>
                        <td class="px-4 py-2 font-semibold text-gray-900 dark:text-white">₱0</td>
                        <td class="px-4 py-2">
                            <button type="button" onclick="removeQuotationItem(this)" class="text-red-600 hover:text-red-900 text-sm">Remove</button>
                        </td>
                    </tr>
                `;
                // Reset total
                document.getElementById('totalAmount').textContent = '₱0';
            }
        }

        function closeQuotationModal() {
            const modal = document.getElementById('quotationModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        </script>
</body>
</html>
