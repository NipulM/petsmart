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
      alert("Item quantity increased in cart");
    } else {
      alert("Sorry, no more stock available for this item");
      return;
    }
  } else {
    cartItems.push({
      ...product,
      quantity: itemQuantity,
    });
    alert("Item added to cart");
  }
  saveCartItems(cartItems);

  const cartCount = document.getElementById("cartCount");
  if (cartCount) {
    const totalItems = cartItems.length;
    cartCount.textContent = totalItems;
    cartCount.classList.remove("hidden");
  }
}
