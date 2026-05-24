<?php
require_once __DIR__ . '/../config/db.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = (int)$_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $pdo = db();
    
    // Check if user already liked this post
    $check = $pdo->prepare("SELECT * FROM post_likes WHERE post_id = ? AND user_id = ?");
    $check->execute([$post_id, $user_id]);
    
    if ($check->fetch()) {
        // Unlike
        $stmt = $pdo->prepare("DELETE FROM post_likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
        $liked = false;
    } else {
        // Like
        $stmt = $pdo->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
        $stmt->execute([$post_id, $user_id]);
        $liked = true;
    }
    
    // Get updated like count
    $count = $pdo->prepare("SELECT COUNT(*) as likes FROM post_likes WHERE post_id = ?");
    $count->execute([$post_id]);
    $result = $count->fetch();
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'liked' => $liked, 'likes' => $result['likes']]);
} else {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>