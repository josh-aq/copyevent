<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Check if user is coordinator
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header('Location: ../auth/login.php');
    exit;
}

$pdo = db();
$coordinatorName = $_SESSION['full_name'];

// Handle accept/decline actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['event_id'])) {
    $action = $_POST['action'];
    $eventId = (int)$_POST['event_id'];
    
    if ($action === 'accept') {
        $status = 'accepted';
    } elseif ($action === 'decline') {
        $status = 'declined';
    } else {
        $status = null;
    }
    
    if ($status) {
        try {
            $stmt = $pdo->prepare("
                UPDATE events 
                SET coordinator_status = ? 
                WHERE event_id = ? AND coordinator = ?
            ");
            $stmt->execute([$status, $eventId, $coordinatorName]);
            
            header('Location: ASSIGNED_EVENTS.php?success=' . ($status === 'accepted' ? 'accepted' : 'declined'));
            exit;
        } catch (Exception $e) {
            error_log('Error updating event: ' . $e->getMessage());
        }
    }
}

// Fetch events assigned to this coordinator with client name
try {
    $stmt = $pdo->prepare("
        SELECT e.event_id, u.full_name, e.event_date, e.budget, e.coordinator_status, e.status, e.created_at
        FROM events e
        LEFT JOIN users u ON e.user_id = u.user_id
        WHERE e.coordinator = ?
        ORDER BY e.created_at DESC
    ");
    $stmt->execute([$coordinatorName]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log('Error fetching events: ' . $e->getMessage());
    $events = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASSIGNED EVENTS</title>
    <link rel="stylesheet" href="../css/coordinator.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        .booking-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 14px;
        }
        .booking-table thead tr {
            background: rgba(243, 197, 71, 0.09);
        }
        .booking-table th {
            color: var(--gold);
            background: rgba(243, 197, 71, 0.09);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 16px 18px;
            text-align: left;
            font-size: 13px;
            letter-spacing: 0.8px;
            font-weight: 700;
        }
        .booking-table th:first-child {
            border-left: 1px solid var(--border);
            border-radius: 18px 0 0 18px;
        }
        .booking-table th:last-child {
            border-right: 1px solid var(--border);
            border-radius: 0 18px 18px 0;
        }
        .booking-table td {
            background: var(--panel);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 18px;
            color: #d8d8d8;
            font-size: 15px;
        }
        .booking-table td:first-child {
            border-left: 1px solid var(--border);
            border-radius: 18px 0 0 18px;
            color: var(--text);
            font-weight: 800;
        }
        .booking-table td:last-child {
            border-right: 1px solid var(--border);
            border-radius: 0 18px 18px 0;
        }
        .booking-table tbody tr:hover td {
            background: rgba(243, 197, 71, 0.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <h1><span class="blue-text">Event</span><span class="pink-text">Intel</span></h1>
                <div class="user-info">
                    <strong><?= htmlspecialchars($_SESSION['full_name']) ?></strong>
                    <span class="supplier"><i class="fas fa-circle"></i> Coordinator</span>
                </div>
            </div>
            <nav class="nav-menu">
                <ul>
                    <li><button onclick="location.href='DASHBOARD.php'">DASHBOARD</button></li>
                    <li class="active"><button onclick="location.href='ASSIGNED_EVENTS.php'">ASSIGNED EVENTS</button></li>
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
        <main class="main-content">
            <div id="header"></div>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Event <?= $_GET['success'] === 'accepted' ? 'accepted' : 'declined' ?> successfully!
                </div>
            <?php endif; ?>

            <section class="booking-request">
                <h2>Assigned Events</h2>
                
                <?php if (empty($events)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        No events assigned to you yet.
                    </div>
                <?php else: ?>
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>CLIENT</th>
                                <th>DATE</th>
                                <th>BUDGET</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td><?= htmlspecialchars($event['full_name'] ?? 'Unknown Client') ?></td>
                                    <td><?= $event['event_date'] ? date('M d, Y', strtotime($event['event_date'])) : 'N/A' ?></td>
                                    <td>₱<?= number_format($event['budget'] ?? 0, 0) ?></td>
                                    <td>
                                        <?php
                                        $status = $event['coordinator_status'] ?? 'pending';
                                        $statusClass = match($status) {
                                            'accepted' => 'status-approved',
                                            'declined' => 'status-rejected',
                                            default => 'status-pending'
                                        };
                                        $statusText = ucfirst($status);
                                        ?>
                                        <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                                    </td>
                                    <td>
                                        <?php if ($event['coordinator_status'] === 'pending'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="accept-btn">Accept</button>
                                            </form>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                                                <input type="hidden" name="action" value="decline">
                                                <button type="submit" class="decline-btn">Decline</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
