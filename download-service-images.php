<?php
/**
 * Download royalty-free service images from Unsplash Source.
 * Run: php download-service-images.php
 */

$dir = __DIR__ . '/storage/app/public/services';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Map: filename => Unsplash source keyword URL (1200x800 resolution)
$images = [
    'custom-web-development.jpg'          => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=1200&h=800&fit=crop&q=80',
    'mobile-app-development.jpg'          => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=1200&h=800&fit=crop&q=80',
    'e-commerce-development.jpg'          => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200&h=800&fit=crop&q=80',
    'seo-optimization.jpg'                => 'https://images.unsplash.com/photo-1562577309-4932fdd64cd1?w=1200&h=800&fit=crop&q=80',
    'paid-ads-management.jpg'             => 'https://images.unsplash.com/photo-1533750516457-a7f992034fec?w=1200&h=800&fit=crop&q=80',
    'automation-testing.jpg'              => 'https://images.unsplash.com/photo-1518432031352-d6fc5c10da5a?w=1200&h=800&fit=crop&q=80',
    'audit-trail-development.jpg'         => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200&h=800&fit=crop&q=80',
    'ui-ux-design.jpg'                    => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=1200&h=800&fit=crop&q=80',
    'api-development.jpg'                 => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=1200&h=800&fit=crop&q=80',
    'cloud-deployment-devops.jpg'         => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&h=800&fit=crop&q=80',
    'performance-optimization.jpg'        => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&h=800&fit=crop&q=80',
    'website-maintenance.jpg'             => 'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=1200&h=800&fit=crop&q=80',
    'crm-erp-development.jpg'            => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200&h=800&fit=crop&q=80',
    'cybersecurity.jpg'                   => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=1200&h=800&fit=crop&q=80',
    'business-intelligence.jpg'           => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&h=800&fit=crop&q=80',
    'conversion-rate-optimization.jpg'    => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=1200&h=800&fit=crop&q=80',
    'social-media-marketing.jpg'          => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=1200&h=800&fit=crop&q=80',
];

echo "Downloading " . count($images) . " service images...\n";

$context = stream_context_create([
    'http' => [
        'timeout' => 30,
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'follow_location' => true,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

$success = 0;
$failed = 0;

foreach ($images as $filename => $url) {
    $path = $dir . '/' . $filename;
    if (file_exists($path) && filesize($path) > 10000) {
        echo "  [SKIP] {$filename} (already exists)\n";
        $success++;
        continue;
    }

    echo "  Downloading {$filename}... ";
    $data = @file_get_contents($url, false, $context);

    if ($data && strlen($data) > 5000) {
        file_put_contents($path, $data);
        $size = round(strlen($data) / 1024);
        echo "OK ({$size} KB)\n";
        $success++;
    } else {
        echo "FAILED\n";
        // Create a placeholder
        $failed++;
    }
    usleep(300000); // 300ms delay between requests
}

echo "\nDone! {$success} downloaded, {$failed} failed.\n";
