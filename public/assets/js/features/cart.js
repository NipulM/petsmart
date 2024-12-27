class Cart {
  constructor() {
    this.items = JSON.parse(localStorage.getItem("cartItems")) || [];
    this.modal = document.getElementById("cartModal");
    this.cartIcon = document.getElementById("cart-icon");
    this.closeBtn = document.getElementById("closeCartModal");
    this.itemsContainer = document.getElementById("cartItems");
    this.emptyMessage = document.getElementById("emptyCartMessage");
    this.totalElement = document.getElementById("cartTotal");
    this.checkoutBtn = document.getElementById("checkoutBtn");

    this.init();
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

  removeItem(itemId) {
    this.items = this.items.filter((item) => item.id !== itemId);
    this.saveCart();
    this.updateCartCount();
    this.renderItems();
  }

  updateQuantity(itemId, quantity) {
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
    return this.items.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
  }

  renderItems() {
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

  openModal() {
    this.renderItems();
    this.modal.classList.remove("hidden");
  }

  closeModal() {
    this.modal.classList.add("hidden");
  }

  async handleCheckout() {
    const formData = {
      name: document.getElementById("customerName").value,
      phone: document.getElementById("customerPhone").value,
      email: document.getElementById("customerEmail").value,
      address: document.getElementById("customerAddress").value,
      items: this.items,
      total: this.calculateTotal(),
    };

    if (
      !formData.name ||
      !formData.phone ||
      !formData.email ||
      !formData.address
    ) {
      alert("Please fill in all contact information");
      return;
    }

    console.log("Checkout data:", formData);
    this.items = [];
    this.saveCart();
    this.updateCartCount();
    this.closeModal();
    alert("Order placed successfully!");
  }
}

const cart = new Cart();
