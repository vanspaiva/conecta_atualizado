<?php

header("Content-Type:application/json");
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

if (isset($_GET['link'])) {
    $link = $_GET['link'];
    if(isset($_GET['idComentario'])){
        $idComentario = $_GET['idComentario'];
    }
    else{
        $idComentario = null;
    }

    $idProduto = $_GET['idProduto'];
    $mediaUser = $_GET['mediaUser'];
    $dataUpload = $_GET['dataUpload'];
    $nomearquivo = $_GET['nomeArquivo'];
    $tipoUser = $_GET['tipoUser'];

    // Certifique-se de que a função salvarArquivo esteja definida corretamente em includes/functions.inc.php
    $save = salvarArquivo($conn, $link, $idProduto, $dataUpload, $mediaUser, $nomearquivo, $tipoUser, $idComentario);
    
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


