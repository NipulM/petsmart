<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetSmart - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@400;600&family=Unica+One&display=swap" rel="stylesheet">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <link rel="stylesheet" href="./assets/css/main.css">
    <style>
        body {
        font-family: 'Signika', sans-serif;
        font-size: 18px;
        }
    </style>
</head>
<body id="admin-dashboard" class="bg-gray-100 hidden">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-white shadow-lg fixed flex flex-col">
            <div class="p-4">
                <h1 class="text-xl font-bold">PetSmart Admin</h1>
            </div>
            <nav class="mt-4 flex-grow">
                <a href="#dashboard" id="dashboard-link" class="block px-4 py-2 bg-gray-100">Dashboard</a>
                <a href="#products" id="products-link" class="block px-4 py-2 hover:bg-gray-100">Products</a>
                <a href="#subscriptions" id="subscriptions-link" class="block px-4 py-2 hover:bg-gray-100">Subscriptions</a>
                <a href="#orders" id="orders-link" class="block px-4 py-2 hover:bg-gray-100">Orders</a>
                <a href="#categories" id="categories-link" class="block px-4 py-2 hover:bg-gray-100">Categories</a>
                <a href="#blogs" id="blogs-link" class="block px-4 py-2 hover:bg-gray-100">Blogs</a>
            </nav>
            <div class="p-4 border-t">
                <a href="#" id="logout-btn" class="block px-4 py-2 text-red-600 hover:bg-red-50 rounded flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64 flex-1 p-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Orders</h3>
                    <p id="total-orders" class="text-2xl font-bold">156</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Pending Orders</h3>
                    <p id="pending-orders" class="text-2xl font-bold">23</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Products</h3>
                    <p id="total-products" class="text-2xl font-bold">450</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Revenue</h3>
                    <p id="total-revenue" class="text-2xl font-bold">$25,600</p>
                </div>
            </div>

            <div id="dashboard-content">
                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Products by Category Chart -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Products by Category</h3>
                        <div id="productsPieChart" style="height: 300px;"></div>
                    </div>

                    <!-- Orders by Status Chart -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Orders by Status</h3>
                        <div id="ordersPieChart" style="height: 300px;"></div>
                    </div>
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Order ID</th>
                                    <th class="text-left py-2">Customer</th>
                                    <th class="text-left py-2">Status</th>
                                    <th class="text-left py-2">Total</th>
                                </tr>
                            </thead>
                            <tbody id="recent-orders-table">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="products-container" class="hidden">
            </div>

            <div id="subscriptions-container" class="hidden">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Subscription Stats</h3>
                        <div id="subscriptionsPieChart" style="height: 300px;"></div>
                    </div>
            </div>

            <div id="orders-container" class="hidden">
            </div>

            <div id="categories-container" class="hidden">
                <div id="add-new-category"></div>
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Products by Category</h3>
                        <div id="productsBarChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <div id="blog-container" class="hidden">
            </div>
        </div>
    </div>

    <script defer src="./js/admin.js"></script>
    <script defer src="./js/login.js"></script>
</body>
</html>
