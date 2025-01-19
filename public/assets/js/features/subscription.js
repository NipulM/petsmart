class Subscription {
  constructor() {
    this.modal = document.getElementById("subscriptionModal");
    this.closeBtn = document.getElementById("closeSubscriptionModal");
    this.productsList = document.getElementById("productsList");
    this.selectedProducts = document.getElementById("selectedProducts");
    this.emptyMessage = document.getElementById("emptyBoxMessage");
    this.totalElement = document.getElementById("subscriptionTotal");
    this.subscribeBtn = document.getElementById("subscribeBtn");
    this.planDetails = document.getElementById("planDetails");

    this.selectedPlan = null;
    this.userData = null;
    this.products = [];
    this.boxItems = [];

    this.init();
  }

  init() {
    // Initialize event listeners
    this.closeBtn.addEventListener("click", () => this.closeModal());
    this.subscribeBtn.addEventListener("click", () =>
      this.handleSubscription()
    );

    // Add click handlers to subscription buttons
    document.querySelectorAll("button").forEach((button) => {
      if (button.textContent.trim().startsWith("Subscribe to")) {
        button.addEventListener("click", (e) => {
          const planType = e.target.textContent.includes("Premium")
            ? "Premium"
            : "Basic";
          const planPrice = planType === "Premium" ? 49.99 : 19.99;
          const planDuration = planType === "Premium" ? "1 year" : "3 months";

          this.selectedPlan = {
            type: planType,
            price: planPrice,
            duration: planDuration,
          };
          this.openModal();
        });
      }
    });

    this.modal.addEventListener("click", (e) => {
      if (e.target === this.modal) this.closeModal();
    });
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

  async fetchProducts() {
    try {
      const response = await fetch(
        "http://localhost/CB011999/public/api.php/get-all-products"
      );
      if (!response.ok) throw new Error("Failed to fetch products");

      const data = await response.json();
      this.products = data.data || [];
      this.renderProducts();
    } catch (error) {
      console.error("Error fetching products:", error);
      this.showNotification("Failed to load products", "error");
    }
  }

  renderProducts() {
    this.productsList.innerHTML = this.products
      .map(
        (product) => `
        <div class="border rounded-lg p-4 flex flex-col">
          <img src="${product.image_url}" alt="${
          product.name
        }" class="w-full h-32 object-cover rounded mb-2">
          <h4 class="font-semibold">${product.name}</h4>
          <p class="text-gray-600 text-sm mb-2">$${product.price}</p>
          <button 
            onclick="subscription.addToBox(${JSON.stringify(product).replace(
              /"/g,
              "&quot;"
            )})"
            class="mt-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
          >
            Add to Box
          </button>
        </div>
      `
      )
      .join("");
  }

  addToBox(product) {
    const existingItem = this.boxItems.find(
      (item) => item.product_id == product.product_id
    );

    if (existingItem) {
      existingItem.quantity += 1;
    } else {
      this.boxItems.push({ ...product, quantity: 1 });
    }

    this.renderBoxItems();
    this.updateTotal();
  }

  removeFromBox(itemId) {
    this.boxItems = this.boxItems.filter((item) => item.product_id != itemId);
    this.renderBoxItems();
    this.updateTotal();
  }

  updateQuantity(itemId, quantity) {
    const item = this.boxItems.find((item) => item.product_id == itemId);
    if (item) {
      item.quantity = parseInt(quantity);
      if (item.quantity <= 0) {
        this.removeFromBox(itemId);
      } else {
        this.renderBoxItems();
        this.updateTotal();
      }
    }
  }

  renderBoxItems() {
    if (this.boxItems.length === 0) {
      this.selectedProducts.classList.add("hidden");
      this.emptyMessage.classList.remove("hidden");
    } else {
      this.selectedProducts.classList.remove("hidden");
      this.emptyMessage.classList.add("hidden");

      this.selectedProducts.innerHTML = this.boxItems
        .map(
          (item) => `
          <div class="flex items-center justify-between p-4 border rounded-lg">
            <div class="flex items-center space-x-4">
              <img src="${item.image_url}" alt="${item.name}" class="w-16 h-16 object-cover rounded">
              <div>
                <h3 class="font-semibold">${item.name}</h3>
                <p class="text-gray-500">$${item.price}</p>
              </div>
            </div>
            <div class="flex items-center space-x-4">
              <input 
                type="number" 
                value="${item.quantity}" 
                min="1" 
                class="w-16 px-2 py-1 border rounded"
                onchange="subscription.updateQuantity(${item.product_id}, this.value)"
              >
              <button 
                onclick="subscription.removeFromBox(${item.product_id})"
                class="text-red-500 hover:text-red-700"
              >
                Remove
              </button>
            </div>
          </div>
        `
        )
        .join("");
    }
  }

  updateTotal() {
    console.log("updating total");
    const itemsTotal = this.boxItems.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
    console.log(itemsTotal);
    const total = itemsTotal + this.selectedPlan.price;
    this.totalElement.textContent = `$${total.toFixed(2)}`;
  }

  populateUserData() {
    const subscriberName = document.getElementById("subscriberName");
    const subscriberPhone = document.getElementById("subscriberPhone");
    const subscriberEmail = document.getElementById("subscriberEmail");
    const subscriberAddress = document.getElementById("subscriberAddress");

    if (this.userData) {
      subscriberName.value = this.userData.name || "";
      subscriberPhone.value = this.userData.phone || "";
      subscriberEmail.value = this.userData.email || "";
      subscriberAddress.value = this.userData.address || "";
    }
  }

  async openModal() {
    await this.fetchUserData();
    await this.fetchProducts();
    this.populateUserData();
    this.renderPlanDetails();
    this.renderBoxItems();
    this.updateTotal();
    this.modal.classList.remove("hidden");
  }

  renderPlanDetails() {
    this.planDetails.innerHTML = `
        <p class="mb-2"><strong>${this.selectedPlan.type} Plan</strong></p>
        <p>Duration: ${this.selectedPlan.duration}</p>
        <p>Base Price: $${this.selectedPlan.price}</p>
      `;
  }

  closeModal() {
    this.modal.classList.add("hidden");
    this.boxItems = [];
    this.selectedPlan = null;
  }

  async handleSubscription() {
    const formData = {
      name: document.getElementById("subscriberName").value,
      phone_number: document.getElementById("subscriberPhone").value,
      email: document.getElementById("subscriberEmail").value,
      address: document.getElementById("subscriberAddress").value,
      plan: this.selectedPlan,
      items: this.boxItems,
      total_amount: parseFloat(this.totalElement.textContent.replace("$", "")),
    };

    if (
      !formData.name ||
      !formData.phone_number ||
      !formData.email ||
      !formData.address
    ) {
      this.showNotification("Please fill all fields", "error");
      return;
    }

    // Here you would typically make an API call to save the subscription
    this.showNotification("Subscription confirmed successfully!");

    const startDate = new Date();
    const expiryDate = new Date(startDate);

    if (this.selectedPlan.type.toLowerCase() === "basic") {
      expiryDate.setMonth(expiryDate.getMonth() + 3);
    } else if (this.selectedPlan.type.toLowerCase() === "premium") {
      expiryDate.setMonth(expiryDate.getMonth() + 12);
    }

    // Prepare the data for the API call
    const subscriptionData = {
      user_id: this.userData.user_id,
      subscription_id: this.selectedPlan.type.toLowerCase() === "basic" ? 1 : 2,
      total_amount: formData.total_amount,
      duration: this.selectedPlan.duration,
      order_items: JSON.stringify(formData.items),
      start_date: startDate.toISOString(),
      expiry_date: expiryDate.toISOString(),
      customer_name: this.userData.name,
    };

    console.log(JSON.stringify(subscriptionData));

    try {
      const response = await fetch(
        "http://localhost/CB011999/public/api.php/save-subscription-box",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(subscriptionData),
        }
      );

      if (response.ok) {
        showNotification("Subscription successfully processed!");
      }
    } catch (error) {
      showNotification(
        "Error processing subscription: " + data.message,
        "error"
      );
    }

    this.closeModal();
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

const subscription = new Subscription();
