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
    <div id="main-content">
    <!-- Header -->
        <?php include '../layouts/header.php'; ?>
        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8 mb-6">
            <h1 class="text-3xl font-bold mb-8">Find the Perfect Treats & Supplies <br> <span class="block">for Your Pet!</span> </h1>
            <div class="flex gap-8">
                <!-- Sidebar -->
                <div class="w-[400px] flex-shrink-0">
                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Select Category</h2>
                        <select id="category-select" class="w-full p-2 border rounded bg-white">
                            <option value="default" selected>Pick an option</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Filter by Price</h2>
                        <select id="price-select" class="w-full p-2 border rounded bg-white">
                            <option value="default" selected>Pick an option</option>
                            <option value="0-9.99">$0 - $9.99</option>
                            <option value="9.99-19.99">$9.99 - $19.00</option>
                            <option value="19.99-49.99">$19.99 - $49.00</option>
                            <option value="49.99-99.99">$49.99 - $99.00</option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <button class="bg-green-500 text-white rounded py-2 px-4 w-1/2 mr-2" onclick="applyFilters()">Apply Filters</button>
                        <button class="bg-green-500 text-white rounded py-2 px-4 w-1/2" onclick="clearFilters()">Clear Filters</button>
                    </div>
                    <button onclick="getAllItems()" class="w-full bg-green-500 text-white rounded py-2">Get All Items</button>
                </div>

                <!-- Product Grid -->
                <div class="flex-1">
                    <div id="results-title">
                    </div>
                    <div id="filtered-products" class="grid grid-cols-2 gap-6">
                    </div>
                </div>
            </div>

        </main>

        <?php include '../layouts/footer.php'; ?>
    </div> 
    
    <?php include '../layouts/login-modal.php'; ?>
    <?php include '../layouts/register-modal.php'; ?>   

    <script defer src="../assets/js/search-page.js"></script>
    <script defer src="../assets/js/auth/login.js"></script>
    <script defer src="../assets/js/auth/register.js"></script>
    <script defer src="../assets/js/features/cart.js"></script>
</body>
</html>