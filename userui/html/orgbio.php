<?php 
require_once __DIR__ . '/../../config/db.php'; 
require_role('client');

$pdo = db();
$coordinator_id = intval($_GET['coordinator_id'] ?? 0);
$coordinator = null;

// Fetch coordinator details
if ($coordinator_id) {
    $stmt = $pdo->prepare("SELECT user_id, full_name, email FROM users WHERE user_id = ? AND role = 'coordinator'");
    $stmt->execute([$coordinator_id]);
    $coordinator = $stmt->fetch();
}

// Handle booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_coordinator'])) {
    if ($coordinator) {
        try {
            // Create a new event with the coordinator
            $eventStmt = $pdo->prepare("
                INSERT INTO events (user_id, coordinator, coordinator_status, status, created_at) 
                VALUES (?, ?, 'pending', 'planning', NOW())
            ");
            $eventStmt->execute([$_SESSION['user_id'], $coordinator['full_name']]);
            
            $response = ['success' => true, 'message' => 'Booking confirmed! Event created successfully.'];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => 'Error creating booking: ' . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}

// If no coordinator found, redirect
if (!$coordinator) {
    header('Location: homepage.php');
    exit;
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventIntel - Organizer Profile</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #ffffff;
      color: #222;
      min-height: 100vh;
    }

    .container {
      max-width: 1400px;
      margin: auto;
      padding: 6px 48px 40px;
    }

    /* NAVBAR */
    .navbar {
      width: 100%;
      padding: 12px 0 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 26px;
      font-weight: 800;
      color: #f3c547;
      letter-spacing: 1px;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    .nav-links button {
      padding: 8px 18px;
      border-radius: 12px;
      border: 1px solid rgba(212,160,23,0.35);
      background: rgba(255,255,255,0.55);
      color: #222;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .nav-links button:hover,
    .nav-links .active {
      background: linear-gradient(to right, #ffe17a, #d4a017);
      color: black;
      box-shadow: 0 0 14px rgba(255, 215, 0, 0.12);
    }

    .profile-btn {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 1px solid rgba(212,160,23,0.25);
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #d4a017;
      cursor: pointer;
    }

    /* PROFILE SECTION */
    .profile {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 40px;
      margin-top: 20px;
    }

    .profile-card {
      background: rgba(255,255,255,.95);
      border: 1px solid rgba(212,160,23,.12);
      border-radius: 28px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 12px 30px rgba(0,0,0,.08);
    }

    .profile-img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      overflow: hidden;
      margin: auto;
      margin-bottom: 18px;
      border: 2px solid rgba(212,160,23,.25);
    }

    .profile-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-card h2 {
      margin-bottom: 8px;
      color: #111;
    }

    .role {
      color: #d4a017;
      font-size: 14px;
      margin-bottom: 14px;
    }

    .rating {
      color: #d4a017;
      margin-bottom: 20px;
    }

    .action-buttons {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .msg,
    .btn {
      padding: 12px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 700;
      transition: .3s ease;
      text-align: center;
    }

    .btn-primary {
      background: linear-gradient(135deg, #ffe27a, #d4a017, #b8860b);
      color: white;
      border: none;
      text-decoration: none;
    }

    .btn-outline,
    .msg {
      background: #fff;
      border: 1px solid rgba(212,160,23,.25);
      color: #d4a017;
      text-decoration: none;
    }

    .btn:hover,
    .msg:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(243,197,71,.18);
    }

    /* DETAILS */
    .details {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .section {
      background: rgba(255,255,255,.95);
      border: 1px solid rgba(212,160,23,.12);
      border-radius: 28px;
      padding: 26px;
      box-shadow: 0 12px 30px rgba(0,0,0,.08);
    }

    .section h3 {
      margin-bottom: 12px;
      font-size: 20px;
      color: #111;
    }

    .section p {
      color: #666;
      line-height: 1.6;
    }

    .services {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .service {
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(243,197,71,.12);
      color: #d4a017;
      font-size: 13px;
      border: 1px solid rgba(212,160,23,.15);
    }

  </style>

</head>
<body>

  <div class="container">

<div class="navbar">
  <div class="logo">EventIntel</div>

  <div class="nav-links">
    <button onclick="window.location.href='homepage.php'">Home</button>
    <button onclick="window.location.href='createevent.php'">Create Event</button>
    <button onclick="window.location.href='yourevents.php'">Your Events</button>
    <button onclick="window.location.href='recommendation.php'">Recommendations</button>
    <button onclick="window.location.href='newsfeed.php'">Newsfeed</button>
  </div>
</div>

<div class="profile">

  <!-- LEFT CARD -->
  <div class="profile-card">
    <div class="profile-img">
      <img src="../images/logo.png" alt="<?= esc($coordinator['full_name']) ?>">
    </div>

    <h2><?= esc($coordinator['full_name']) ?></h2>
    <div class="role">Professional Event Coordinator</div>
    <div class="rating">★★★★★ (4.9)</div>

    <div class="action-buttons">
      <button class="btn btn-primary" onclick="bookCoordinator()">Book Now</button>
      <a class="msg" href="message.php?user_id=<?= $coordinator['user_id'] ?>">Message</a>
    </div>
  </div>

  <!-- RIGHT DETAILS -->
  <div class="details">

    <div class="section">
      <h3>About</h3>
      <p>
        Vincent Tolentino is a highly experienced event organizer with over 8 years of
        experience in planning weddings, corporate events, and large-scale celebrations.
        Known for attention to detail and creative execution, Vincent ensures every event
        is memorable and stress-free.
      </p>
    </div>

    <div class="section">
      <h3>Services Offered</h3>
      <div class="services">
        <div class="service">Wedding Planning</div>
        <div class="service">Corporate Events</div>
        <div class="service">Birthday Parties</div>
        <div class="service">Full Coordination</div>
        <div class="service">On-the-day Coordination</div>
      </div>
    </div>

    <div class="section">
      <h3>Experience & Highlights</h3>
      <p>
        • Organized 300+ successful events<br>
        • Partnered with top venues and suppliers<br>
        • Awarded "Best Event Coordinator 2025"<br>
        • Specialized in luxury and themed events
      </p>
    </div>

  </div>

</div>
  </div>

  <!-- Confirmation Modal -->
  <div id="confirmModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 16px; padding: 30px; max-width: 400px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
      <h3 style="margin-bottom: 16px; color: #111;">Confirm Booking</h3>
      <p style="color: #666; margin-bottom: 24px;">Are you sure you want to book <strong><?= esc($coordinator['full_name']) ?></strong> as your event coordinator?</p>
      <div style="display: flex; gap: 12px;">
        <button onclick="cancelBooking()" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid #ddd; background: #f5f5f5; color: #111; cursor: pointer; font-weight: 600;">Cancel</button>
        <button onclick="confirmBooking()" style="flex: 1; padding: 12px; border-radius: 8px; border: none; background: linear-gradient(135deg, #ffe27a, #d4a017); color: white; cursor: pointer; font-weight: 600;">Confirm</button>
      </div>
    </div>
  </div>

  <script>
  function bookCoordinator() {
    document.getElementById('confirmModal').style.display = 'flex';
  }

  function cancelBooking() {
    document.getElementById('confirmModal').style.display = 'none';
  }

  function confirmBooking() {
    const coordinatorId = <?= $coordinator['user_id'] ?>;
    const coordinatorName = '<?= esc($coordinator['full_name']) ?>';

    fetch('orgbio.php?coordinator_id=<?= $coordinator['user_id'] ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'book_coordinator=1'
    })
    .then(response => response.json())
    .then(data => {
      document.getElementById('confirmModal').style.display = 'none';
      if (data.success) {
        alert('Booking confirmed! ' + coordinatorName + ' has been added to your event.\nRedirecting to your events...');
        window.location.href = 'yourevents.php';
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(error => {
      alert('Error processing booking: ' + error);
      document.getElementById('confirmModal').style.display = 'none';
    });
  }
  </script>

</body>
</html>
