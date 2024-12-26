async function handleRegister(e) {
  e.preventDefault();
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  if (!name || !email || !password) {
    alert("Please fill all fields");
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
        alert("Registered successfully! Please login to continue");
        document.getElementById("registerForm").reset();
        document.getElementById("closeRegisterModal").click();
      } else {
        alert(data.message);
      }
    }
  } catch (error) {
    console.log(error);
  }
}

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
    handleRegister(e);
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !loginModal.classList.contains("hidden")) {
      closeModalFn();
    }
  });
});
