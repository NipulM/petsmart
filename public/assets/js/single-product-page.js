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
      existingItem.quantity += 1;
      alert("Item quantity increased in cart");
    } else {
      alert("Sorry, no more stock available for this item");
      return;
    }
  } else {
    cartItems.push({
      ...product,
      quantity: 1,
    });
    alert("Item added to cart");
  }
  saveCartItems(cartItems);

  const cartCount = document.getElementById("cartCount");
  if (cartCount) {
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
    cartCount.classList.remove("hidden");
  }
}
