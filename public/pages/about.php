<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetSmart - Search</title>
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
<body class="bg-[#F8F8F8]">
    <!-- Header -->
    <header class="bg-[#F8F8F8] py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="../index.php" class="flex items-center">
            <img src="../assets/images/main-logo.webp" alt="PetSmart" class="h-14 -ml-4">
            <span class="text-gray-800 font-bold text-xl"></span>
        </a>
        <nav class="space-x-16">
                    <a href="./search.php" class="text-gray-600 hover:text-gray-800">Search</a>
                    <a href="./subscription.php" class="text-gray-600 hover:text-gray-800">Subscription</a>
                    <a href="./about.php" class="text-red-500">About Us</a>
        </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <h1 class="text-4xl font-bold text-center mb-12">Welcome to PetSmart!</h1>
        
        <!-- About Us Section -->
        <div class="flex items-center justify-between mb-20">
            <div class="w-1/2 pr-12">
                <h2 class="text-2xl font-bold mb-4">About us</h2>
                <p class="text-gray-700">At PetSmart, we believe in making the world a better place—one paw at a time. As pet lovers ourselves, we understand the joy and responsibility of caring for your furry, feathery, or scaly companions. That's why we created an e-commerce platform dedicated to providing high-quality, eco-friendly, and sustainable pet products that both you and your pets will love.</p>
            </div>
            <div class="w-2/2">
                <img src="../assets/images/aboutpage-dog.png" alt="Happy dog with toys" class="clip-path-blob1 w-full">
            </div>
        </div>

        <!-- Mission Section -->
        <div class="flex items-center justify-between mb-20">
            <div class="w-2/2">
                <img src="../assets/images/aboutpage-owner-with-dog.png" alt="Pet owner with dog" class="clip-path-blob2 w-full">
            </div>
            <div class="w-1/2 pl-12">
                <h2 class="text-2xl font-bold mb-4">Our Mission</h2>
                <p class="mb-4">Our mission is simple:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>To provide pet owners with sustainable and ethical choices.</li>
                    <li>To support a healthier planet by reducing waste and promoting environmentally friendly practices.</li>
                    <li>To ensure every pet gets the care, comfort, and love they deserve.</li>
                </ul>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="flex items-center justify-center mb-20">
            <div class="w-[700px]">
                <h2 class="text-2xl font-bold mb-6">Why Choose Us?</h2>
                <p class="mb-4">We know you have options when it comes to shopping for your pets, but here's what sets us apart:</p>
                <div class="space-y-4">
                    <p><span class="font-bold">1. Eco-Friendly Products:</span> From non-toxic toys to biodegradable pet care essentials, we prioritise sustainability in everything we offer.</p>
                    <p><span class="font-bold">2. Convenience at Your Fingertips:</span> No more rushing to the store—shop from the comfort of your home and have everything delivered right to your door.</p>
                    <p><span class="font-bold">3. Tailored Monthly Subscriptions:</span> Our Monthly Box is customised to suit your pet's unique needs, bringing joy and surprises every month.</p>
                    <p><span class="font-bold">4. Educational Resources:</span> Stay informed with our blogs and videos on pet care, sustainable living, and DIY tips to make your pet's life even better.</p>
                </div>
            </div>
        </div>

        <!-- Blog Section -->
        <p class="mb-8">Looking for tips on pet grooming, training, or sustainable living? <a href="#blogs" class="text-blue-600 hover:underline">Check out our blog</a>, where we share weekly articles and videos to help you care for your pets with love and knowledge.</p>
        
        <p class="-mt-5 mb-12">Thank you for being part of the PetSmart community—where happy pets meet a healthier planet! ❤️</p>

        <!-- Care & Comfort Section -->
        <h2 id="blogs" class="text-2xl font-bold mb-7">Care & Comfort Corner</h2>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="flex w-full">
                <div class="w-2/5">
                <div class="relative w-full h-[300px] m-5">
                    <img src="../assets/images/blog-test.png" alt="Dog grooming" class="absolute top-0 left-0 w-full h-full object-cover rounded-2xl">
                </div>
                </div>
                <div class="w-3/5 p-12">
                    <h3 class="text-xl font-bold mb-4">5 Easy Grooming Tips for a Happier Pet</h3>
                    <p class="text-gray-700">Keeping your pet clean and well-groomed is essential for their health and happiness. From regular brushing to choosing the right shampoo, small efforts can make a big difference. Whether you're a seasoned pet parent or a newbie, these quick grooming tips will have your furry friend looking and feeling their best in no time!</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-green-500 text-white mt-12 py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-3 gap-8">
                <div>
                    <img src="../assets/images/logo-white.png" alt="PetSmart Logo" class="mb-4 h-12"/>
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
</body>
</html>