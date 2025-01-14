function checkAuth() {
  const adminSession = document.cookie
    .split("; ")
    .find((row) => row.startsWith("adminSession="))
    ?.split("=")[1];

  if (!adminSession) {
    window.location.href = "../admin/login.php";
    return;
  }

  fetch("http://localhost/CB011999/public/api.php/validate-token", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      token: adminSession,
      role: "admin",
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "error") {
        window.location.href = "../admin/login.php";
      }
    })
    .catch(() => {
      window.location.href = "../admin/login.php";
    });

  document.getElementById("admin-dashboard").classList.remove("hidden");
}

checkAuth();

const productsContainer = document.getElementById("products-container");
const ordersContainer = document.getElementById("orders-container");
const categoriesContainer = document.getElementById("add-new-category");
const blogContainer = document.getElementById("blog-container");
const logoutBtn = document.getElementById("logout-btn");

logoutBtn.addEventListener("click", () => {
  document.cookie =
    "adminSession=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";

  window.location.href = "../admin/login.php";
});

document.addEventListener("DOMContentLoaded", () => {
  loadDashboardStats();
  loadCharts();
});

async function loadDashboardStats() {
  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/get-admin-dashboard-stats"
    );
    const data = await response.json();
    const statsData = data.data.stats;

    document.getElementById("total-orders").textContent =
      statsData.total_orders;
    document.getElementById("pending-orders").textContent =
      statsData.pending_orders;
    document.getElementById("total-products").textContent =
      statsData.total_products;
    document.getElementById(
      "total-revenue"
    ).textContent = `$${statsData.total_revenue}`;

    const ordersHTML = statsData.latest_orders
      .map(
        (order) => `
        <tr class="border-b">
          <td class="py-2">#${order.order_id}</td>
          <td>${order.customer_name}</td>
          <td>
            <span class="px-2 py-1 ${getStatusColor(
              order.status
            )} rounded-full text-sm">
              ${order.status}
            </span>
          </td>
          <td>$${order.total_amount}</td>
        </tr>
      `
      )
      .join("");

    document.getElementById("recent-orders-table").innerHTML = ordersHTML;
  } catch (error) {
    console.error("Error loading dashboard stats:", error);
  }
}

function getStatusColor(status) {
  switch (status.toLowerCase()) {
    case "pending":
      return "bg-yellow-100 text-yellow-800";
    case "delivered":
    case "completed":
      return "bg-green-100 text-green-800";
    case "processing":
      return "bg-blue-100 text-blue-800";
    case "cancelled":
      return "bg-red-100 text-red-800";
    default:
      return "bg-gray-100 text-gray-800";
  }
}

async function loadCharts() {
  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/get-admin-dashboard-stats"
    );
    const data = await response.json();
    const chartData = data.data.chartData;

    const productValues = chartData.products_by_category.map((product) =>
      parseInt(product.total_products, 10)
    );
    const productLabels = chartData.products_by_category.map(
      (product) => product.category
    );

    const productData = {
      values: productValues,
      labels: productLabels,
      type: "pie",
    };

    Plotly.newPlot("productsPieChart", [productData], {
      margin: { t: 0, b: 0, l: 0, r: 0 },
      showlegend: true,
      legend: { orientation: "h", y: -0.1 },
    });

    const orderValues = chartData.orders_by_status.map((order) =>
      parseInt(order.total_orders, 10)
    );
    const orderLabels = chartData.orders_by_status.map((order) => order.status);

    const orderData = {
      values: orderValues,
      labels: orderLabels,
      type: "pie",
    };

    Plotly.newPlot("ordersPieChart", [orderData], {
      margin: { t: 0, b: 0, l: 0, r: 0 },
      showlegend: true,
      legend: { orientation: "h", y: -0.1 },
    });
  } catch (error) {
    console.error("Error loading chart data:", error);
  }
}

