<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetSmart</title>
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
<body>
  <div id="main-content">
    <!-- Header -->
    <?php include '../layouts/header.php'; ?>

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
              <img src="../assets/images/homepage-hero.png" alt="Pet Essentials" class="w-4/5 mx-auto mr-1">
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

          <div class="grid grid-cols-2 gap-8"></div>

        </div>
      </section>

    </main>

    <?php include '../layouts/footer.php'; ?>
  </div>

  <?php include '../layouts/login-modal.php'; ?>
  <?php include '../layouts/register-modal.php'; ?>

  <script defer src="../assets/js/main.js"></script>
  <script defer src="../assets/js/auth/login.js"></script>
  <script defer src="../assets/js/auth/register.js"></script>
  <script defer src="../assets/js/features/cart.js"></script>
  <script defer src="../assets/js/features/profile.js"></script>
</body>
</html>