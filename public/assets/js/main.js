// API URL
const fetchAllProducts =
  "http://localhost/CB011999/public/api.php/get-new-products";

const fetchAllSubscriptionPlans =
  "http://localhost/CB011999/public/api.php/get-subscription-plans";

async function fetchProducts() {
  try {
    const response = await fetch(fetchAllProducts);
    const data = await response.json();

    if (data.status === "success") {
      renderProducts(data.data);
    } else {
      displayError("No products found.");
    }
  } catch (error) {
    console.error("Error fetching products:", error);
    displayError("Failed to fetch products.");
  }
}

async function fetchSubscriptionPlans() {
  try {
    const response = await fetch(fetchAllSubscriptionPlans);
    const data = await response.json();

    if (data.status === "success") {
      renderSubscriptions(data.data);
    } else {
      displayError("No subscription plans found.");
    }
  } catch (error) {
    console.error("Error fetching subscription plans:", error);
    displayError("Failed to fetch subscription plans.");
  }
}

function renderProducts(products) {
  const productGrid = document.getElementById("product-grid");
  productGrid.innerHTML = "";

  products.forEach((product) => {
    const productCard = `
      <div class="bg-white shadow-md rounded-lg overflow-hidden flex-shrink-0 w-[450px] cursor-pointer hover:shadow-lg transition-shadow"
           onclick="window.location.href='../pages/single-product.php?id=${
             product.product_id
           }'">
        <img src="${product.image_url}" alt="${
      product.name
    }" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-xl font-bold mb-2">${product.name}</h3>
          <p class="text-gray-600 mb-4">${
            product.short_description || product.description
          }</p>
          <div class="flex justify-between items-center">
            <span class="text-green-500 font-bold">$${Number(
              product.price
            ).toFixed(2)}</span>
            <button 
              onclick="event.stopPropagation(); addToCart([${
                product.product_id
              }, ${product.price}, '${product.name}', '${product.image_url}', ${
      product.stock_quantity
    }, '${product.category}'])"
              class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
              Add to Cart
            </button>
          </div>
        </div>
      </div>
    `;
    productGrid.insertAdjacentHTML("beforeend", productCard);
  });
}

function renderSubscriptions(subscriptions) {
  // First, make sure we're selecting the correct element
  const subscriptionGrid = document.querySelector(".grid.grid-cols-2.gap-8");

  if (!subscriptionGrid) {
    console.error("Subscription grid element not found");
    return;
  }

  // Clear existing content
  subscriptionGrid.innerHTML = "";

  // Add each subscription
  subscriptions.forEach((subscription) => {
    // Parse features if they're stored as a string
    const features =
      typeof subscription.features === "string"
        ? JSON.parse(subscription.features)
        : subscription.features;

    // Create the features list HTML
    const featuresList = features
      .map(
        (feature) => `
        <li class="flex items-center mb-2">
          <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span>${feature}</span>
        </li>
      `
      )
      .join("");

    // Create a new div element for the subscription card
    const subscriptionCard = document.createElement("div");
    subscriptionCard.className =
      "bg-white shadow-md rounded-lg p-6 flex flex-col items-center text-center h-full";

    // Set the inner HTML of the card
    subscriptionCard.innerHTML = `
      <div class="h-48 w-full flex items-center justify-center overflow-hidden mb-4">
        <img src="${
          subscription.plan_type === "Basic"
            ? "../assets/images/basic-box.webp"
            : "../assets/images/premium-box.png"
        }" 
          alt="${subscription.plan_type} Subscription Box" 
          class="object-cover h-full w-full rounded-md">
      </div>
      <h3 class="text-2xl font-bold mb-4">${subscription.plan_type}</h3>
      <p class="text-gray-600 mb-6">${subscription.description}</p>
      <div class="flex-grow flex items-center justify-center mb-6">
        <ul class="text-left">
          ${featuresList}
        </ul>
      </div>
<button class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded">
        Subscribe to ${subscription.plan_type}
      </button>
    `;

    subscriptionGrid.appendChild(subscriptionCard);
  });
}

fetchProducts();
fetchSubscriptionPlans();

function displayError(message) {
  const productGrid = document.getElementById("product-grid");
  productGrid.innerHTML = `<p class="text-center text-gray-600">${message}</p>`;
}

function getCartItems() {
  const items = localStorage.getItem("cartItems");
  return items ? JSON.parse(items) : [];
}

function saveCartItems(items) {
  localStorage.setItem("cartItems", JSON.stringify(items));
}

function addToCart(productDetails) {
  // check if theres a isLogged in attribute in the local storage is true
  const isLoggedIn = localStorage.getItem("isLoggedIn");
  if (isLoggedIn !== "true") {
    showNotification("Please log in to add items to the cart", "error");
    return;
  }

  const itemQuantity = 1;
  if (!productDetails || !Array.isArray(productDetails)) {
    console.error("Invalid product details");
    return;
  }

  const [id, price, name, image, stockQuantity, category] = productDetails;
  console.log("here is the product details");
  console.log(id, price, name, image, stockQuantity, category);

  if (itemQuantity > stockQuantity) {
    showNotification("Sorry, no more stock available for this item", "error");
    return;
  }

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
