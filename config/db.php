<?php
// Ensure session is started before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_NAME', 'COPYEVENTINTEL');
define('DB_USER', 'root');
define('DB_PASS', '');
define('OPENAI_API_KEY', getenv('OPENAI_API_KEY') ?: '');

function db() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw new Exception('Database connection failed. Please check your configuration.');
        }
    }
    return $pdo;
}

function esc($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function app_base_url() {
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
    $appRoot = realpath(__DIR__ . '/..');

    if ($documentRoot && $appRoot && strpos($appRoot, $documentRoot) === 0) {
        $relative = substr($appRoot, strlen($documentRoot));
        $relative = str_replace('\\', '/', $relative);
        return $relative === '' ? '' : ('/' . ltrim($relative, '/'));
    }

    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $dir = rtrim(dirname($script), '\/');
    return $dir === '.' ? '' : $dir;
}

function redirect_to($path) {
    if ($path === '') {
        $base = app_base_url();
        $url = $base === '' ? '/' : $base;
    } else {
        if ($path[0] === '/') {
            $path = ltrim($path, '/');
        }
        $base = app_base_url();
        $url = $base . ($path === '' ? '' : ('/' . $path));
    }

    // Ensure no output has been sent before redirect
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit;
    }

    // Fallback if headers already sent
    echo '<script>window.location.href="' . esc($url) . '";</script>';
    echo '<noscript><meta http-equiv="refresh" content="0;url=' . esc($url) . '"></noscript>';
    exit;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect_to('/html/index.php');
    }
}

function require_role($role) {
    require_login();
    if (($_SESSION['role'] ?? '') !== $role) {
        http_response_code(403);
        echo 'Access denied. Your account role is ' . esc($_SESSION['role'] ?? 'unknown') . '.';
        exit;
    }
}
?>

