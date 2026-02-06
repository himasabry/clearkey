<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$kid = $_GET['keyid'] ?? '';
$key = $_GET['key'] ?? '';

if (!$kid || !$key) {
    echo json_encode([
        "error" => true,
        "msg" => "Missing keyid or key"
    ]);
    exit;
}

function hexToBase64($hex) {
    return rtrim(strtr(base64_encode(hex2bin($hex)), '+/', '-_'), '=');
}

$kid_b64 = hexToBase64($kid);
$key_b64 = hexToBase64($key);

echo json_encode([
    "keys" => [
        [
            "kty" => "oct",
            "kid" => $kid_b64,
            "k"   => $key_b64
        ]
    ],
    "type" => "temporary"
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
