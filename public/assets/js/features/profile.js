class Profile {
  constructor() {
    // Modal elements
    this.modal = document.getElementById("profileModal");
    this.profileIcon = document.getElementById("profileIcon");
    this.closeBtn = document.getElementById("closeProfileModal");

    // Tab elements
    this.tabs = document.querySelectorAll(".tab-btn");
    this.tabContents = document.querySelectorAll(".tab-content");

    // Save button
    this.saveBtn = this.modal.querySelector('button[class*="bg-blue-600"]');

    // User data
    this.userData = null;

    this.init();
  }

  init() {
    // Modal controls
    this.profileIcon.addEventListener("click", async () => {
      this.showLoader();
      await this.openModal();
    });
    this.closeBtn.addEventListener("click", () => this.closeModal());
    this.modal.addEventListener("click", (e) => this.handleOutsideClick(e));

    // Tab switching
    this.tabs.forEach((tab) => {
      tab.addEventListener("click", () => this.switchTab(tab));
    });

    this.saveBtn.addEventListener("click", () => this.saveChanges());
  }

  showLoader() {
    if (!this.loader) {
      this.loader = document.createElement("div");
      this.loader.className =
        "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[51]";
      this.loader.innerHTML = `
        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-3">
          <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span class="text-gray-700">Loading profile...</span>
        </div>
      `;
    }
    document.body.appendChild(this.loader);
  }

  hideLoader() {
    if (this.loader && this.loader.parentNode) {
      this.loader.parentNode.removeChild(this.loader);
    }
  }

  async fetchUserData() {
    try {
      const response = await fetch(
        "http://localhost/CB011999/public/api.php/user-profile"
      );
      if (!response.ok) throw new Error("Failed to fetch user data");

      const userData = await response.json();
      this.userData = userData.data;
    } catch (error) {
      console.error("Error fetching user data:", error);
      this.showNotification("Failed to load profile data", "error");
    }
  }

  async openModal() {
    // Fetch user data before showing modal
    await this.fetchUserData();
    this.hideLoader();

    if (this.userData) {
      this.populateUserData();
      this.modal.classList.remove("hidden");
      document.body.style.overflow = "hidden";
    }
  }

  closeModal() {
    this.modal.classList.add("hidden");
    document.body.style.overflow = "";
  }

  handleOutsideClick(event) {
    if (event.target === this.modal) {
      this.closeModal();
    }
  }

  populateUserData() {
    // Populate Profile tab
    const profileTab = document.getElementById("profileTab");
    profileTab.querySelector('input[type="text"]').value =
      this.userData.name || "";
    profileTab.querySelector('input[type="email"]').value =
      this.userData.email || "";
    profileTab.querySelector('input[type="tel"]').value =
      this.userData.phone || "";
    profileTab.querySelector("textarea").value = this.userData.address || "";
    profileTab.querySelectorAll("textarea")[1].value = this.userData.bio || "";

    // Handle preferences
    if (this.userData.preferences) {
      const preferences = JSON.parse(this.userData.preferences);
      profileTab
        .querySelectorAll('input[type="checkbox"]')
        .forEach((checkbox, index) => {
          if (index === 0)
            checkbox.checked = preferences.emailNotifications || false;
          if (index === 1)
            checkbox.checked = preferences.smsNotifications || false;
        });
    }

    // Populate Pet tab if pet_info exists
    if (this.userData.pet_info) {
      const petInfo = JSON.parse(this.userData.pet_info);
      const petTab = document.getElementById("petTab");

      petTab.querySelector('input[type="text"]').value = petInfo.name || "";
      petTab.querySelector('input[type="number"]').value = petInfo.age || "";
      petTab.querySelectorAll('input[type="text"]')[1].value =
        petInfo.breed || "";
      petTab.querySelectorAll('input[type="number"]')[1].value =
        petInfo.weight || "";
      petTab.querySelector("textarea").value = petInfo.medicalHistory || "";
      petTab.querySelectorAll("textarea")[1].value =
        petInfo.specialRequirements || "";

      if (petInfo.vaccinations) {
        petTab
          .querySelectorAll('input[type="checkbox"]')
          .forEach((checkbox, index) => {
            if (index === 0)
              checkbox.checked = petInfo.vaccinations.rabies || false;
            if (index === 1)
              checkbox.checked = petInfo.vaccinations.dhpp || false;
          });
      }
    }

    const createdAtInput = profileTab.querySelector(
      'input[value="2024-12-29"]'
    );
    if (createdAtInput && this.userData.created_at) {
      createdAtInput.value = new Date(
        this.userData.created_at
      ).toLocaleDateString();
    }
  }

  switchTab(selectedTab) {
    this.tabs.forEach((tab) => {
      tab.classList.remove("border-blue-500", "text-blue-600");
      tab.classList.add("border-transparent", "text-gray-500");
    });

    selectedTab.classList.remove("border-transparent", "text-gray-500");
    selectedTab.classList.add("border-blue-500", "text-blue-600");

    this.tabContents.forEach((content) => {
      content.classList.add("hidden");
    });

    const targetId = `${selectedTab.dataset.tab}Tab`;
    document.getElementById(targetId).classList.remove("hidden");

    if (selectedTab.dataset.tab === "orders") {
      this.saveBtn.classList.add("hidden");
    } else {
      this.saveBtn.classList.remove("hidden");
    }
  }

  async saveChanges() {
    this.showLoader();

    try {
      const activeTab = Array.from(this.tabs).find((tab) =>
        tab.classList.contains("border-blue-500")
      );
      const activeTabName = activeTab.dataset.tab;

      let formData = {};

      switch (activeTabName) {
        case "profile":
          formData = {
            name: this.modal.querySelector('input[type="text"]').value,
            phone: this.modal.querySelector('input[type="tel"]').value,
            address: this.modal.querySelector("textarea").value,
            bio: this.modal.querySelectorAll("textarea")[1].value,
            preferences: JSON.stringify({
              emailNotifications: this.modal.querySelectorAll(
                'input[type="checkbox"]'
              )[0].checked,
              smsNotifications: this.modal.querySelectorAll(
                'input[type="checkbox"]'
              )[1].checked,
            }),
          };
          break;

        case "pet":
          formData = {
            pet_info: JSON.stringify({
              name: this.modal.querySelector('#petTab input[type="text"]')
                .value,
              age: this.modal.querySelector('#petTab input[type="number"]')
                .value,
              breed: this.modal.querySelectorAll(
                '#petTab input[type="text"]'
              )[1].value,
              weight: this.modal.querySelector('#petTab input[type="number"]')
                .value,
              medicalHistory:
                this.modal.querySelector("#petTab textarea").value,
              specialRequirements:
                this.modal.querySelectorAll("#petTab textarea")[1].value,
              vaccinations: {
                rabies: this.modal.querySelectorAll(
                  '#petTab input[type="checkbox"]'
                )[0].checked,
                dhpp: this.modal.querySelectorAll(
                  '#petTab input[type="checkbox"]'
                )[1].checked,
              },
            }),
          };
          break;
      }

      const response = await fetch("/api/update-profile", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });

      if (!response.ok) throw new Error("Failed to save changes");

      this.showNotification("Changes saved successfully!");
      // Refresh user data after save
      await this.fetchUserData();
      this.populateUserData();
    } catch (error) {
      console.error("Error saving changes:", error);
      this.showNotification("Failed to save changes", "error");
    } finally {
      this.hideLoader();
    }
  }

  showNotification(message, type = "success") {
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
}

const profile = new Profile();