async function loadProducts(categoryId = null) {
  try {
    let url = "";
    if (categoryId && !isNaN(categoryId)) {
      url = `http://localhost/CB011999/public/api.php/filter-products?category=${categoryId}`;
      if (categoryId === "all") {
        url = "http://localhost/CB011999/public/api.php/get-all-products";
      }
    } else {
      url = "http://localhost/CB011999/public/api.php/get-all-products";
    }

    const response = await fetch(url);
    const data = await response.json();
    const products = data.data;

    if (products.length === 0) {
      document.getElementById("item-container").innerHTML = `
          <div class="bg-white p-4 rounded-lg shadow">
              <p class="text-gray-600">No products found.</p>
          </div>
      `;
      return;
    }

    productsContainer.innerHTML = `
        <div class="flex items-center gap-4 mb-6 bg-white p-4 rounded-lg shadow">
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Category</label>
            <select 
              id="categoryFilter"
              name="category" 
              class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              required
            >
              <option value="">All Categories</option>
            </select>
          </div>
          <button onclick="openProductModal()" 
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 h-[38px] mt-6">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
              Add New Product
          </button>
        </div>
        <div id="item-container">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                ${products
                  .map(
                    (product) => `
                    <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                        <img src="${product.image_url}" alt="${product.name}" class="w-full h-36 object-cover rounded mb-4">
                        <h3 class="font-semibold text-lg mb-2">${product.name}</h3>
                        <p class="text-gray-600 font-bold mb-1">$${product.price}</p>
                        <p class="text-sm text-gray-500 mb-3">Stock: ${product.stock_quantity}</p>
                        <button onclick="openProductModal(${product.product_id})" 
                                class="w-full bg-white border border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-50 transition-colors duration-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </button>
                    </div>
                `
                  )
                  .join("")}
            </div>
        </div>
      `;

    await loadCategoryOptions();
    const categorySelect = document.getElementById("categoryFilter");
    if (categorySelect) {
      categorySelect.value = categoryId || "";

      categorySelect.addEventListener("change", (e) => {
        const value = e.target.value;
        e.preventDefault();
        loadProducts(value ? parseInt(value) : null);
      });
    }
  } catch (error) {
    console.error("Error loading products:", error);
  }
}

async function openProductModal(productId = null) {
  const modalHTML = `
        <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-full max-w-2xl max-h-[80vh] overflow-y-auto">
                <h2 class="text-xl font-bold mb-4">${
                  productId ? "Edit" : "Add"
                } Product</h2>
                <form id="productForm" class="space-y-4">
                    <input type="hidden" name="product_id" value="${
                      productId || ""
                    }">
                    
                    <div>
                        <label class="block mb-1">Name</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required>
                    </div>
                    
                    <div>
                        <label class="block mb-1">Price</label>
                        <input type="number" name="price" step="0.01" class="w-full border p-2 rounded" required>
                    </div>
                    
                    <div>
                        <label class="block mb-1">Stock</label>
                        <input type="number" name="stock_quantity" class="w-full border p-2 rounded" required>
                    </div>
                    
                    <div>
                        <label class="block mb-1">Category</label>
                        <select name="category" class="w-full border p-2 rounded">
                        </select>
                    </div>
                    
                    <div>
                        <label class="block mb-1">Description</label>
                        <textarea name="description" class="w-full border p-2 rounded" rows="3" required></textarea>
                    </div>

                    <div>
                        <label class="block mb-1">Short Description</label>
                        <input type="text" name="short_description" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block mb-1">Seasonal?</label>
                        <select name="is_seasonal" class="w-full border p-2 rounded" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1">New Item?</label>
                        <select name="is_new" class="w-full border p-2 rounded" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1">Image Url</label>
                        <input type="text" name="image_url" accept="image/*" class="w-full border p-2 rounded">
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal('productModal')" 
                                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;

  document.body.insertAdjacentHTML("beforeend", modalHTML);

  await loadCategoryOptionsForModal("#productModal");
  if (productId) {
    const response = await fetch(
      `http://localhost/CB011999/public/api.php/get-product-by-id?id=${productId}`
    );
    const data = await response.json();
    const product = data.data;

    const form = document.getElementById("productForm");
    Object.keys(product).forEach((key) => {
      const input = form.elements[key];
      if (input) input.value = product[key];
    });
  }
  document
    .getElementById("productForm")
    .addEventListener("submit", handleProductSubmit);
}

