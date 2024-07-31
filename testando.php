<?php
$webhookUrl = "https://webhooks.integrately.com/a/webhooks/7a12b372e590463a899657241b393d63";

$curl = curl_init();

$postData = [
    'message' => 'Hello, Integrately!',
    'fileName' => 'test-file.txt'
];

curl_setopt_array($curl, [
    CURLOPT_URL => $webhookUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_SSL_VERIFYHOST => false,  // Desabilita a verificação do host SSL
    CURLOPT_SSL_VERIFYPEER => false,  // Desabilita a verificação do certificado SSL
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$curlError = curl_error($curl);

curl_close($curl);

// Log do resultado
$logMessage = "Response: $response\nHTTP Code: $httpCode\ncURL Error: $curlError\n";
file_put_contents('webhook_log.txt', $logMessage, FILE_APPEND);

echo "Response: $response\n";
echo "HTTP Code: $httpCode\n";
echo "cURL Error: $curlError\n";
?>
