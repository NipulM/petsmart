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
        /* h1, h2, h3, h4, h5, h6 {
        font-family: 'Unica One', sans-serif;
        } */
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
          <a href="./search.php" class="text-red-500">Search</a>
          <a href="./subscription.php" class="text-gray-600 hover:text-gray-800">Subscription</a>
          <a href="./about.php" class="text-gray-600 hover:text-gray-800">About Us</a>
        </nav>
      </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Find the Perfect Treats & Supplies <br> <span class="block">for Your Pet!</span> </h1>
        <div class="flex gap-8">
            <!-- Sidebar -->
            <div class="w-[400px] flex-shrink-0">
                <div class="mb-6">
                    <h2 class="font-semibold mb-2">Select Category</h2>
                    <select class="w-full p-2 border rounded bg-white">
                        <option>Pick an option</option>
                        <option>Food & Treats</option>
                    </select>
                </div>

                <div class="mb-6">
                    <h2 class="font-semibold mb-2">Filter by Price</h2>
                    <select class="w-full p-2 border rounded bg-white">
                        <option>Pick an option</option>
                        <option value="lkr-0-lkr-2500">LKR 0 - LKR 2,500</option>
                        <option value="lkr-2500-lkr-5000">LKR 2,500 - LKR 5,000</option>
                        <option value="lkr-5000-lkr-7500">LKR 5,000 - LKR 7,500</option>
                        <option value="lkr-7500-lkr-10000">LKR 7,500 - LKR 10,000</option>
                    </select>
                </div>

                <div class="flex justify-between items-center mb-2">
                    <button class="bg-green-500 text-white rounded py-2 px-4 w-1/2 mr-2">Apply Filters</button>
                    <button class="bg-green-500 text-white rounded py-2 px-4 w-1/2">Clear Filters</button>
                </div>
                <button class="w-full bg-green-500 text-white rounded py-2">Get All Items</button>
            </div>

            <!-- Product Grid -->
            <div class="flex-1">
                <h2 class="text-xl font-semibold mb-6">Filtered Items (3)</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded shadow">
                        <div class="h-48 w-full flex items-center justify-center overflow-hidden mb-4">
                            <img src="../assets/images/premium-box.png" alt="Original Blend" class="object-cover h-full w-full"/>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-xl font-semibold mb-2">Original Blend</h3>
                            <p class="text-gray-600">Organic Paws Kangaroo Recipe offers a natural, balanced meal for cats and dogs of all ages.</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold">$5.99</span>
                            <button class="bg-green-500 text-white px-4 py-2 rounded">Add to Cart</button>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded shadow">
                        <div class="h-48 w-full flex items-center justify-center overflow-hidden mb-4">
                            <img src="../assets/images/basic-box.webp" alt="Original Blend" class="object-cover h-full w-full"/>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-xl font-semibold mb-2">Original Blend</h3>
                            <p class="text-gray-600">Organic Paws Kangaroo Recipe offers a natural, balanced meal for cats and dogs of all ages.</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold">$5.99</span>
                            <button class="bg-green-500 text-white px-4 py-2 rounded">Add to Cart</button>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded shadow">
                        <div class="h-48 w-full flex items-center justify-center overflow-hidden mb-4">
                            <img src="../assets/images/main-logo.png" alt="Original Blend" class="object-cover h-full w-full"/>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-xl font-semibold mb-2">Original Blend</h3>
                            <p class="text-gray-600">Organic Paws Kangaroo Recipe offers a natural, balanced meal for cats and dogs of all ages.</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold">$5.99</span>
                            <button class="bg-green-500 text-white px-4 py-2 rounded">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-green-500 text-white mt-6 py-8">
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
</body>
</html>