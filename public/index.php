<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetSmart</title>
  <script defer src="./assets/js/main.js"></script>
  <script defer src="./assets/js/auth.js"></script>
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
<body>
  <div id="main-content">
    <header class="bg-[#F8F8F8] py-4">
      <div class="container mx-auto flex justify-between items-center">
        <a href="" class="flex items-center">
          <img src="./assets/images/main-logo.webp" alt="PetSmart" class="h-14 -ml-4">
          <span class="text-gray-800 font-bold text-xl"></span>
        </a>
        <nav class="space-x-16">
          <a href="./pages/search.php" class="text-gray-600 hover:text-gray-800">Search</a>
          <a href="./pages/subscription.php" class="text-gray-600 hover:text-gray-800">Subscription</a>
          <a href="./pages/about.php" class="text-gray-600 hover:text-gray-800">About Us</a>
          <button id="loginBtn" class="text-gray-600 hover:text-gray-800">Login</button>
        </nav>
      </div>
    </header>
    
    <main>
      <section class="bg-[#F8F8F8] py-20">
          <div class="container mx-auto flex items-center">
              <div class="w-1/2">
              <h1 class="text-4xl font-bold mb-4">
                  Your One-Stop Shop for <br>
                  <span class="block">Pet Essentials</span>
              </h1>
              <p class="text-gray-600 mb-8">
                  Find everything your pet loves in one place—delivered to your door. From premium food to stylish toys and accessories, PetSmart brings convenience and quality together for your furry friends.
              </p>
              <a href="#" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded">Browse Now</a>
              </div>
              <div class="w-1/2">
              <img src="./assets/images/homepage-hero.png" alt="Pet Essentials" class="w-4/5 mx-auto mr-1">
              </div>
          </div>
      </section>

      <section class="py-16">
        <div class="container mx-auto">
          <h2 class="text-3xl font-bold mb-8">New Arrivals for Your Beloved Pets</h2>
          <p class="text-gray-600 mb-8 -mt-5">
            Check out the latest additions to our collection! From delicious treats to fun toys, these fresh picks are here to delight your pets and make life easier for you.
          </p>
          <div id="product-grid" class="flex gap-6 overflow-x-auto whitespace-nowrap scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 p-4">
          </div>
        </div>
      </section>  

      <section class="bg-[#F8F8F8] py-16">
        <div class="container mx-auto">
          <h2 class="text-3xl font-bold mb-8">Simplify Pet Care with Tailored Subscription Plans</h2>
          <p class="text-gray-600 mb-8 -mt-5">
            Say goodbye to the stress of running out of pet essentials. With PetSmart's flexible subscription plans, you'll get regular deliveries tailored to your needs—keeping your pets happy, healthy, and entertained all year round.
          </p>

          <div class="grid grid-cols-2 gap-8">
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center text-center">
              <div class="h-18 w-full flex items-center justify-center overflow-hidden mb-4">
                <img src="./assets/images/basic-box.webp" alt="Subscription Box" class="object-cover h-full w-full rounded-md">
              </div>
              <h3 class="text-2xl font-bold mb-4">Basic</h3>
              <p class="text-gray-600 mb-6">Enjoy hassle-free pet care with a 3-month subscription. Customize your supplies and receive regular deliveries to your door.</p>
              <div class="flex-1 flex items-center justify-center mb-6">
                <ul>
                  <li class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Flexible supply updates anytime.</span>
                  </li>
                  <li class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Monthly toy replacement to keep your pet entertained.</span>
                  </li>
                </ul>
              </div>
              <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded">Subscribe to Basic</button>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center text-center">
              <div class="h-18 w-full flex items-center justify-center overflow-hidden mb-4">
                <img src="./assets/images/premium-box.png" alt="Subscription Box" class="object-cover h-full w-full rounded-md">
              </div>
              <h3 class="text-2xl font-bold mb-4">Premium</h3>
              <p class="text-gray-600 mb-6">Simplify your pet care for an entire year with our Premium Plan. Fully managed supplies and monthly surprises!</p>
              <div class="flex-1 flex items-center justify-center mb-6">
                <ul>
                  <li class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>All benefits of the Basic Plan.</span>
                  </li>
                  <li class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Exclusive premium items included.</span>
                  </li>
                </ul>
              </div>
              <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded">Subscribe to Premium</button>
            </div>
          </div>

        </div>
      </section>

    </main>

    <footer class="bg-green-500 text-white py-8">
          <div class="container mx-auto px-4">
              <div class="grid grid-cols-3 gap-8">
                  <div>
                      <img src="" alt="PetSmart Logo" class="mb-4"/>
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

  <?php include './layouts/login-modal.php'; ?>
  <?php include './layouts/register-modal.php'; ?>
</body>
</html>