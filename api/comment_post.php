<?php
require_once __DIR__ . '/../config/db.php';
require_login();
header('Content-Type: application/json');

$pdo = db();
$user_id = $_SESSION['user_id'];

$in = $_POST ?: json_decode(file_get_contents('php://input'), true) ?: [];
$post_id = (int)($in['post_id'] ?? 0);
$comment = trim($in['comment'] ?? '');

if (!$post_id || $comment === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing post_id or comment']);
    exit;
}

// Insert comment
$stmt = $pdo->prepare("INSERT INTO post_comments (post_id, user_id, comment) VALUES (?, ?, ?)");
$stmt->execute([$post_id, $user_id, $comment]);

// Fetch the inserted comment with user info
$cid = $pdo->lastInsertId();
$fetch = $pdo->prepare("SELECT c.*, u.full_name FROM post_comments c JOIN users u ON c.user_id = u.user_id WHERE c.comment_id = ?");
$fetch->execute([$cid]);
$row = $fetch->fetch();

if ($row) {
    $html = '<div class="comment"><strong>' . esc($row['full_name']) . '</strong> <span class="time">' . date('M j, Y g:i A', strtotime($row['created_at'])) . '</span><div>' . esc($row['comment']) . '</div></div>';
    echo json_encode(['success' => true, 'comment_html' => $html]);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Unable to fetch comment']);
?>