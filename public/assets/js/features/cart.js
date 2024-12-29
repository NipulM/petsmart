class Cart {
  constructor() {
    this.modal = document.getElementById("cartModal");
    this.cartIcon = document.getElementById("cartIcon");
    this.closeBtn = document.getElementById("closeCartModal");
    this.itemsContainer = document.getElementById("cartItems");
    this.emptyMessage = document.getElementById("emptyCartMessage");
    this.totalElement = document.getElementById("cartTotal");
    this.checkoutBtn = document.getElementById("checkoutBtn");

    this.userData = null;

    // Initialize items from localStorage
    this.loadItems();
    this.init();
  }

  loadItems() {
    this.items = JSON.parse(localStorage.getItem("cartItems")) || [];
  }

  init() {
    this.updateCartCount();
    this.cartIcon.addEventListener("click", () => this.openModal());
    this.closeBtn.addEventListener("click", () => this.closeModal());
    this.checkoutBtn.addEventListener("click", () => this.handleCheckout());

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

  popuplateUserData() {
    const customerName = document.getElementById("customerName");
    const customerPhone = document.getElementById("customerPhone");
    const customerEmail = document.getElementById("customerEmail");
    const customerAddress = document.getElementById("customerAddress");

    if (this.userData) {
      customerName.value = this.userData.name
        ? this.userData.name.charAt(0).toUpperCase() +
          this.userData.name.slice(1)
        : "";
      customerPhone.value = this.userData.phone || "";
      customerEmail.value = this.userData.email || "";
      customerAddress.value = this.userData.address || "";
    }
  }

  addItem(item) {
    this.loadItems();
    const existingItem = this.items.find((i) => i.id === item.id);

    if (existingItem) {
      existingItem.quantity += 1;
    } else {
      this.items.push({ ...item, quantity: 1 });
    }

    this.saveCart();
    this.updateCartCount();
  }

  removeItem(itemId) {
    this.loadItems();
    this.items = this.items.filter((item) => item.id !== itemId);
    this.saveCart();
    this.updateCartCount();
    this.renderItems();
  }

  updateQuantity(itemId, quantity) {
    this.loadItems();
    const item = this.items.find((i) => i.id === itemId);
    if (item) {
      item.quantity = parseInt(quantity);
      if (item.quantity <= 0) {
        this.removeItem(itemId);
      } else {
        this.saveCart();
        this.updateCartCount();
        this.renderItems();
      }
    }
  }

  saveCart() {
    localStorage.setItem("cartItems", JSON.stringify(this.items));
  }

  updateCartCount() {
    this.loadItems();
    const count = this.items.length;
    const cartCount = document.getElementById("cartCount");
    if (count > 0) {
      cartCount.textContent = count;
      cartCount.classList.remove("hidden");
    } else {
      cartCount.classList.add("hidden");
    }
  }

  calculateTotal() {
    this.loadItems();
    return this.items.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
  }

  renderItems() {
    this.loadItems();

    if (this.items.length === 0) {
      this.itemsContainer.classList.add("hidden");
      this.emptyMessage.classList.remove("hidden");
      this.checkoutBtn.disabled = true;
    } else {
      this.itemsContainer.classList.remove("hidden");
      this.emptyMessage.classList.add("hidden");
      this.checkoutBtn.disabled = false;

      this.itemsContainer.innerHTML = this.items
        .map(
          (item) => `
          <div class="flex items-center justify-between p-4 border-b">
            <div class="flex items-center space-x-4">
              <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded">
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
                onchange="cart.updateQuantity(${item.id}, this.value)"
              >
              <button 
                onclick="cart.removeItem(${item.id})"
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

    this.totalElement.textContent = `$${this.calculateTotal().toFixed(2)}`;
  }

  async openModal() {
    await this.fetchUserData();
    this.popuplateUserData();
    this.renderItems();
    this.modal.classList.remove("hidden");
  }

  closeModal() {
    this.modal.classList.add("hidden");
  }

  async handleCheckout() {
    this.loadItems();
    const formData = {
      name: document.getElementById("customerName").value,
      phone_number: document.getElementById("customerPhone").value,
      email: document.getElementById("customerEmail").value,
      address: document.getElementById("customerAddress").value,
      items: this.items,
      total_amount: this.calculateTotal(),
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

    await this.placeOrder(formData);

    this.items = [];
    this.saveCart();
    this.updateCartCount();
    this.closeModal();
    this.showNotification("Order placed successfully");
  }

  async placeOrder(data) {
    try {
      const response = await fetch(
        "http://localhost/CB011999/public/api.php/place-order",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        }
      );

      if (!response.ok) throw new Error("Failed to place order");
      const responseData = await response.json();
    } catch (error) {
      console.error("Error placing order:", error);
      this.showNotification("Failed to place order", "error");
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

const cart = new Cart();