async function loadCategoryOptions() {
  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/get-all-categories"
    );
    const data = await response.json();
    const categories = data.data;

    const selectElement = document.querySelector(`select[name="category"]`);
    const categoryOptions =
      `<option value="all">All Items</option>` +
      categories
        .map(
          (category) =>
            `<option value="${category.category_id}">${category.name}</option>`
        )
        .join("");

    selectElement.innerHTML = categoryOptions;
  } catch (error) {
    console.error("Error loading categories:", error);
  }
}

async function loadCategoryOptionsForModal(modal) {
  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/get-all-categories"
    );
    const data = await response.json();
    const categories = data.data;

    const selectElement = document.querySelector(
      `${modal} select[name="category"]`
    );

    const categoryOptions = categories
      .map(
        (category) =>
          `<option value="${category.category_id}">${category.name}</option>`
      )
      .join("");

    selectElement.innerHTML = categoryOptions;
  } catch (error) {
    console.error("Error loading categories:", error);
  }
}

async function handleProductSubmit(e) {
  e.preventDefault();

  const formData = new FormData(e.target);
  const productData = {
    product_id: +formData.get("product_id")
      ? +formData.get("product_id")
      : null,
    name: formData.get("name"),
    price: parseFloat(formData.get("price")).toFixed(2),
    stock_quantity: +formData.get("stock_quantity"),
    category_id: +formData.get("category"),
    description: formData.get("description"),
    short_description: formData.get("short_description"),
    is_seasonal: +formData.get("is_seasonal"),
    is_new: +formData.get("is_new"),
    image_url: formData.get("image_url"),
  };

  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/save-product",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(productData),
      }
    );
    if (response.ok) {
      closeModal();
      loadProducts();
    }
  } catch (error) {
    console.error("Error saving product:", error);
  }
}

async function loadCategories() {
  const response = await fetch(
    "http://localhost/CB011999/public/api.php/get-admin-dashboard-stats"
  );

  const data = await response.json();
  const categories = data.data.chartData.products_by_category;

  const xArray = categories.map((category) => category.category);
  const yArray = categories.map((category) =>
    parseInt(category.total_products, 10)
  );

  const chartData = [
    {
      x: xArray,
      y: yArray,
      type: "bar",
      orientation: "v",
      marker: { color: "rgba(0,0,255)" },
    },
  ];

  const layout = { title: "Products by Category" };

  Plotly.newPlot("productsBarChart", chartData, layout);

  const addNewCategoryBtn = `
              <button onclick="openCategoryModal()" 
                    class="mb-4 bg-green-600 border border-transparent text-sm font-medium rounded-md shadow-sm text-white px-4 py-2 hover:bg-green-700">
                Add New Category
            </button>
  `;

  categoriesContainer.innerHTML = addNewCategoryBtn;
}

