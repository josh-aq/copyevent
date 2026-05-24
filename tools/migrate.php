<?php
require_once __DIR__ . '/../config/db.php';

// Simple migration runner - applies SQL files in database/migrations in order
$dir = __DIR__ . '/../database/migrations';
$pdo = db();

$files = glob($dir . '/*.sql');
if (!$files) {
    echo "No migration files found in {$dir}\n";
    exit(0);
}

sort($files, SORT_NATURAL);

foreach ($files as $file) {
    echo "Applying migration: " . basename($file) . "\n";
    $sql = file_get_contents($file);
    try {
        $pdo->exec($sql);
        echo "OK\n";
    } catch (Exception $e) {
        echo "Failed: " . $e->getMessage() . "\n";
        exit(1);
    }
}

echo "All migrations applied.\n";
?>
