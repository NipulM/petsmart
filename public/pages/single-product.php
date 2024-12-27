<?php
// product.php
$product_id = $_GET['id'] ?? null;
if (!$product_id) {
    header('Location: ../../index.php');
    exit;
}

// Fetch product data using the correct API endpoint
$api_url = "http://localhost/CB011999/public/api.php/get-product-by-id?id=" . $product_id;
try {
    $product_data = file_get_contents($api_url);
    $product = json_decode($product_data, true);

    if (!$product || $product['status'] !== 'success' || empty($product['data'])) {
        throw new Exception("Product not found");
    }

    $product_details = $product['data'];

    $api_url_categories = "http://localhost/CB011999/public/api.php/get-category-by-id?id=${product_details['category_id']}";

    try {
        $category_data = file_get_contents($api_url_categories);
        $category = json_decode($category_data, true);

        if (!$category || $category['status'] !== 'success' || empty($category['data'])) {
            throw new Exception("Category not found");
        }

        $category_details = $category['data'];
    } catch (Exception $e) {
        $category_details = null;
    }

} catch (Exception $e) {
    header('Location: ../index.php');
    exit;
}

// Since we're using the actual product data now, we don't need to check for 'status'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product_details['name']); ?> - PetSmart</title>
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

        <!-- Product Details -->
        <main class="container mx-auto px-4 py-12">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Product Image -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <img 
                            src="<?php echo htmlspecialchars($product_details['image_url']); ?>" 
                            alt="<?php echo htmlspecialchars($product_details['name']); ?>"
                            class="w-full h-auto object-cover rounded-lg"
                        >
                    </div>

                    <!-- Product Info -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <nav class="mb-4">
                            <ol class="flex text-sm text-gray-500">
                                <li><a href="../index.php" class="hover:text-green-500">Home</a></li>
                                <li><span class="mx-2">/</span></li>
                                <li><?php echo htmlspecialchars($product_details['name']); ?></li>
                            </ol>
                        </nav>

                        <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($product_details['name']); ?></h1>
                        
                        <!-- Categories/Tags -->
                        <?php if (!empty($category_details['name'])): ?>
                        <div class="mb-4">
                            <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-600 mr-2">
                                #<?php echo htmlspecialchars($category_details['name']); ?>
                            </span>
                        </div>
                        <?php endif; ?>

                        <div class="mb-6">
                            <span class="text-3xl font-bold text-green-500">
                                $<?php echo number_format($product_details['price'], 2); ?>
                            </span>
                        </div>

                        <div class="mb-8">
                            <h2 class="text-xl font-semibold mb-2">Description</h2>
                            <p class="text-gray-600">
                                <?php echo nl2br(htmlspecialchars($product_details['description'])); ?>
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex items-center border rounded-lg">
                                <button class="px-4 py-2 text-gray-600 hover:text-gray-800" onclick="updateQuantity(-1)">-</button>
                                <input type="number" id="quantity" value="1" min="1" class="w-16 text-center border-x py-2">
                                <button class="px-4 py-2 text-gray-600 hover:text-gray-800" onclick="updateQuantity(1)">+</button>
                            </div>
                            <button 
                                onclick="addToCart([
                                    <?php echo $product_details['product_id']; ?>, 
                                    <?php echo $product_details['price']; ?>, 
                                    '<?php echo htmlspecialchars($product_details['name'], ENT_QUOTES, 'UTF-8'); ?>', 
                                    '<?php echo htmlspecialchars($product_details['image_url'], ENT_QUOTES, 'UTF-8'); ?>', 
                                    <?php echo $product_details['stock_quantity']; ?>, 
                                    '<?php echo htmlspecialchars($category_details['name'], ENT_QUOTES, 'UTF-8'); ?>'
                                ])"
                                class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include '../layouts/footer.php'; ?>
    </div>

    <?php include '../layouts/login-modal.php'; ?>
    <?php include '../layouts/register-modal.php'; ?>

    <script defer src="../assets/js/single-product-page.js"></script>
    <script defer src="../assets/js/auth/login.js"></script>
    <script defer src="../assets/js/auth/register.js"></script>
    <script defer src="../assets/js/features/cart.js"></script>
</body>
</html>