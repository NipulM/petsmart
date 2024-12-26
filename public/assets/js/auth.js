document.addEventListener("DOMContentLoaded", () => {
  const mainContent = document.getElementById("main-content");

  const loginBtn = document.getElementById("loginBtn");
  const loginModal = document.getElementById("loginModal");

  const closeModal = document.getElementById("closeLoginModal");
  const loginForm = document.getElementById("loginForm");

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
    e.preventDefault();
    console.log("Login submitted");
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !loginModal.classList.contains("hidden")) {
      closeModalFn();
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const mainContent = document.getElementById("main-content");
  const loginBtn = document.getElementById("loginBtnRedirect");

  const loginModal = document.getElementById("loginModal");

  const registerModal = document.getElementById("registerModal");
  const closeRegisterModal = document.getElementById("closeRegisterModal");
  const registerForm = document.getElementById("registerForm");

  loginBtn.addEventListener("click", () => {
    registerModal.classList.add("hidden");
    loginModal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
  });

  // Close modal
  const closeModalFn = () => {
    registerModal.classList.add("hidden");
    mainContent.classList.remove("filter", "blur-sm", "bg-black/50");
    document.body.style.overflow = "auto";
  };

  closeRegisterModal.addEventListener("click", closeModalFn);

  loginModal.addEventListener("click", (e) => {
    if (e.target === loginModal.firstElementChild) {
      closeModalFn();
    }
  });

  registerForm.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log("Login submitted");
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !loginModal.classList.contains("hidden")) {
      closeModalFn();
    }
  });
});
