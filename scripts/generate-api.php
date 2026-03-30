<?php

/**
 * API Reference Generator for Tiny PHP
 * 
 * This script downloads Composer packages and generates minimal Markdown
 * documentation for their public API.
 */

$packages = [
    'tinyframework/core' => 'core'
];

$workingDir = __DIR__ . '/../temp';
$docsDir = __DIR__ . '/../api-reference';

if (!is_dir($workingDir)) {
    mkdir($workingDir, 0777, true);
}

if (!is_dir($docsDir)) {
    mkdir($docsDir, 0777, true);
}

foreach ($packages as $packageName => $folderName) {
    echo "Installing $packageName...\n";

    $packagePath = "$workingDir/$folderName";

    // 1. Download/Update package
    if (!is_dir($packagePath)) {
        echo "Downloading $packageName...\n";
        shell_exec("composer create-project --no-interaction --prefer-dist $packageName $packagePath");
    } else {
        echo "Updating $packageName...\n";
        shell_exec("composer update --working-dir=$packagePath --no-interaction");
    }
}

require_once __DIR__ . '/rebuild-api-docs.php';