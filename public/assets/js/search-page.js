const API_ENDPOINTS = {
  FILTER_CATEGORIES: "http://localhost/CB011999/public/api.php/filter-products",
  CATEGORIES: "http://localhost/CB011999/public/api.php/get-all-categories",
  PRODUCTS: "http://localhost/cb011999/public/api.php/get-all-products",
};

function renderItems(products) {
  const productGrid = document.getElementById("filtered-products");
  productGrid.innerHTML = "";

  products.forEach((product) => {
    console.log(product);
    const productCard = `
                    <div class="bg-white p-4 cursor-pointer hover:shadow-lg transition-shadow rounded shadow" 
                       onclick="window.location.href='../pages/single-product.php?id=${product.product_id}'"
                      >
                        <div class="h-48 w-full flex items-center justify-center overflow-hidden mb-4">
                            <img src=${product.image_url}/>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-xl font-semibold mb-2">${product.name}</h3>
                            <p class="text-gray-600">${product.short_description}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold">$${product.price}</span>
                            <button 
                              onclick="window.location.href='../pages/single-product.php?id=${product.product_id}'"
                              class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                              Add to Cart
                            </button>
                        </div>
                    </div>
    `;
    productGrid.insertAdjacentHTML("beforeend", productCard);
  });
}

async function fetchCategories() {
  try {
    const response = await fetch(API_ENDPOINTS.CATEGORIES);
    const data = await response.json();

    if (data.status === "success") {
      renderCategoryOptions(data.data);
      renderInitialState();
    } else {
      displayError("No categories found.");
    }
  } catch (error) {
    console.error("Error fetching categories:", error);
    displayError("Failed to fetch categories.");
  }
}

async function renderInitialState() {
  const resultsTitle = document.getElementById("results-title");
  resultsTitle.textContent = "";

  const allProducts = await fetchAllProducts();
  const randomItems = selectRandomItems(allProducts, 2);

  resultsTitle.insertAdjacentHTML(
    "beforeend",
    `<h2 class="text-xl font-semibold mb-6">Random Picks for You (${randomItems.length})</h2>`
  );

  renderItems(randomItems);
}

function selectRandomItems(array, count) {
  const shuffled = [...array].sort(() => 0.5 - Math.random());
  return shuffled.slice(0, count);
}

async function fetchAllProducts() {
  try {
    const response = await fetch(API_ENDPOINTS.PRODUCTS);
    const data = await response.json();

    if (data.status === "success") {
      return data.data;
    } else {
      displayError("No products found.");
    }
  } catch (error) {
    console.error("Error fetching products:", error);
    displayError("Failed to fetch products.");
  }
}

async function applyFilters() {
  const filters = {
    category_id: document.getElementById("category-select").value,
    price_range: document.getElementById("price-select").value,
  };

  let queryString = "?";
  let params = [];

  if (filters.category_id && filters.category_id !== "default") {
    params.push(`category=${filters.category_id}`);
  }

  if (filters.price_range && filters.price_range !== "default") {
    const [minPrice, maxPrice] = filters.price_range.split("-");
    params.push(`minPrice=${minPrice}`);
    params.push(`maxPrice=${maxPrice}`);
  }

  queryString += params.join("&");

  const response = await fetch(API_ENDPOINTS.FILTER_CATEGORIES + queryString);
  const data = await response.json();

  const resultsTitle = document.getElementById("results-title");
  resultsTitle.textContent = "";

  resultsTitle.insertAdjacentHTML(
    "beforeend",
    `<h2 class="text-xl font-semibold mb-6">Filtered Items (${data.data.length})</h2>`
  );

  renderItems(data.data);
}

async function getAllItems() {
  const products = await fetchAllProducts();
  console.log(products);

  const categorySelect = document.getElementById("category-select");
  const priceRangeSelect = document.getElementById("price-select");

  categorySelect.selectedIndex = 0;
  priceRangeSelect.selectedIndex = 0;

  const resultsTitle = document.getElementById("results-title");
  resultsTitle.textContent = "";

  resultsTitle.insertAdjacentHTML(
    "beforeend",
    `<h2 class="text-xl font-semibold mb-6">All Items (${products.length})</h2>`
  );

  renderItems(products);
}

function renderCategoryOptions(categories) {
  const categorySelect = document.getElementById("category-select");

  categories.forEach((category) => {
    const categoryOption = `
      <option value="${category.category_id}">${category.name}</option>
    `;
    categorySelect.insertAdjacentHTML("beforeend", categoryOption);
  });
}

function clearFilters() {
  const categorySelect = document.getElementById("category-select");
  const priceRangeSelect = document.getElementById("price-select");

  categorySelect.selectedIndex = 0;
  priceRangeSelect.selectedIndex = 0;
}

fetchCategories();
