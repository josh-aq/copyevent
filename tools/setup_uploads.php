<?php
// Ensure common upload folders exist and are writable
$paths = [
    __DIR__ . '/../uploads',
    __DIR__ . '/../uploads/posts',
    __DIR__ . '/../uploads/faces',
    __DIR__ . '/../uploads/ids',
    __DIR__ . '/../uploads/permits'
];

foreach ($paths as $p) {
    if (!is_dir($p)) {
        if (mkdir($p, 0775, true)) {
            echo "Created: $p\n";
        } else {
            echo "Failed to create: $p\n";
        }
    } else {
        echo "Exists: $p\n";
    }
    @chmod($p, 0775);
}

echo "Done.\n";
?>
