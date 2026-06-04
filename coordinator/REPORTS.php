<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTS</title>
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
                    <li><button onclick="location.href='MESSAGES.php'">MESSAGES</button></li>
                    <li><button onclick="location.href='MYSUPPLIERS.php'">MY SUPPLIERS</button></li>
                    <li  class="active"><button onclick="location.href='REPORTS.php'">REPORTS</button></li>
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

            <section class="reviews-page">
                <h2>Event Reports</h2>

                <div class="review-card">
                    <h3>Wedding Event - April 12, 2026</h3>
                    <p class="status completed">Completed</p>
                    <p>Successfully managed full wedding event with 200 guests. Catering and decorations delivered on time.</p>
                </div>

                <div class="review-card">
                    <h3>Birthday Celebration - April 18, 2026</h3>
                    <p class="status pending">Pending Review</p>
                    <p>Birthday package completed. Waiting for final client feedback and payment confirmation.</p>
                </div>

                <div class="review-card">
                    <h3>Corporate Seminar - April 22, 2026</h3>
                    <p class="status completed">Completed</p>
                    <p>Audio system, stage setup, and food service handled successfully for 150 attendees.</p>
                </div>

                <div class="review-card">
                    <h3>Debut Event - April 25, 2026</h3>
                    <p class="status ongoing">Ongoing</p>
                    <p>Preparation in progress. Venue styling and supplier coordination currently active.</p>
                </div>
            </section>

        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
