const adminDashboard = document.getElementById("admin-dashboard");

document.getElementById("loginForm").addEventListener("submit", async (e) => {
  e.preventDefault();
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  try {
    const response = await fetch(
      "http://localhost/CB011999/public/api.php/admin-login",
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password }),
      }
    );

    if (response.ok) {
      const data = await response.json();
      document.cookie = `adminSession=${data.data.token}; path=/; secure; samesite=strict`;
      window.location.href = "../admin/dashboard.php";
      adminDashboard.classList.remove("hidden");
    } else {
      throw new Error("Invalid credentials");
    }
  } catch (error) {
    document.getElementById("errorMessage").textContent = error.message;
    document.getElementById("errorMessage").classList.remove("hidden");
  }
});
