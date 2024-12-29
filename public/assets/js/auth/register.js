async function handleRegister(e) {
  e.preventDefault();
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  if (!name || !email || !password) {
    showNotification("Please fill all fields", "error");
    return;
  }

  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/register",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ name, email, password }),
      }
    );

    if (response.ok) {
      const data = await response.json();
      if (data.status === "success") {
        showNotification("Registered successfully! Please login to continue");
        document.getElementById("registerForm").reset();
        document.getElementById("closeRegisterModal").click();
      } else {
        showNotification(data.message, "error");
      }
    }
  } catch (error) {
    console.error(error);
  }
}

document.addEventListener("DOMContentLoaded", () => {
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
    document.body.style.overflow = "auto";
  };

  closeRegisterModal.addEventListener("click", closeModalFn);

  loginModal.addEventListener("click", (e) => {
    if (e.target === loginModal.firstElementChild) {
      closeModalFn();
    }
  });

  registerForm.addEventListener("submit", (e) => {
    handleRegister(e);
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
