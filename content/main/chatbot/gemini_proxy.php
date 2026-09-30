<?php
// Server-side proxy to the Gemini API so the API key never reaches the browser.
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => ['message' => 'Not authenticated']]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => ['message' => 'Method not allowed']]);
    exit();
}

$config_file = __DIR__ . '/../../../config.php';
$config = file_exists($config_file) ? require $config_file : [];
$api_key = $config['gemini_api_key'] ?? '';
$model = $config['gemini_model'] ?? 'gemini-1.5-flash-latest';

if ($api_key === '' || $api_key === 'YOUR_GEMINI_API_KEY') {
    http_response_code(500);
    echo json_encode(['error' => ['message' => 'Gemini API key is not configured (see config.example.php)']]);
    exit();
}

$url = 'https://generativelanguage.googleapis.com/v1beta/models/'
    . rawurlencode($model) . ':generateContent';

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => file_get_contents('php://input'),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'x-goog-api-key: ' . $api_key],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
]);
$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => ['message' => 'Upstream request failed']]);
    exit();
}

http_response_code($status ?: 502);
echo $response;
