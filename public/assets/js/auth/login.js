// Get DOM elements
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
    alert("Please fill all fields");
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
        alert("Logged in successfully!");
        document.getElementById("loginForm").reset();
        document.getElementById("closeLoginModal").click();

        toggleAuthDisplay(true);
      } else {
        alert(data.message);
      }
    }
  } catch (error) {
    console.log(error);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
  toggleAuthDisplay(isLoggedIn);

  const mainContent = document.getElementById("main-content");
  console.log(mainContent);

  const loginBtn = document.getElementById("loginBtn");
  console.log("login btn", loginBtn);
  const loginModal = document.getElementById("loginModal");
  console.log("login modal", loginModal);

  const closeModal = document.getElementById("closeLoginModal");
  console.log("close modal", closeModal);
  const loginForm = document.getElementById("loginForm");
  console.log("login form", loginForm);

  const registerBtn = document.getElementById("registerBtnRedirect");

  const registerModal = document.getElementById("registerModal");

  // Open modal
  loginBtn.addEventListener("click", () => {
    loginModal.classList.remove("hidden");
    mainContent.classList.add("filter", "blur-sm");
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
    mainContent.classList.remove("filter", "blur-sm");
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
