<?php

header("Content-Type:application/json");
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

print_r($_GET);
exit();

if (isset($_GET['link'])) {
    $link = $_GET['link'];

    if(isset($_GET['idComentario'])){
        $idComentario = $_GET['idComentario'];
    }
    else{
        $idComentario = null;
    }
    
    $idPedido = $_GET['idPedido'];
    $mediaUser = $_GET['mediaUser'];
    $dataUpload = strval($_GET['dataUpload']);
    $dataUpload = strval("NAO ESTOU RECEBENDO NADA");
    
    $nomearquivo = $_GET['nomeArquivo'];
    $tipoUser = $_GET['tipoUser'];

    $save = salvarArquivoChatDoutor($conn, $link, $idPedido, $dataUpload, $mediaUser, $nomearquivo, $tipoUser, $idComentario);
    
    if ($save) {
        // Retorna um código de status HTTP 200 para indicar sucesso
        http_response_code(200);
        echo json_encode(['status' => 'success']);
    } else {
        // Retorna um código de status HTTP 500 para indicar erro no servidor
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to save file']);
    }
} else {
    // Retorna um código de status HTTP 400 para indicar requisição inválida
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Link parameter is missing']);
}


