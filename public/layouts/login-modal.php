    <div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-65 flex items-center justify-center z-50">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md px-4">
            <div class="relative bg-white rounded-2xl shadow-lg p-8">
                <button id="closeLoginModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold mb-2">Login</h2>
                    <p class="text-gray-600">Welcome Back!</p>
                </div>

                <form id="loginForm" class="space-y-4">
                    <input id="email" type="email" placeholder="Email Address" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none" required>
                    
                    <input id="password" type="password" placeholder="Password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none" required>
                    
                    <div class="flex items-center justify-center">
                        <input type="checkbox" id="keepLoggedIn" class="w-4 h-4 text-purple-600 rounded border-gray-300">
                        <label for="keepLoggedIn" class="ml-2 text-gray-600">Keep me logged in</label>
                    </div>

                    <button type="submit" class="w-full py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-colors">
                        Log in
                    </button>

                    <div class="text-center text-gray-600">
                        Don't have an account? 
                        <a id="registerBtnRedirect" href="#" class="text-purple-600 hover:underline">Sign up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
