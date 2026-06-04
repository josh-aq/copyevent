<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MY SUPPLIERS</title>
    <link rel="stylesheet" href="../css/coordinator.css" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      rel="stylesheet"
    />
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <h1><span class="blue-text">Event</span><span class="pink-text">Intel</span></h1>
                <div class="user-info">
                    <strong><?= htmlspecialchars($_SESSION['full_name'] ?? 'Coordinator') ?></strong>
                    <span class="supplier"><i class="fas fa-circle"></i> Coordinator</span>
                </div>
            </div>
            <nav class="nav-menu">
                <ul>
                    <li><button onclick="location.href='DASHBOARD.php'">DASHBOARD</button></li>
                    <li><button onclick="location.href='ASSIGNED_EVENTS.php'">ASSIGNED EVENTS</button></li>
                    <li><button onclick="location.href='PACKAGES.php'">PACKAGES</button></li>
                    <li><button onclick="location.href='MESSAGES.php'">MESSAGES</button></li>
                    <li  class="active"><button onclick="location.href='MYSUPPLIERS.php'">MY SUPPLIERS</button></li>
                    <li><button onclick="location.href='REPORTS.php'">REPORTS</button></li>
                    <li><button onclick="location.href='SETTINGS.php'">SETTINGS</button></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="../auth/logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div id="header"></div>

            <section class="your-services">
                <h3>Your Services:</h3>

                <div class="services-grid">

                    <div class="service-card">
                        <img src="images/catering.jpg" alt="Catering">
                        <h4>Catering Service</h4>
                        <p>Food packages for weddings, birthdays, and corporate events.</p>
                        <div class="star-rating">⭐ 4.8</div>
                        <button>View Details</button>
                    </div>

                    <div class="service-card">
                        <img src="images/photo.jpg" alt="Photography">
                        <h4>Photography</h4>
                        <p>Professional photographers for memorable moments.</p>
                        <div class="star-rating">⭐ 4.7</div>
                        <button>View Details</button>
                    </div>

                    <div class="service-card">
                        <img src="images/decor.jpg" alt="Decoration">
                        <h4>Event Decoration</h4>
                        <p>Elegant venue styling and theme decorations.</p>
                        <div class="star-rating">⭐ 4.6</div>
                        <button>View Details</button>
                    </div>

                    <div class="service-card">
                        <img src="images/music.jpg" alt="Music">
                        <h4>Live Band / DJ</h4>
                        <p>Music entertainment for parties and weddings.</p>
                        <div class="star-rating">⭐ 4.9</div>
                        <button>View Details</button>
                    </div>

                </div>
            </section>
        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
