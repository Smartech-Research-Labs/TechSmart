#!/usr/bin/env php
<?php
/**
 * Download Google Fonts locally
 * This script downloads DM Sans font files to public/fonts directory
 */

$fontsDir = __DIR__ . '/public/fonts/dm-sans';

// Create directory if it doesn't exist
if (!is_dir($fontsDir)) {
    mkdir($fontsDir, 0755, true);
    echo "Created directory: $fontsDir\n";
}

// Font files to download with their Google Fonts URLs
$fonts = [
    'DM_Sans-Regular.ttf' => 'https://fonts.gstatic.com/s/dmsans/v14/rRCt_4nrouyGAFFvndHdsx1L-K3Zsoz0y_jDEP4-k3g.ttf',
    'DM_Sans-Medium.ttf' => 'https://fonts.gstatic.com/s/dmsans/v14/rRCt_4nrouyGAFFvndHdsx1L-KPZsoz0y_jDEP4-k3g.ttf',
    'DM_Sans-Bold.ttf' => 'https://fonts.gstatic.com/s/dmsans/v14/rRCt_4nrouyGAFFvndHdsx1L-K92soz0y_jDEP4-k3g.ttf',
    'DM_Sans-BoldItalic.ttf' => 'https://fonts.gstatic.com/s/dmsans/v14/rRCt_4nrouyGAFFvndHdsx1L-K3lsIz0y_jDEP4-k3g.ttf',
];

echo "Downloading DM Sans fonts...\n";

foreach ($fonts as $filename => $url) {
    $filepath = $fontsDir . '/' . $filename;
    
    if (file_exists($filepath)) {
        echo "✓ Already exists: $filename\n";
        continue;
    }
    
    echo "Downloading: $filename... ";
    
    $content = @file_get_contents($url, false, stream_context_create([
        'http' => ['timeout' => 30]
    ]));
    
    if ($content === false) {
        echo "FAILED (network error)\n";
        continue;
    }
    
    if (file_put_contents($filepath, $content) === false) {
        echo "FAILED (write error)\n";
        continue;
    }
    
    echo "OK (" . filesize($filepath) . " bytes)\n";
}

echo "\nDone! Font files are now in: $fontsDir\n";