async function openCategoryModal() {
  const modalHTML = `
            <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg w-full max-w-2xl max-h-[80vh] overflow-y-auto">
                    <h2 class="text-xl font-bold mb-4">Add Category</h2>
                    <form id="categoryForm" class="space-y-4">
                        <div>
                            <label class="block mb-1">Name</label>
                            <input type="text" name="name" class="w-full border p-2 rounded" required>
                        </div>

                        <div>
                            <label class="block mb-1">Description</label>
                            <input type="text" name="description" class="w-full border p-2 rounded" required>
                        </div>
                        
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeModal('categoryModal')" 
                                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;

  document.body.insertAdjacentHTML("beforeend", modalHTML);

  document
    .getElementById("categoryForm")
    .addEventListener("submit", handleCategorySubmit);
}

async function handleCategorySubmit(e) {
  e.preventDefault();

  const formData = new FormData(e.target);

  const categoryData = {
    name: formData.get("name"),
    description: formData.get("description"),
  };

  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/add-category",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(categoryData),
      }
    );

    if (response.ok) {
      closeModal();
      loadCategories();
    }
  } catch (error) {
    console.error("Error saving category:", error);
  }
}

async function loadOrders() {
  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/get-all-orders"
    );
    const orders = await response.json();

    ordersContainer.innerHTML = orders
      .map(
        (order) => `
          <div class="bg-white p-4 rounded-lg mb-4 shadow-sm hover:shadow-md cursor-pointer transition-shadow" 
               onclick='showOrderDetails(${JSON.stringify(order).replace(
                 /'/g,
                 "&apos;"
               )})'>
              <div class="flex justify-between items-center">
                  <div>
                      <h3 class="font-semibold">Order #${order.order_id}</h3>
                      <p class="text-gray-600">${order.name}</p>
                      <p class="text-sm text-gray-500">${order.created_at}</p>
                  </div>
                  <div onclick="event.stopPropagation()">
                      <select onchange="updateOrderStatus(${
                        order.order_id
                      }, this.value)" 
                              class="border p-2 rounded">
                          <option value="pending" ${
                            order.status === "pending" ? "selected" : ""
                          }>Pending</option>
                          <option value="processing" ${
                            order.status === "processing" ? "selected" : ""
                          }>Processing</option>
                          <option value="completed" ${
                            order.status === "completed" ? "selected" : ""
                          }>Completed</option>
                          <option value="cancelled" ${
                            order.status === "cancelled" ? "selected" : ""
                          }>Cancelled</option>
                      </select>
                  </div>
              </div>
          </div>
      `
      )
      .join("");
  } catch (error) {
    console.error("Error loading orders:", error);
  }
}

function showOrderDetails(order) {
  if (typeof order.order_items === "string") {
    order.order_items = JSON.parse(order.order_items);
  }

  console.log(order.order_items);

  const modalHTML = `
    <div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg w-full max-w-4xl max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold">Order Details #${order.order_id}</h2>
          <button onclick="closeModal('orderDetailsModal')" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
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

          <div class="text-sm text-gray-500 mt-2">
            <span>Order Date:</span>
            <span class="ml-2">${order.created_at}</span>
          </div>
        </div>
      </div>
    </div>
  `;

  document.body.insertAdjacentHTML("beforeend", modalHTML);
}

async function updateOrderStatus(orderId, status) {
  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/update-order-status",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ order_id: orderId, status: status }),
      }
    );

    if (response.ok) {
      loadOrders();
    }
  } catch (error) {
    console.error("Error updating order status:", error);
  }
}

async function loadBlogs() {
  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/get-all-blogs"
    );
    const data = await response.json();
    const blogs = data.data;

    blogContainer.innerHTML = `
            <button onclick="openBlogModal()" 
                    class="mb-4 bg-green-600 border border-transparent text-sm font-medium rounded-md shadow-sm text-white px-4 py-2 hover:bg-green-700">
                Add New Blog
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                ${blogs
                  .map(
                    (blog) => `
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="font-semibold">${blog.title}</h3>
                        <p class="text-gray-600">${blog.content
                          .split(" ")
                          .slice(0, 20)
                          .join(" ")}...</p>
                        <button onclick="openBlogModal(${blog.blog_id})" 
                                class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Edit
                        </button>
                    </div>
                `
                  )
                  .join("")}
            </div>
        `;
  } catch (error) {
    console.error("Error loading blogs:", error);
  }
}

async function openBlogModal(blogId = null) {
  const modalHTML = `
        <div id="blogModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-full max-w-2xl max-h-[80vh] overflow-y-auto">
                <h2 class="text-xl font-bold mb-4">${
                  blogId ? "Edit" : "Add"
                } Blog Post</h2>
                <form id="blogForm" class="space-y-4">
                    <input type="hidden" name="blog_id" value="${blogId || ""}">
                    
                    <div>
                        <label class="block mb-1">Title</label>
                        <input type="text" name="title" class="w-full border p-2 rounded" required>
                    </div>
                    
                    <div>
                        <label class="block mb-1">Content</label>
                        <textarea name="content" class="w-full border p-2 rounded" rows="6" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block mb-1">Featured Image Url</label>
                        <input type="text" name="image_url" class="w-full border p-2 rounded" required>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal('blogModal')" 
                                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;

  document.body.insertAdjacentHTML("beforeend", modalHTML);

  if (blogId) {
    const response = await fetch(
      `http://localhost/CB011999/public/api.php/get-blog-by-id?id=${blogId}`
    );
    const data = await response.json();
    const blog = data.data;

    const form = document.getElementById("blogForm");
    Object.keys(blog).forEach((key) => {
      const input = form.elements[key];
      if (input) input.value = blog[key];
    });
  }

  document
    .getElementById("blogForm")
    .addEventListener("submit", handleBlogSubmit);
}

