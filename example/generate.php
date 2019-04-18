<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Xuid\Xuid;

// Xuid::setMap(
//     [
//         '+' => 'Æ',
//         '/' => 'Ä',
//     ]
// );

Xuid::forceAlphaNumeric();

for ($i=0; $i<100; $i++) {
    $xuid = Xuid::getXuid();
    $uuid = Xuid::decode($xuid);
    echo "$xuid: $uuid" . PHP_EOL;
}
