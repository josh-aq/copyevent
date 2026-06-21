<?php
require_once __DIR__ . '/../config/db.php';
require_role('supplier');

$pdo = db();

// Handle accept/reject actions
if (isset($_GET['action'], $_GET['id'], $_GET['service'])) {
    $action = in_array($_GET['action'], ['accepted', 'declined', 'pending']) ? $_GET['action'] : 'pending';
    $eventId = intval($_GET['id']);
    $service = in_array($_GET['service'], ['venue', 'clothes', 'catering', 'host', 'photographer', 'soundsnlights']) ? $_GET['service'] : '';
    
    if ($service) {
        $statusColumn = $service . '_status';
        $pdo->prepare("UPDATE events SET $statusColumn = ? WHERE event_id = ?")->execute([$action, $eventId]);
    }
    
    header('Location: BOOKINGS.php');
    exit;
}

// Fetch all services for this supplier from supplier_services table
$servicesQuery = "
    SELECT service_id, category, name 
    FROM supplier_services 
    WHERE user_id = ?
    ORDER BY category
";
$servicesStmt = $pdo->prepare($servicesQuery);
$servicesStmt->execute([$_SESSION['user_id']]);
$services = $servicesStmt->fetchAll();

// Map category to column and status column names
$categoryMap = [
    'Venue' => ['column' => 'venue_name', 'status' => 'venue_status', 'key' => 'venue'],
    'Clothing' => ['column' => 'clothes', 'status' => 'clothes_status', 'key' => 'clothes'],
    'Catering' => ['column' => 'catering', 'status' => 'catering_status', 'key' => 'catering'],
    'Host' => ['column' => 'host', 'status' => 'host_status', 'key' => 'host'],
    'Photographer' => ['column' => 'photographer', 'status' => 'photographer_status', 'key' => 'photographer'],
    'Sounds & Lights' => ['column' => 'soundsnlights', 'status' => 'soundsnlights_status', 'key' => 'soundsnlights']
];

// Build booking rows for each service
$bookingRows = [];
foreach ($services as $service) {
    $category = $service['category'];
    $serviceName = $service['name'];
    $serviceId = $service['service_id'];
    
    if (isset($categoryMap[$category])) {
        $colInfo = $categoryMap[$category];
        $column = $colInfo['column'];
        $statusColumn = $colInfo['status'];
        $serviceKey = $colInfo['key'];
        
        // Query events for this service
        $eventQuery = "
            SELECT 
                e.event_id, 
                e.title, 
                e.event_type, 
                e.event_date, 
                e.budget,
                e.$column,
                e.$statusColumn,
                e.payment_method,
                u.full_name as client_name
            FROM events e
            JOIN users u ON e.user_id = u.user_id
            WHERE e.$column = ?
            ORDER BY e.event_date DESC
        ";
        
        $eventStmt = $pdo->prepare($eventQuery);
        $eventStmt->execute([$serviceName]);
        $events = $eventStmt->fetchAll();
        
        foreach ($events as $event) {
            $bookingRows[] = [
                'service_id' => $serviceId,
                'event_id' => $event['event_id'],
                'title' => $event['title'],
                'event_type' => $event['event_type'],
                'event_date' => $event['event_date'],
                'budget' => $event['budget'],
                'client_name' => $event['client_name'],
                'service' => $category,
                'service_key' => $serviceKey,
                'status' => $event[$statusColumn],
                'payment_method' => $event['payment_method'] ?? 'cash',
                'business_name' => $serviceName
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link rel="stylesheet" href="../css/supplier.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <main class="main-content">
            <div id="header"></div>

            <section class="booking-request">
                <h2>All Bookings</h2>
                <div style="overflow-x:auto;">
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>Supplier/Business</th>
                                <th>Type of Event</th>
                                <th>Service</th>
                                <th>Client Name</th>
                                <th>Date</th>
                                <th>Budget</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bookingRows)): ?>
                            <tr>
                                <td colspan="9" style="text-align:center;padding:40px;color:var(--muted);">No bookings yet</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($bookingRows as $r): ?>
                            <tr>
                                <td><?= esc($r['business_name']) ?></td>
                                <td><?= esc($r['event_type'] ?? 'N/A') ?></td>
                                <td><?= esc($r['service']) ?></td>
                                <td><?= esc($r['client_name'] ?? 'N/A') ?></td>
                                <td><span class="date"><?= esc($r['event_date'] ?? 'TBD') ?></span></td>
                                <td>₱<?= number_format($r['budget'] ?? 0) ?></td>
                                <td>
                                    <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:600;<?= $r['payment_method']==='online' ? 'background:rgba(100,150,255,.15);color:#6496ff;' : 'background:rgba(76,175,80,.15);color:#4caf50;' ?>">
                                        <i class="fas <?= $r['payment_method']==='online' ? 'fa-credit-card' : 'fa-money-bill-wave' ?>"></i>
                                        <?= esc(ucfirst($r['payment_method'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="
                                        display:inline-block;
                                        padding:6px 14px;
                                        border-radius:999px;
                                        font-size:12px;
                                        font-weight:700;
                                        <?= $r['status']==='accepted' ? 'background:rgba(100,255,150,.15);color:#64ff96;' : ($r['status']==='declined' ? 'background:rgba(255,100,100,.15);color:#ff6464;' : 'background:rgba(243,197,71,.15);color:var(--gold);') ?>
                                    ">
                                        <?= esc(ucfirst($r['status'])) ?>
                                    </span>
                                </td>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($r['status'] === 'pending'): ?>
                                    <a href="?action=accepted&id=<?= $r['event_id'] ?>&service=<?= $r['service_key'] ?>" class="accept-btn" style="text-decoration:none;display:inline-block;margin-right:6px;">Accept</a>
                                    <a href="?action=declined&id=<?= $r['event_id'] ?>&service=<?= $r['service_key'] ?>" class="decline-btn" style="text-decoration:none;display:inline-block;">Decline</a>
                                    <?php else: ?>
                                    <a href="?action=pending&id=<?= $r['event_id'] ?>&service=<?= $r['service_key'] ?>" style="color:var(--muted);font-size:13px;text-decoration:underline;">Reset</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