async function handleBlogSubmit(e) {
  e.preventDefault();

  const formData = new FormData(e.target);
  const blogData = {
    blog_id: +formData.get("blog_id") ? +formData.get("blog_id") : null,
    title: formData.get("title"),
    content: formData.get("content"),
    image_url: formData.get("image_url"),
  };

  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/save-blog",
      {
        method: "POST",
        body: JSON.stringify(blogData),
      }
    );

    if (response.ok) {
      closeModal();
      loadBlogs();
    }
  } catch (error) {
    console.error("Error saving blog:", error);
  }
}

function closeModal(modalId) {
  document.getElementById(modalId).remove();
}

function showSection(sectionId) {
  const sections = [
    "dashboard-content",
    "products-container",
    "orders-container",
    "categories-container",
    "blog-container",
  ];

  sections.forEach((section) => {
    document.getElementById(section).classList.add("hidden");
  });

  // Show selected section
  document.getElementById(sectionId).classList.remove("hidden");

  // Update active navigation
  const links = document.querySelectorAll("nav a");
  links.forEach((link) => {
    link.classList.remove("bg-gray-100");
    link.classList.add("hover:bg-gray-100");
  });
  document
    .querySelector(`a[href="#${sectionId.split("-")[0]}"]`)
    .classList.add("bg-gray-100");
}

// Add click handlers for navigation
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("dashboard-link").addEventListener("click", (e) => {
    e.preventDefault();
    showSection("dashboard-content");
    loadDashboardStats();
    loadCharts();
  });

  document.getElementById("products-link").addEventListener("click", (e) => {
    e.preventDefault();
    showSection("products-container");
    loadProducts();
  });

  document.getElementById("orders-link").addEventListener("click", (e) => {
    e.preventDefault();
    showSection("orders-container");
    loadOrders();
  });

  document.getElementById("categories-link").addEventListener("click", (e) => {
    e.preventDefault();
    showSection("categories-container");
  });

  document.getElementById("blogs-link").addEventListener("click", (e) => {
    e.preventDefault();
    showSection("blog-container");
    loadBlogs();
  });

  document.getElementById("categories-link").addEventListener("click", (e) => {
    e.preventDefault();
    showSection("categories-container");
  });
});

document.addEventListener("DOMContentLoaded", () => {
  loadDashboardStats();
  loadCharts();

  document
    .querySelector('a[href="#products"]')
    .addEventListener("click", loadProducts);
  document
    .querySelector('a[href="#orders"]')
    .addEventListener("click", loadOrders);
  document
    .querySelector('a[href="#blogs"]')
    .addEventListener("click", loadBlogs);
  document
    .querySelector('a[href="#categories"]')
    .addEventListener("click", loadCategories);
});
