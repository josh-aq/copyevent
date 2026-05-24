<?php
require_once __DIR__ . '/../config/db.php';
require_role('coordinator');

$pdo = db();
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt->execute([$userId]);
$coordinator = $stmt->fetch();

if (!$coordinator) {
    redirect_to('/auth/logout.php');
}

$message = '';
$messageType = 'info';

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $businessName = trim($_POST['business_name'] ?? '');
    $businessAddress = trim($_POST['business_address'] ?? '');
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (!$businessName || !$businessAddress || !$fullName || !$email) {
        $message = 'Please fill in all required fields';
        $messageType = 'error';
    } else {
        try {
            $update = $pdo->prepare('
                UPDATE users 
                SET business_name = ?, business_address = ?, full_name = ?, email = ?, phone = ?
                WHERE user_id = ?
            ');
            $update->execute([$businessName, $businessAddress, $fullName, $email, $phone, $userId]);
            $message = 'Profile updated successfully!';
            $messageType = 'success';

            // Refresh coordinator data
            $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
            $stmt->execute([$userId]);
            $coordinator = $stmt->fetch();
        } catch (Exception $e) {
            $message = 'Error updating profile: ' . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Get events coordinated count
$events = $pdo->prepare('SELECT COUNT(*) as count FROM events WHERE user_id = ?');
$events->execute([$userId]);
$eventsCount = $events->fetch()['count'];

// Get bookings/clients count
$bookings = $pdo->prepare('SELECT COUNT(DISTINCT event_id) as count FROM bookings WHERE service_id IN (SELECT service_id FROM supplier_services WHERE user_id = ?)');
$bookings->execute([$userId]);
$clientsCount = $bookings->fetch()['count'];

// Get reviews
$reviews = $pdo->prepare('SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE event_id IN (SELECT event_id FROM events WHERE user_id = ?)');
$reviews->execute([$userId]);
$reviewData = $reviews->fetch();
$avgRating = $reviewData['avg_rating'] ?? 0;
$totalReviews = $reviewData['total_reviews'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Coordinator Profile - EventIntel</title>
    <link rel="stylesheet" href="../css/supplier.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        .profile-header{
            background:rgba(255,255,255,.04);
            border:1px solid rgba(243,197,71,.12);
            border-radius:28px;
            padding:26px;
            box-shadow:0 24px 60px rgba(0,0,0,.18);
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:18px;
            flex-wrap:wrap;
            margin-bottom:22px;
        }
        .profile-info h1{font-size:clamp(26px,3vw,40px);color:var(--text);margin-bottom:8px;font-weight:900}
        .profile-info p{color:#d8d8d8;margin:6px 0;font-size:14px}
        .stats{display:flex;gap:16px;flex-wrap:wrap}
        .stat-card{min-width:160px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:22px;padding:18px}
        .stat-card .number{font-size:28px;font-weight:900;color:var(--gold)}
        .stat-card .label{color:var(--muted);font-size:13px;margin-top:6px}

        .form-section{
            background:rgba(255,255,255,.03);
            border:1px solid rgba(255,255,255,.08);
            border-radius:28px;
            padding:26px;
            box-shadow:0 24px 60px rgba(0,0,0,.12);
            margin-top:18px;
        }
        .form-section h2{font-size:24px;color:var(--text);font-weight:900;margin-bottom:18px}

        .form-group{margin-bottom:16px}
        .form-group label{display:block;color:var(--gold);font-weight:800;font-size:13px;letter-spacing:.4px;margin-bottom:10px;text-transform:uppercase}
        .form-group input{width:100%;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);border-radius:14px;padding:14px 16px;outline:none;font-size:15px}
        .form-group input::placeholder{color:#8f8f8f}

        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:18px}
        .button-group{display:flex;gap:12px;flex-wrap:wrap;margin-top:18px}

        .btn-primary,.btn-secondary{border:none;border-radius:14px;padding:12px 18px;font-weight:800;cursor:pointer;transition:.3s}
        .btn-primary{background:linear-gradient(135deg,var(--gold2),var(--gold),var(--gold3));color:#111}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 12px 24px rgba(243,197,71,.22)}
        .btn-secondary{background:transparent;color:#ff8b8b;border:1px solid rgba(255,80,80,.35)}
        .btn-secondary:hover{background:rgba(255,80,80,.08)}

        .message{padding:14px 16px;border-radius:16px;margin-bottom:18px;font-size:14px;border-left:4px solid transparent}
        .message.success{background:rgba(40,167,69,.12);color:#b7f4c6;border-left-color:#28a745}
        .message.error{background:rgba(220,53,69,.12);color:#ffb3b3;border-left-color:#dc3545}
        .message.info{background:rgba(23,162,184,.12);color:#b7ebff;border-left-color:#17a2b8}

        @media(max-width:900px){
            .profile-header{padding:22px}
            .form-row{grid-template-columns:1fr}
            .stats{flex-direction:column;align-items:flex-start}
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <div class="container">
        <main class="main-content">
<div id="header"></div>

            <div class="profile-header">
                <div class="profile-info">
                    <h1><?= esc($coordinator['full_name']) ?></h1>
                    <p><strong>Account Type:</strong> Event Coordinator</p>
                    <p><strong>Status:</strong> <span style="color: #28a745; font-weight:900;">✓ Approved</span></p>
                    <p><?= esc($coordinator['business_address'] ?? 'Address not set') ?></p>
                </div>

                <div class="stats">
                    <div class="stat-card">
                        <div class="number"><?= (int)$eventsCount ?></div>
                        <div class="label">Events Managed</div>
                    </div>
                    <div class="stat-card">
                        <div class="number"><?= (int)$clientsCount ?></div>
                        <div class="label">Active Clients</div>
                    </div>
                    <div class="stat-card">
                        <div class="number"><span class="rating"><?= number_format((float)$avgRating, 1) ?></span> / 5</div>
                        <div class="label"><?= (int)$totalReviews ?> Reviews</div>
                    </div>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="message <?= esc($messageType) ?>"><?= esc($message) ?></div>
            <?php endif; ?>

            <div class="form-section">
                <h2>Edit Profile Information</h2>

                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" value="<?= esc($coordinator['full_name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" value="<?= esc($coordinator['email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="business_name">Company Name *</label>
                            <input type="text" id="business_name" name="business_name" value="<?= esc($coordinator['business_name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?= esc($coordinator['phone'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-row" style="grid-template-columns:1fr;">
                        <div class="form-group">
                            <label for="business_address">Office Address *</label>
                            <input type="text" id="business_address" name="business_address" value="<?= esc($coordinator['business_address'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-primary">Save Changes</button>
                        <button type="button" class="btn-secondary" onclick="location.href='dashboard.php'">Cancel</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="../js/header.js"></script>
</body>
</html>

