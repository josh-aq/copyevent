<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DASHBOARD</title>
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
                    <li class="active"><button onclick="location.href='DASHBOARD.php'">DASHBOARD</button></li>
                    <li><button onclick="location.href='ASSIGNED_EVENTS.php'">ASSIGNED EVENTS</button></li>
                    <li><button onclick="location.href='PACKAGES.php'">PACKAGES</button></li>
                    <li><button onclick="location.href='MESSAGES.php'">MESSAGES</button></li>
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
                    <main class="main-content dashboard-page">

                <div id="header"></div>

                <!-- Top Stats -->
                <section class="dashboard-stats">

                    <div class="stat-card active">
                        <h3>PENDING EVENTS</h3>
                        <p>6</p>
                    </div>

                    <div class="stat-card">
                        <h3>ONGOING EVENTS</h3>
                        <p>2</p>
                    </div>

                    <div class="stat-card">
                        <h3>TOTAL SUPPLIERS</h3>
                        <p>55</p>
                    </div>

                </section>

                <!-- Assigned Events -->
                <section class="assigned-events-box">

                    <h2>ASSIGNED EVENTS</h2>

                    <div class="event-row">
                        <span>Christy Gender Reveal</span>

                        <div class="event-actions">
                            <button class="view-btn">View</button>
                            <button class="settle-btn">Settle</button>
                        </div>
                    </div>

                    <div class="event-row">
                        <span>Jack & Jill Wedding</span>

                        <div class="event-actions">
                            <button class="view-btn">View</button>
                            <button class="settle-btn">Settle</button>
                        </div>
                    </div>

                </section>

                <!-- AI Generator -->
                <section class="ai-box">
                    <h3>AI Program Flow Generator</h3>

                    <button>Choose Confirmed Event</button>
                </section>

            </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
