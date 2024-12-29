const loginBtn = document.getElementById("loginBtn");
const iconsContainer = document.getElementById("iconsContainer");
const cartCount = document.getElementById("cartCount");

// Function to toggle between login and icons
function toggleAuthDisplay(isLoggedIn) {
  if (isLoggedIn) {
    loginBtn.style.display = "none";
    iconsContainer.classList.remove("hidden");
    iconsContainer.classList.add("flex");
    localStorage.setItem("isLoggedIn", "true");
  } else {
    loginBtn.style.display = "block";
    iconsContainer.classList.add("hidden");
    iconsContainer.classList.remove("flex");
    localStorage.setItem("isLoggedIn", "false");
  }
}

// Function to update cart count
function updateCartCount(count) {
  cartCount.textContent = count;
  cartCount.classList.toggle("hidden", count === 0);
}

// Modified handleLogin function
async function handleLogin(e) {
  e.preventDefault();
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  if (!email || !password) {
    showNotification("Please fill all fields", "error");
    return;
  }

  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/login",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      }
    );

    if (response.ok) {
      const data = await response.json();
      if (data.status === "success") {
        document.cookie = `session_token=${
          data.data.token
        }; path=/; expires=${new Date(
          data.data.expires_at * 1000
        ).toUTCString()}`;

        showNotification("Logged in successfully!");
        document.getElementById("loginForm").reset();
        document.getElementById("closeLoginModal").click();

        toggleAuthDisplay(true);
      } else {
        showNotification(data.message, "error");
      }
    }
  } catch (error) {
    console.error(error);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
  toggleAuthDisplay(isLoggedIn);
  const loginModal = document.getElementById("loginModal");

  const closeModal = document.getElementById("closeLoginModal");
  const loginForm = document.getElementById("loginForm");

  const registerBtn = document.getElementById("registerBtnRedirect");

  const registerModal = document.getElementById("registerModal");

  // Open modal
  loginBtn.addEventListener("click", () => {
    loginModal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
  });

  registerBtn.addEventListener("click", () => {
    loginModal.classList.add("hidden");
    registerModal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
  });

  // Close modal
  const closeModalFn = () => {
    loginModal.classList.add("hidden");
    document.body.style.overflow = "auto";
  };

  closeModal.addEventListener("click", closeModalFn);

  loginModal.addEventListener("click", (e) => {
    if (e.target === loginModal.firstElementChild) {
      closeModalFn();
    }
  });

  loginForm.addEventListener("submit", (e) => {
    handleLogin(e);
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !loginModal.classList.contains("hidden")) {
      closeModalFn();
    }
  });
});

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
