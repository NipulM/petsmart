<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetSmart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script async src="./assets/js/main.js"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800">
                    PetSmart
                </div>
                <ul class="flex space-x-8 text-lg">
                    <li><a href="./pages/search.php" class="text-gray-600 hover:text-gray-900">Search</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-gray-900">Blog</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-gray-900">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to PetSmart</h1>
        <p class="text-lg text-gray-600 mb-6">
            Discover eco-friendly pet products that keep your furry friends happy and healthy—delivered straight to your doorstep.
        </p>
        <div class="space-x-4">
            <a href="#new-items" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                Explore New Arrivals
            </a>
            <a href="#subscription-section" class="bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300">
                Learn About Our Subscription Plans
            </a>
        </div>
    </div>


    <div id="new-items" class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Just Added: Fresh Finds for Your Pet</h2>
        <!-- <div id="product-grid" class="overflow-x-scroll grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        </div> -->
        <div id="product-grid" class="flex gap-6 overflow-x-auto whitespace-nowrap scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 p-4">
        </div>
    </div>

    <div id="subscription-section" class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Convenience Meets Care: Our Subscription Plans</h2>
        <p class="text-center text-gray-600 mb-8">
            Say goodbye to last-minute store runs! With our subscription plans, enjoy regular deliveries of tailored pet supplies, keeping your furry friends happy and well-cared for.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Premium Plan Card -->
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Basic Plan</h3>
                <p class="text-gray-600 mb-4">
                Enjoy a 3-month subscription with essentials tailored to your pet's needs. Flexible and hassle-free.
                </p>
                <ul class="text-left text-gray-600 space-y-2 mb-6">
                    <li>✔ Customized supply list</li>
                    <li>✔ Regular doorstep deliveries</li>
                    <li>✔ Monthly toy refresh</li>
                </ul>
                <a href="#" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                    Sign Up for Premium Plan
                </a>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Premium Plan</h3>
                <p class="text-gray-600 mb-4">
                    Commit to convenience with a 12-month subscription and enjoy exclusive perks for you and your pet.
                </p>
                <ul class="text-left text-gray-600 space-y-2 mb-6">
                    <li>✔ Everything in the Basic Plan</li>
                    <li>✔ Exclusive perks for annual subscribers</li>
                    <li>✔ Monthly toy refresh</li>
                </ul>
                <a href="#" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                    Sign Up for Premium Plan
                </a>
            </div>
        </div>
    </div>
</body>
</html>
