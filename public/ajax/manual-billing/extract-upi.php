<?php
header('Content-Type: application/json');

$response = [
    'success' => false,
    'transaction_id' => '',
    'raw_text' => ''
];

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
    echo json_encode($response);
    exit;
}

// ✅ Limit size (3MB)
if ($_FILES['image']['size'] > 3 * 1024 * 1024) {
    echo json_encode($response);
    exit;
}

// Read image
$imageData = base64_encode(file_get_contents($_FILES['image']['tmp_name']));

// 🔑 PUT YOUR GOOGLE VISION API KEY HERE
$apiKey = 'PASTE_YOUR_GOOGLE_VISION_API_KEY_HERE';

$payload = [
    'requests' => [[
        'image' => ['content' => $imageData],
        'features' => [[
            'type' => 'TEXT_DETECTION'
        ]]
    ]]
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => "https://vision.googleapis.com/v1/images:annotate?key={$apiKey}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_TIMEOUT => 20
]);

$result = curl_exec($ch);
curl_close($ch);

$data = json_decode($result, true);

// Extract OCR text
$text = $data['responses'][0]['fullTextAnnotation']['text'] ?? '';
$response['raw_text'] = $text;

// ===============================
// UPI / UTR ID Detection
// ===============================
$patterns = [
    '/UTR[:\s]*([A-Z0-9]+)/i',
    '/Transaction\s*ID[:\s]*([A-Z0-9]+)/i',
    '/Reference\s*ID[:\s]*([A-Z0-9]+)/i',
    '/\b\d{12}\b/',
    '/\b[A-Z0-9]{10,20}\b/'
];

foreach ($patterns as $pattern) {
    if (preg_match($pattern, $text, $matches)) {
        $response['transaction_id'] = $matches[1] ?? $matches[0];
        $response['success'] = true;
        break;
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
