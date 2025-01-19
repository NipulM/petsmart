<div id="subscriptionModal" class="hidden fixed inset-0 bg-black bg-opacity-65 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-y-auto">
    <!-- Modal Header -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Your Subscription</h2>
      <button id="closeSubscriptionModal" class="text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Selected Plan -->
    <div id="selectedPlan" class="mb-6 p-4 bg-gray-50 rounded-lg">
      <h3 class="text-xl font-semibold mb-2">Selected Plan</h3>
      <div id="planDetails" class="text-gray-700">
        <!-- Plan details will be inserted here -->
      </div>
    </div>

    <!-- Products Section -->
    <div class="mb-6">
      <h3 class="text-xl font-semibold mb-4">Add Products to Your Box</h3>
      <div id="productsList" class="grid grid-cols-2 gap-4">
        <!-- Products will be inserted here -->
      </div>
    </div>

    <!-- Selected Products -->
    <div class="mb-6">
      <h3 class="text-xl font-semibold mb-4">Your Box Items</h3>
      <div id="selectedProducts" class="space-y-4">
        <!-- Selected products will be inserted here -->
      </div>
      <div id="emptyBoxMessage" class="text-center py-4 text-gray-500 hidden">
        Your box is empty. Add some products above!
      </div>
    </div>

    <!-- Contact Information Form -->
    <div id="subscriptionForm" class="space-y-4 border-t pt-4">
      <h3 class="text-xl font-semibold">Contact Information</h3>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input type="text" id="subscriberName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Phone</label>
          <input type="tel" id="subscriberPhone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="subscriberEmail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Delivery Address</label>
        <textarea id="subscriberAddress" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
      </div>
    </div>

    <!-- Subscription Summary -->
    <div class="border-t mt-6 pt-4">
      <div class="flex justify-between text-lg font-semibold">
        <span>Total:</span>
        <span id="subscriptionTotal">$0.00</span>
      </div>
      <button id="subscribeBtn" class="mt-4 w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 disabled:bg-gray-400">
        Confirm Subscription And Place Order
      </button>
    </div>
  </div>
</div>