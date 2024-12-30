<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetSmart Admin - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@400;600&family=Unica+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
    <style>
        body { font-family: 'Signika', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h1 class="text-2xl font-bold mb-6 text-center">PetSmart Admin</h1>
            <form id="loginForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" id="email" required class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" id="password" required class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
                <p id="errorMessage" class="text-red-500 text-sm text-center hidden"></p>
            </form>
        </div>
    </div>

    <script defer src="./js/login.js"></script>
</body>
</html>