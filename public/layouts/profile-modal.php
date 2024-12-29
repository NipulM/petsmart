<div id="profileModal" class="hidden fixed inset-0 bg-black bg-opacity-65 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-y-auto">
    <!-- Modal Header -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Your Profile</h2>
      <button id="closeProfileModal" class="text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
      <nav class="-mb-px flex space-x-8">
        <button class="tab-btn px-1 py-4 border-b-2 border-blue-500 font-medium text-blue-600" data-tab="profile">
          Profile
        </button>
        <button class="tab-btn px-1 py-4 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="pet">
          Pet Information
        </button>
        <button class="tab-btn px-1 py-4 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="orders">
          Orders
        </button>
      </nav>
    </div>

    <!-- Profile Tab Content -->
    <div id="profileTab" class="tab-content py-4">
      <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="tel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Created At</label>
            <input type="text" disabled value="2024-12-29" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Address</label>
          <textarea rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Bio</label>
          <textarea rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Preferences</label>
          <div class="mt-2 space-y-2">
            <label class="inline-flex items-center mr-10">
              <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
              <span class="ml-2">Email notifications</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
              <span class="ml-2">SMS notifications</span>
            </label>
          </div>
        </div>
      </div>
    </div>

    <!-- Pet Information Tab Content -->
    <div id="petTab" class="tab-content py-4 hidden">
      <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Pet Name</label>
            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Age</label>
            <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Breed</label>
            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
            <input type="number" step="0.1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Medical History</label>
          <textarea rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Special Requirements</label>
          <textarea rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Vaccination Status</label>
          <div class="mt-2 space-y-2">
            <label class="inline-flex items-center">
              <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
              <span class="ml-2">Rabies</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
              <span class="ml-2">DHPP</span>
            </label>
          </div>
        </div>
      </div>
    </div>

    <!-- Orders Tab Content -->
    <div id="ordersTab" class="tab-content py-4 hidden">
      <div class="space-y-4">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
          <div class="p-4">
            <div class="flex justify-between items-center mb-2">
              <div>
                <span class="text-sm text-gray-500">Order ID:</span>
                <span class="ml-2 font-medium">#ORD-2024-001</span>
              </div>
              <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                Delivered
              </span>
            </div>
            <div class="flex justify-between items-center">
              <div>
                <span class="text-sm text-gray-500">Total Price:</span>
                <span class="ml-2 font-medium">$149.99</span>
              </div>
              <div>
                <span class="text-sm text-gray-500">Pet Service:</span>
                <span class="ml-2 font-medium">Grooming + Health Check</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Save Button -->
    <div class="mt-6 flex justify-end">
      <button class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
        Save Changes
      </button>
    </div>
  </div>
</div>