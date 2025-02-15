<?php

// Check PHP version
if (version_compare(PHP_VERSION, '8.0.0', '<')) {
    die("PHP 8.0 or higher is required. Your PHP version: " . PHP_VERSION);
}

// Check if Composer is installed
exec('composer --version 2>&1', $output, $returnCode);
if ($returnCode !== 0) {
    die("Composer is required but not installed. Please install Composer first.");
}

// Create necessary directories
$directories = [
    'storage/logs',
    'storage/cache',
    'storage/uploads',
    'resources/views',
    'public/css',
    'public/js',
    'public/images',
];

foreach ($directories as $dir) {
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        die("Failed to create directory: {$dir}");
    }
}

// Run Composer install
exec('composer install', $output, $returnCode);
if ($returnCode !== 0) {
    die("Failed to install dependencies via Composer.");
}

echo "Ynet framework has been successfully installed!\n";
echo "Now you can start building your application.\n";