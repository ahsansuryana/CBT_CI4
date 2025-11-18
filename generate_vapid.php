<?php
require __DIR__ . '/vendor/autoload.php';

use Minishlink\WebPush\VAPID;

// Generate VAPID Keys
$keys = VAPID::createVapidKeys();

echo "=== VAPID KEYS GENERATED ===\n";
echo "Public Key: " . $keys['publicKey'] . "\n";
echo "Private Key: " . $keys['privateKey'] . "\n";
