<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetSmart - Subscription</title>
    <script defer src="../assets/js/auth.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@400;600&family=Unica+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
    <style>
        body {
            font-family: 'Signika', sans-serif;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div id="main-content">
        <header class="bg-[#F8F8F8] py-4 relative z-10" >
            <div class="container mx-auto flex justify-between items-center">
                <a href="../index.php" class="flex items-center">
                    <img src="../assets/images/main-logo.webp" alt="PetSmart" class="h-14 -ml-4">
                    <span class="text-gray-800 font-bold text-xl"></span>
                </a>
                <nav class="space-x-16">
                    <a href="./search.php" class="text-gray-600 hover:text-gray-800">Search</a>
                    <a href="./subscription.php" class="text-red-500"">Subscription</a>
                    <a href="./about.php" class="text-gray-600 hover:text-gray-800">About Us</a>
                    <button id="loginBtn" class="text-gray-600 hover:text-gray-800">Login</button>
                </nav>
            </div>
        </header>
    
        <main>
            <section class="bg-[#F8F8F8] py-1">
                <div class="container mx-auto flex items-center -my-20">
                    <div class="w-1/2">     
                        <img src="../assets/images/subscriptionpage-hero.png" alt="Pet Essentials" class="w-9/10 mx-auto -ml-10">
                    </div>
                    <div class="w-1/2">
                        <h1 class="text-4xl font-bold mb-4">
                            Subscribe to Simplify <br>
                            <span class="block">Your Pet Care!</span>
                        </h1>
                        <p class="text-gray-600 mb-8">
                            Say goodbye to the stress of last-minute shopping for your pet's needs. With PetSmart's subscription plans, you'll enjoy seamless, regular deliveries tailored to your pet's lifestyle—ensuring happiness, health, and convenience every step of the way.
                        </p>
                        <a href="#plans" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded">Choose a Plan</a>
                    </div>
                </div>
            </section>

            <section id="plans" class="py-16 bg-[#F8F8F8] -mt-7">
                <div class="container mx-auto px-4">
                        <div class="flex justify-center gap-8">
                            <!-- Basic Plan Card -->
                            <div class="w-96 bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                                <div class="m-5">
                                    <img src="../assets/images/basic-box.webp" alt="Basic Plan" class="w-full h-64 rounded-2xl object-cover">
                                </div>
                                <div class="p-8 flex flex-col flex-grow">
                                    <!-- Content Container -->
                                    <div class="flex-grow">
                                        <h2 class="text-2xl font-bold text-center mb-4">Basic</h2>
                                        <p class="text-gray-600 text-center mb-8 h-24">
                                            Enjoy hassle-free pet care with a 3-month subscription. Customize your supplies and receive regular deliveries to your door.
                                        </p>
                                        
                                        <div class="space-y-4 mb-8">
                                            <div class="flex items-start gap-2">
                                                <svg class="w-5 h-5 mt-1 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <p class="text-gray-700">Flexible supply updates anytime.</p>
                                            </div>
                                            <div class="flex items-start gap-2">
                                                <svg class="w-5 h-5 mt-1 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <p class="text-gray-700">Monthly toy replacement to keep your pet entertained.</p>
                                            </div>
                                            <div class="flex items-start gap-2">
                                                <svg class="w-5 h-5 mt-1 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <p class="text-gray-700">Perfect for pet parents seeking convenience and reliability.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Price and Button Container -->
                                    <div class="mt-auto">
                                        <div class="text-center mb-6">
                                            <div class="text-4xl font-bold mb-2">$19.99</div>
                                            <p class="text-gray-600 text-sm">3 months of hassle-free pet care!</p>
                                        </div>
                                        
                                        <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                            Subscribe to Basic
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Premium Plan Card -->
                            <div class="w-96 bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                                <div class="m-5">   
                                    <img src="../assets/images/premium-box.png" alt="Premium Plan" class="w-full h-64 rounded-2xl object-cover">
                                </div>
                                <div class="p-8 flex flex-col flex-grow">
                                    <!-- Content Container -->
                                    <div class="flex-grow">
                                        <h2 class="text-2xl font-bold text-center mb-4">Premium</h2>
                                        <p class="text-gray-600 text-center mb-8 h-24">
                                            Simplify your pet care for an entire year with our Premium Plan. Fully managed supplies and monthly surprises!
                                        </p>
                                        
                                        <div class="space-y-4 mb-8">
                                            <div class="flex items-start gap-2">
                                                <svg class="w-5 h-5 mt-1 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <p class="text-gray-700">All benefits of the Basic Plan.</p>
                                            </div>
                                            <div class="flex items-start gap-2">
                                                <svg class="w-5 h-5 mt-1 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <p class="text-gray-700">Exclusive premium items included.</p>
                                            </div>
                                            <div class="flex items-start gap-2">
                                                <svg class="w-5 h-5 mt-1 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <p class="text-gray-700">Exclusive discounts on pet essentials and add-ons.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Price and Button Container -->
                                    <div class="mt-auto">
                                        <div class="text-center mb-6">
                                            <div class="text-4xl font-bold mb-2">$49.99</div>
                                            <p class="text-gray-600 text-sm">1 year of premium pet care!</p>
                                        </div>
                                        
                                        <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                            Subscribe to Premium
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="bg-green-500 text-white py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-3 gap-8">
                    <div>
                        <img src="/api/placeholder/150/50" alt="PetSmart Logo" class="mb-4"/>
                        <p class="text-sm">Caring for Pets, Simplifying Your Life!</p>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:underline">Home</a></li>
                            <li><a href="#" class="hover:underline">Search</a></li>
                            <li><a href="#" class="hover:underline">Subscription Plans</a></li>
                            <li><a href="#" class="hover:underline">About us / Blogs</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-semibold mb-4">Contact Information</h3>
                        <ul class="space-y-2">
                            <li>support@petsmart.com</li>
                            <li>+94 77 071 4178</li>
                            <li>134/89, Kindamith Str. Ppers Rd.</li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-8 pt-4 border-t border-green-400">
                    © 2024 PetSmart. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <?php include '../layouts/login-modal.php'; ?>
    <?php include '../layouts/register-modal.php'; ?>    
</body>
</html>