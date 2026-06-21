<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SETTINGS</title>
    <link rel="stylesheet" href="../css/coordinator.css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
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
                    <li><button onclick="location.href='../globalaccess/newsfeed.php'">NEWSFEED</button></li>
                    <li><button onclick="location.href='MESSAGES.php'">MESSAGES</button></li>
                    <li><button onclick="location.href='MYSUPPLIERS.php'">MY SUPPLIERS</button></li>
                    <li><button onclick="location.href='REPORTS.php'">REPORTS</button></li>
                    <li class="active"><button onclick="location.href='SETTINGS.php'">SETTINGS</button></li>
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

            <section class="settings-page">
                    <h2>Settings</h2>

                    <div class="settings-grid">

                        <div class="setting-card">
                            <h3>Profile Information</h3>
                            <input type="text" placeholder="Full Name">
                            <input type="email" placeholder="Email Address">
                            <input type="text" placeholder="Business Name">
                            <button>Save Changes</button>
                        </div>

                        <div class="setting-card">
                            <h3>Change Password</h3>
                            <input type="password" placeholder="Current Password">
                            <input type="password" placeholder="New Password">
                            <input type="password" placeholder="Confirm Password">
                            <button>Update Password</button>
                        </div>

                        <div class="setting-card">
                            <h3>Notification Settings</h3>
                            <label><input type="checkbox"> Booking Alerts</label>
                            <label><input type="checkbox"> Messages</label>
                            <label><input type="checkbox"> Promotions</label>
                            <button>Save Preferences</button>
                        </div>

                    </div>
                </section>

            </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
