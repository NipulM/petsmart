const apiUrl = "http://localhost/CB011999/public/api.php/get-latest-blog";

async function fetchLatestBlog() {
  try {
    const response = await fetch(apiUrl);
    const data = await response.json();

    if (data.status === "success") {
      renderBlog(data.data);
    } else {
      displayError("No blog found.");
    }
  } catch (error) {
    console.error("Error fetching blog:", error);
    displayError("Failed to fetch blog.");
  }
}

function renderBlog(blog) {
  const blogContainer = document.getElementById("blog-container");
  blogContainer.innerHTML = "";

  [blog].forEach((blog) => {
    const blogCard = `<div class="flex w-full">
                <div class="w-2/5">
                <div class="relative w-full h-[300px] m-5">
                    <img src="${blog.image_url}" class="absolute top-0 left-0 w-full h-full object-cover rounded-2xl">
                </div>
                </div>
                <div class="w-3/5 p-12">
                    <h3 class="text-xl font-bold mb-4">${blog.title}</h3>
                    <p class="text-gray-700">${blog.content}</p>
                </div>
            </div>`;
    blogContainer.insertAdjacentHTML("beforeend", blogCard);
  });
}

function displayError(message) {
  const blogContainer = document.getElementById("blog-container");
  blogContainer.innerHTML = `<p class="text-center text-gray-600">${message}</p>`;
}

fetchLatestBlog();
