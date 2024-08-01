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

// Analisar e processar a resposta
if ($httpCode == 200 && $response) {
    $responseArray = json_decode($response, true);  // Decodifica a resposta JSON
    
    if (isset($responseArray['fileUrl'])) {  // Verifica se o campo fileUrl existe
        $fileUrl = $responseArray['fileUrl'];  // Atribui a URL à variável
        echo "<p>Arquivo enviado com sucesso! Acesse o arquivo aqui: <a href=\"$fileUrl\">$fileUrl</a></p>";
    } else {
        echo "<p>Resposta do webhook não contém a URL do arquivo.</p>";
    }
} else {
    echo "<p>Erro ao enviar arquivo para o webhook: $response</p>";
    echo "<p>HTTP Code: $httpCode</p>";
    echo "<p>cURL Error: $curlError</p>";
}

