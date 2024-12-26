<?php

$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<header class="bg-[#F8F8F8] py-4 relative z-10">
      <div class="container mx-auto flex justify-between items-center">
        <a href="./index.php" class="flex items-center">
          <img src="../assets/images/main-logo.webp" alt="PetSmart" class="h-14 -ml-4">
          <span class="text-gray-800 font-bold text-xl"></span>
        </a>
        <nav class="flex items-center space-x-16">
            <a href="../pages/search.php" 
                class="<?php echo $current_page === 'search' ? 'text-red-500' : 'text-gray-600 hover:text-gray-800'; ?>">
                Search
            </a>
            <a href="../pages/subscription.php" 
                class="<?php echo $current_page === 'subscription' ? 'text-red-500' : 'text-gray-600 hover:text-gray-800'; ?>">
                Subscription
            </a>
            <a href="../pages/about.php" 
                class="<?php echo $current_page === 'about' ? 'text-red-500' : 'text-gray-600 hover:text-gray-800'; ?>">
                About Us
            </a>  
          
          <!-- Auth Section -->
          <div class="flex items-center">
            <!-- Login Button -->
            <button id="loginBtn" class="text-gray-600 hover:text-gray-800 block">Login</button>

            <!-- Icons (initially hidden) -->
            <div id="iconsContainer" class="hidden items-center space-x-16">
              <!-- Cart Icon with Counter -->
              <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hover:text-gray-800 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <div id="cartCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center hidden">
                  0
                </div>
              </div>

              <!-- Profile Icon -->
              <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hover:text-gray-800 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>


    <script src="../assets/js/auth/login.js"></script>