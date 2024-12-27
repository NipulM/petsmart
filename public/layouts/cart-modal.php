<div id="cartModal" class="hidden fixed inset-0 bg-black bg-opacity-65 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-y-auto">
    <!-- Modal Header -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Your Cart</h2>
      <button id="closeCartModal" class="text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Cart Items -->
    <div id="cartItems" class="mb-6">
      <!-- Items will be inserted here dynamically -->
    </div>

    <!-- Empty Cart Message -->
    <div id="emptyCartMessage" class="text-center py-8 hidden">
      <p class="text-gray-500">Your cart is empty</p>
    </div>

    <!-- Contact Information Form -->
    <div id="contactForm" class="space-y-4 border-t pt-4">
      <h3 class="text-xl font-semibold">Contact Information</h3>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input type="text" id="customerName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Phone</label>
          <input type="tel" id="customerPhone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="customerEmail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <textarea id="customerAddress" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
      </div>
    </div>

    <!-- Cart Summary -->
    <div class="border-t mt-6 pt-4">
      <div class="flex justify-between text-lg font-semibold">
        <span>Total:</span>
        <span id="cartTotal">$0.00</span>
      </div>
      <button id="checkoutBtn" class="mt-4 w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 disabled:bg-gray-400">
        Proceed to Checkout
      </button>
    </div>
  </div>
</div>