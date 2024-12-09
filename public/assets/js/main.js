// API URL

const apiUrl = "http://localhost/cb011999/routes.php/get-all-products";

async function fetchProducts() {
  try {
    const response = await fetch(apiUrl);
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

function renderProducts(products) {
  const productGrid = document.getElementById("product-grid");
  productGrid.innerHTML = "";

  products.forEach((product) => {
    const productCard = `
                    <div class="bg-white shadow-md rounded-lg overflow-hidden flex-shrink-0 w-[450px]">
                      <img src="${product.image}" alt="${
      product.name
    }" class="w-full h-48 object-cover">
                      <div class="p-4">
                        <h3 class="text-xl font-bold mb-2">${product.name}</h3>
                        <p class="text-gray-600 mb-4">${product.description}</p>
                        <div class="flex justify-between items-center">
                          <span class="text-green-500 font-bold">$${Number(
                            product.price
                          ).toFixed(2)}</span>
                          <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Add to Cart</button>
                        </div>
                      </div>
                    </div>
                  `;
    productGrid.insertAdjacentHTML("beforeend", productCard);
  });
}

function displayError(message) {
  const productGrid = document.getElementById("product-grid");
  productGrid.innerHTML = `<p class="text-center text-gray-600">${message}</p>`;
}

fetchProducts();
