/akeEventIntel shared supplier/coordinator header mount
(function () {
  const mount = document.getElementById("header");
  if (!mount) {
    // Don’t throw; allow pages to still render.
    console.warn("[header.js] #header mount not found; header not rendered.");
    return;
  }

  mount.innerHTML = `
    <header class="main-header">
      <button class="header-menu-btn" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
      </button>

      <nav class="top-nav" aria-label="Main navigation">
        <button class="top-nav-btn" type="button" onclick="location.href='DASHBOARD.php'">Dashboard</button>
        <button class="top-nav-btn" type="button" onclick="location.href='SERVICES.php'">Manage Services</button>
        <button class="top-nav-btn" type="button" onclick="location.href='BOOKINGS.php'">Booking Requests</button>
        <button class="top-nav-btn" type="button" onclick="location.href='REVIEWS.php'">Reviews</button>
        <button class="top-nav-btn" type="button" onclick="location.href='FEED.php'">Newsfeed</button>
        <button class="top-profile-btn" type="button" aria-label="Profile" onclick="location.href='PROFILE.php'">
          <i class="fas fa-user"></i>
        </button>
      </nav>
    </header>
  `;

  const menuBtn = mount.querySelector(".header-menu-btn");
  if (!menuBtn) {
    console.warn("[header.js] .header-menu-btn not found after render.");
    return;
  }

  menuBtn.addEventListener("click", function () {
    document.body.classList.toggle("sidebar-collapsed");
  });
})();
