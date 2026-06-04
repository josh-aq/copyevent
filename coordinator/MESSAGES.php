<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MESSAGES</title>
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
                    <li class="active"><button onclick="location.href='MESSAGES.php'">MESSAGES</button></li>
                    <li><button onclick="location.href='MYSUPPLIERS.php'">MY SUPPLIERS</button></li>
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

            <section class="messages">
                <h3>MESSAGES</h3>
                <ul>
                    <li>
                        <span class="user-icon"></span>
                        <input type="text" placeholder="Message 1" readonly />
                    </li>
                    <li>
                        <span class="user-icon"></span>
                        <input type="text" placeholder="Message 2" readonly />
                    </li>
                    <li>
                        <span class="user-icon"></span>
                        <input type="text" placeholder="Message 3" readonly />
                    </li>
                </ul>
            </section>
        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
