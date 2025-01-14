class Profile {
  constructor() {
    // Modal elements
    this.modal = document.getElementById("profileModal");
    this.profileIcon = document.getElementById("profileIcon");
    this.closeBtn = document.getElementById("closeProfileModal");
    this.logoutBtn = document.getElementById("logoutButton");

    // Tab elements
    this.tabs = document.querySelectorAll(".tab-btn");
    this.tabContents = document.querySelectorAll(".tab-content");

    // Save button
    this.saveBtn = this.modal.querySelector('button[class*="bg-blue-600"]');

    // User data
    this.userData = null;
    this.userOrders = null;

    this.orderDetailsModal = null;
    this.createOrderDetailsModal();

    this.init();
  }

  init() {
    // Modal controls
    this.profileIcon.addEventListener("click", async () => {
      this.showLoader();
      await this.openModal();
    });
    this.closeBtn.addEventListener("click", () => this.closeModal());
    this.modal.addEventListener("click", (e) => this.handleOutsideClick(e));

    this.logoutBtn.addEventListener("click", () => this.handleLogout());

    // Tab switching
    this.tabs.forEach((tab) => {
      tab.addEventListener("click", () => this.switchTab(tab));
    });

    this.saveBtn.addEventListener("click", () => this.saveChanges());
  }

  showLoader() {
    if (!this.loader) {
      this.loader = document.createElement("div");
      this.loader.className =
        "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[51]";
      this.loader.innerHTML = `
        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-3">
          <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span class="text-gray-700">Loading profile...</span>
        </div>
      `;
    }
    document.body.appendChild(this.loader);
  }

  hideLoader() {
    if (this.loader && this.loader.parentNode) {
      this.loader.parentNode.removeChild(this.loader);
    }
  }

  createOrderDetailsModal() {
    if (!this.orderDetailsModal) {
      const modal = document.createElement("div");
      modal.className =
        "fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-[52]";
      modal.id = "orderDetailsModal";
      modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl w-full max-w-xl mx-4 overflow-hidden">
          <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-medium">Order Details</h3>
            <button class="text-gray-400 hover:text-gray-500" id="closeOrderDetails">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="p-4" id="orderDetailsContent"></div>
        </div>
      `;
      document.body.appendChild(modal);

      modal
        .querySelector("#closeOrderDetails")
        .addEventListener("click", () => {
          this.closeOrderDetailsModal();
        });

      modal.addEventListener("click", (e) => {
        if (e.target === modal) {
          this.closeOrderDetailsModal();
        }
      });

      this.orderDetailsModal = modal;
    }
  }

  async fetchUserData() {
    try {
      const response = await fetch(
        "http://localhost/CB011999/public/api.php/user-profile"
      );
      if (!response.ok) throw new Error("Failed to fetch user data");

      const userData = await response.json();
      this.userData = userData.data;
    } catch (error) {
      console.error("Error fetching user data:", error);
      this.showNotification("Failed to load profile data", "error");
    }
  }

  async fetchUserOrders() {
    try {
      const response = await fetch(
        "http://localhost/CB011999/public/api.php/get-user-orders"
      );
      if (!response.ok) throw new Error("Failed to fetch user orders");

      const userOrders = await response.json();
      this.userOrders = userOrders;
    } catch (error) {
      console.error("Error fetching user orders:", error);
    }
  }

  handleLogout() {
    try {
      localStorage.removeItem("cartItems");
      localStorage.setItem("isLoggedIn", "false");

      document.cookie =
        "session_token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";

      this.closeModal();
      this.showNotification("Logged out successfully!");

      window.location.href = "../pages/index.php";
    } catch (error) {
      console.error("Error during logout:", error);
      this.showNotification("Failed to logout properly", "error");
    }
  }

  async openModal() {
    // Fetch user data before showing modal
    await this.fetchUserData();
    await this.fetchUserOrders();
    this.hideLoader();

    if (this.userData) {
      this.populateUserData();
      this.modal.classList.remove("hidden");
      document.body.style.overflow = "hidden";
    }
  }

  closeModal() {
    this.modal.classList.add("hidden");
    document.body.style.overflow = "";
  }

  handleOutsideClick(event) {
    if (event.target === this.modal) {
      this.closeModal();
    }
  }

  populateUserData() {
    // Populate Profile tab
    const profileTab = document.getElementById("profileTab");
    profileTab.querySelector('input[type="text"]').value = this.userData.name
      ? this.userData.name.charAt(0).toUpperCase() + this.userData.name.slice(1)
      : "";
    profileTab.querySelector('input[type="email"]').value =
      this.userData.email || "";
    profileTab.querySelector('input[type="tel"]').value =
      this.userData.phone || "";
    profileTab.querySelector("textarea").value = this.userData.address || "";
    profileTab.querySelectorAll("textarea")[1].value = this.userData.bio || "";

    // Handle preferences
    if (this.userData.preferences) {
      const preferences = JSON.parse(this.userData.preferences);
      profileTab
        .querySelectorAll('input[type="checkbox"]')
        .forEach((checkbox, index) => {
          if (index === 0)
            checkbox.checked = preferences.emailNotifications || false;
          if (index === 1)
            checkbox.checked = preferences.smsNotifications || false;
        });
    }

    // Populate Pet tab if pet_info exists
    if (this.userData.pet_info) {
      const petInfo = JSON.parse(this.userData.pet_info);
      const petTab = document.getElementById("petTab");

      petTab.querySelector('input[type="text"]').value = petInfo.pet_name || "";
      petTab.querySelector('input[type="number"]').value = petInfo.age || "";
      petTab.querySelectorAll('input[type="text"]')[1].value =
        petInfo.breed || "";
      petTab.querySelectorAll('input[type="number"]')[1].value =
        petInfo.weight || "";
      petTab.querySelector("textarea").value = petInfo.medicalHistory || "";
      petTab.querySelectorAll("textarea")[1].value =
        petInfo.specialRequirements || "";

      if (petInfo.vaccinations) {
        petTab
          .querySelectorAll('input[type="checkbox"]')
          .forEach((checkbox, index) => {
            if (index === 0)
              checkbox.checked = petInfo.vaccinations.rabies || false;
            if (index === 1)
              checkbox.checked = petInfo.vaccinations.dhpp || false;
          });
      }
    }

    const createdAtInput = profileTab.querySelector(
      'input[value="2024-12-29"]'
    );
    if (createdAtInput && this.userData.created_at) {
      createdAtInput.value = new Date(
        this.userData.created_at
      ).toLocaleDateString();
    }
  }

  populateUserOrders() {
    const ordersTab = document.getElementById("ordersTab");
    ordersTab.innerHTML = "";

    if (this.userOrders) {
      this.userOrders.forEach((order) => {
        const orderCard = `
          <div class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md cursor-pointer transition-shadow">
              <div class="p-4">
                <div class="flex justify-between items-center mb-2">
                  <div>
                    <span class="text-sm text-gray-500">Order ID:</span>
                    <span class="ml-2 font-medium">#ORD-${order.order_id}</span>
                  </div>
                  <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    ${
                      order.status
                        ? order.status.charAt(0).toUpperCase() +
                          order.status.slice(1)
                        : ""
                    }
                  </span>
                </div>
                <div class="flex justify-between items-center">
                  <div>
                    <span class="text-sm text-gray-500">Total Price:</span>
                    <span class="ml-2 font-medium">$${order.total_amount}</span>
                  </div>
                  <div>
                    <span class="text-sm text-gray-500">Placed Date</span>
                    <span class="ml-2 font-medium">${order.created_at}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>`;

        const orderElement = document.createElement("div");
        orderElement.innerHTML = orderCard;
        const orderCardElement = orderElement.firstElementChild;

        orderCardElement.addEventListener("click", () => {
          this.showOrderDetails(order);
        });

        ordersTab.appendChild(orderCardElement);
      });
    }
  }

  showOrderDetails(order) {
    const content = document.getElementById("orderDetailsContent");
    content.innerHTML = `
      <div class="space-y-4">
        <div class="border-b pb-4">
          <h4 class="font-medium mb-2">Customer Information</h4>
          <div class="grid grid-cols-2 gap-2 text-sm">
            <div>
              <span class="text-gray-500">Name:</span>
              <span class="ml-2">${order.name}</span>
            </div>
            <div>
              <span class="text-gray-500">Email:</span>
              <span class="ml-2">${order.email}</span>
            </div>
            <div>
              <span class="text-gray-500">Phone:</span>
              <span class="ml-2">${order.phone_number}</span>
            </div>
            <div>
              <span class="text-gray-500">Address:</span>
              <span class="ml-2">${order.address}</span>
            </div>
          </div>
        </div>

        <div>
          <h4 class="font-medium mb-2">Order Items</h4>
          <div class="space-y-3">
            ${order.order_items
              .map(
                (item) => `
              <div class="flex justify-between items-center border-b pb-3">
                <div class="flex items-center gap-4">
                  <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded">
                  <div>
                    <p class="font-medium">${item.name}</p>
                    <p class="text-sm text-gray-500">Quantity: ${item.quantity}</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="font-medium">$${item.price}</p>
                </div>
              </div>
            `
              )
              .join("")}
          </div>
        </div>

        <div class="border-t pt-4">
          <div class="flex justify-between items-center font-medium">
            <span>Total Amount:</span>
            <span>$${order.total_amount}</span>
          </div>
        </div>
      </div>
    `;

    this.orderDetailsModal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
  }

  closeOrderDetailsModal() {
    this.orderDetailsModal.classList.add("hidden");
    document.body.style.overflow = "";
  }

  switchTab(selectedTab) {
    this.tabs.forEach((tab) => {
      tab.classList.remove("border-blue-500", "text-blue-600");
      tab.classList.add("border-transparent", "text-gray-500");
    });

    selectedTab.classList.remove("border-transparent", "text-gray-500");
    selectedTab.classList.add("border-blue-500", "text-blue-600");

    this.tabContents.forEach((content) => {
      content.classList.add("hidden");
    });

    const targetId = `${selectedTab.dataset.tab}Tab`;
    document.getElementById(targetId).classList.remove("hidden");

    if (selectedTab.dataset.tab === "orders") {
      this.populateUserOrders();
      this.saveBtn.classList.add("hidden");
    } else {
      this.saveBtn.classList.remove("hidden");
    }
  }

  async saveChanges() {
    this.showLoader();

    try {
      const activeTab = Array.from(this.tabs).find((tab) =>
        tab.classList.contains("border-blue-500")
      );
      const activeTabName = activeTab.dataset.tab;

      let formData = {};

      switch (activeTabName) {
        case "profile":
          formData = {
            name: this.modal.querySelector('input[type="text"]').value,
            email: this.modal.querySelector('input[type="email"]').value,
            phone: this.modal.querySelector('input[type="tel"]').value,
            address: this.modal.querySelector("textarea").value,
            bio: this.modal.querySelectorAll("textarea")[1].value,
            preferences: JSON.stringify({
              emailNotifications: this.modal.querySelectorAll(
                'input[type="checkbox"]'
              )[0].checked,
              smsNotifications: this.modal.querySelectorAll(
                'input[type="checkbox"]'
              )[1].checked,
            }),
          };
          break;

        case "pet":
          formData = {
            name: this.modal.querySelector('input[type="text"]').value,
            email: this.modal.querySelector('input[type="email"]').value,
            pet_info: JSON.stringify({
              pet_name: this.modal.querySelector('#petTab input[type="text"]')
                .value,
              age: this.modal.querySelector('#petTab input[type="number"]')
                .value,
              breed: this.modal.querySelectorAll(
                '#petTab input[type="text"]'
              )[1].value,
              weight: this.modal.querySelector('#petTab input[type="number"]')
                .value,
              medicalHistory:
                this.modal.querySelector("#petTab textarea").value,
              specialRequirements:
                this.modal.querySelectorAll("#petTab textarea")[1].value,
              vaccinations: {
                rabies: this.modal.querySelectorAll(
                  '#petTab input[type="checkbox"]'
                )[0].checked,
                dhpp: this.modal.querySelectorAll(
                  '#petTab input[type="checkbox"]'
                )[1].checked,
              },
            }),
          };
          break;
      }

      const response = await fetch(
        "http://localhost/CB011999/public/api.php/update-user-profile",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(formData),
        }
      );

      if (!response.ok) throw new Error("Failed to save changes");
      this.showNotification("Changes saved successfully!");

      await this.fetchUserData();
      this.populateUserData();
    } catch (error) {
      console.error("Error saving changes:", error);
      this.showNotification("Failed to save changes", "error");
    } finally {
      this.hideLoader();
    }
  }

  showNotification(message, type = "success") {
    const notification = document.createElement("div");
    notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-md shadow-lg ${
      type === "success" ? "bg-green-500" : "bg-red-500"
    } text-white`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
      notification.remove();
    }, 3000);
  }
}

const profile = new Profile();
