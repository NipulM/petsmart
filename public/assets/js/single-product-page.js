function getItemQuantity() {
  const input = document.getElementById("quantity");
  return parseInt(input.value);
}

function updateQuantity(change) {
  const input = document.getElementById("quantity");
  const newValue = Math.max(1, parseInt(input.value) + change);
  input.value = newValue;
}

function getCartItems() {
  const items = localStorage.getItem("cartItems");
  return items ? JSON.parse(items) : [];
}

function saveCartItems(items) {
  localStorage.setItem("cartItems", JSON.stringify(items));
}

function addToCart(productDetails) {
  const itemQuantity = getItemQuantity();
  if (!productDetails || !Array.isArray(productDetails)) {
    console.error("Invalid product details");
    return;
  }

  const [id, price, name, image, stockQuantity, category] = productDetails;

  const product = {
    id: parseInt(id),
    price: parseFloat(price),
    name: name,
    image: image,
    stockQuantity: parseInt(stockQuantity),
    category: category,
  };

  let cartItems = getCartItems();
  const existingItem = cartItems.find((item) => item.id === product.id);

  if (existingItem) {
    if (existingItem.quantity < product.stockQuantity) {
      existingItem.quantity += itemQuantity;
      showNotification("Item quantity increased in cart");
    } else {
      showNotification("Sorry, no more stock available for this item", "error");
      return;
    }
  } else {
    cartItems.push({
      ...product,
      quantity: itemQuantity,
    });
    showNotification("Item added to cart");
  }
  saveCartItems(cartItems);

  const cartCount = document.getElementById("cartCount");
  if (cartCount) {
    const totalItems = cartItems.length;
    cartCount.textContent = totalItems;
    cartCount.classList.remove("hidden");
  }
}

function showNotification(message, type = "success") {
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
