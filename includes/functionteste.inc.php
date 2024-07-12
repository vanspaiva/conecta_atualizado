<?php

function sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio)
{
  
    //1-Encontrar banco de dados para pesquisa pelo 'tipoNotificacao'//OK
    if ($tipoNotificacao == 'email') {
        $bdNotificacao = 'notificacoesexternasemail';

        $Id = 'ntfEmailId';
        $BDRef = 'ntfEmailBDRef';
        $NomeTemplate = 'ntfEmailNomeTemplate';
        $Titulo = 'ntfEmailAssuntoEmail';
        $Texto = 'ntfEmailTexto';
        $Destinatario = 'ntfEmailDestinatario';
    } else {
        $bdNotificacao = 'notificacoesexternaswpp';

        $Id = 'ntfWppId';
        $BDRef = 'ntfWppBDRef';
        $NomeTemplate = 'ntfWppNomeTemplate';
        $Titulo = 'ntfWppTitulo';
        $Texto = 'ntfWppTexto';
        $Destinatario = 'ntfWppDestinatario';
    }

    //2-Pesquisar Msg por 'idMsg' //OK

    $queryMsg = 'SELECT * FROM ' . $bdNotificacao . ' WHERE ' . $Id . ' = ' . $idMsg . ' ;';
    $retMsg = mysqli_query($conn, $queryMsg);

    //3-armazenar em variáveis //OK

    while ($rowMsg = mysqli_fetch_array($retMsg)) {
        $bancoReferencia = $rowMsg[$BDRef];
        $assunto = $rowMsg[$Titulo];
        $nomeTemplate = $rowMsg[$NomeTemplate];
        $texto = htmlspecialchars_decode($rowMsg[$Texto]);
        $destinatario = $rowMsg[$Destinatario];
    }

    //4-pesquisar no texto os placeholders e guardar em um array de placeholders //OK
    $listplaceholders = findplaceholders($conn, $texto, $bancoReferencia);

    //5-pesquisar no array de placeholders os nomes das colunas //OK
    $listNomeColunas = findcolumnsname($conn, $listplaceholders, $bancoReferencia);

    //6-pesquisar cada coluna do array em 'banco referencia' onde id='itemEnvio' e armazenar em um array //OK
    $resultadosPlaceholders = findresultplaceholders($conn, $listNomeColunas, $itemEnvio, $bancoReferencia);


    //7-substituir placeholders por valores reais //OK
    $novotexto = str_replace($listplaceholders, $resultadosPlaceholders, $texto);

    //8-verifica tipo de notificacao//OK

    if ($tipoNotificacao == 'email') {
        
        $emailDest = findemailDestinatario($conn, $destinatario, $itemEnvio, $bancoReferencia);

        enviarEmail($emailDest, $assunto, $novotexto);
    } else {

        $celularDest = findcelularDestinatario($conn, $destinatario, $itemEnvio, $bancoReferencia);

        enviarWpp($celularDest, $novotexto);
    }
}

function findplaceholders($conn, $texto, $bancoReferencia)
{
    $placehoders = array();
    $listaColunasBancoPlaceholders = array();
    $queryPlc = mysqli_query($conn, "SELECT * FROM placeholdersnotificacao WHERE plntfBd LIKE '%$bancoReferencia%'");

    if (mysqli_num_rows($queryPlc) > 0) {
        while ($row = mysqli_fetch_assoc($queryPlc)) {
            array_push($listaColunasBancoPlaceholders, $row['plntfNome']);
        }
    }

    foreach ($listaColunasBancoPlaceholders as &$item) {
        if (strstr($texto, $item)) {
            array_push($placehoders, $item);
        }
    }

    return $placehoders;
}

function findcolumnsname($conn, $listplaceholders, $bancoReferencia)
{
    $listNomeColunas = array();
    foreach ($listplaceholders as &$plc) {
        $queryPlc = "SELECT * FROM placeholdersnotificacao WHERE plntfNome LIKE '%$plc%' AND plntfBd LIKE '%$bancoReferencia%';";
        $retPlc = mysqli_query($conn, $queryPlc);
        while ($rowPlc = mysqli_fetch_array($retPlc)) {
            array_push($listNomeColunas, $rowPlc['plntfVariavel']);
        }
    }

    return $listNomeColunas;
}

function findresultplaceholders($conn, $listNomeColunas, $itemEnvio, $bancoReferencia)
{

    $listaColunasBancoReferencia = array();
    $resultscolumns = array();
    $queryDest = mysqli_query($conn, "SHOW COLUMNS FROM " . $bancoReferencia);

    if (mysqli_num_rows($queryDest) > 0) {
        while ($row = mysqli_fetch_assoc($queryDest)) {
            array_push($listaColunasBancoReferencia, $row['Field']);
        }
    }

    $needle = 'Id';
    foreach ($listaColunasBancoReferencia as &$coluna) {
        if (strstr($coluna, $needle)) {
            $resultId = $coluna;
        }
    }


    foreach ($listNomeColunas as $nomecoluna) {
        $queryItem = "SELECT * FROM " . $bancoReferencia . " WHERE " . $resultId . " LIKE '%$itemEnvio%';";

        $retItem = mysqli_query($conn, $queryItem);
        while ($rowItem = mysqli_fetch_array($retItem)) {
            //armazenar cada resultado em um array
            array_push($resultscolumns, $rowItem[$nomecoluna]);
        }
    }

    return $resultscolumns;
}

function findemailDestinatario($conn, $destinatario, $itemEnvio, $bancoReferencia)
{
    $param = 'nome';
    if (strstr($destinatario, $param)) {

        $tipo = explode('_', $destinatario);
        $tipo = $tipo[1];
        $tipo = rtrim($tipo, "]");

        $listaColunasBancoReferencia = array();
        $queryDest = mysqli_query($conn, "SHOW COLUMNS FROM " . $bancoReferencia);

        if (mysqli_num_rows($queryDest) > 0) {
            while ($row = mysqli_fetch_assoc($queryDest)) {
                array_push($listaColunasBancoReferencia, $row['Field']);
            }
        }

        $needle = 'Id';
        foreach ($listaColunasBancoReferencia as &$coluna) {
            if (strstr($coluna, $needle)) {
                $resultId = $coluna;
            }
        }

        switch ($tipo) {
            case 'criador':
                $needle = 'UserCriacao';
                break;

            case 'representante':
                $needle = 'Representante';
                break;
        }

        foreach ($listaColunasBancoReferencia as &$coluna) {
            if (strstr($coluna, $needle)) {
                $resultEmail = $coluna;
            }
        }

        $queryDest = 'SELECT * FROM ' . $bancoReferencia . ' WHERE ' . $resultId . ' = ' . $itemEnvio . ' ;';
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $emailDest = $rowDest[$resultEmail];
        }

        $queryDest = "SELECT * FROM users WHERE usersUid LIKE '%$emailDest%' ;";
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $emailDest = $rowDest['usersEmail'];
        }
    } else {
        $queryDest = "SELECT * FROM placeholdersnotificacao WHERE plntfNome LIKE '%$destinatario%' AND  plntfBd LIKE '%$bancoReferencia%';";
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $emailDest = $rowDest['plntfVariavel'];
        }
    }


    return $emailDest;
}

function findcelularDestinatario($conn, $destinatario, $itemEnvio, $bancoReferencia)
{
    $param = 'nome';
    if (strstr($destinatario, $param)) {

        $tipo = explode('_', $destinatario);
        $tipo = $tipo[1];
        $tipo = rtrim($tipo, "]");

        $listaColunasBancoReferencia = array();
        $queryDest = mysqli_query($conn, "SHOW COLUMNS FROM " . $bancoReferencia);

        if (mysqli_num_rows($queryDest) > 0) {
            while ($row = mysqli_fetch_assoc($queryDest)) {
                array_push($listaColunasBancoReferencia, $row['Field']);
            }
        }

        $needle = 'Id';
        foreach ($listaColunasBancoReferencia as &$coluna) {
            if (strstr($coluna, $needle)) {
                $resultId = $coluna;
            }
        }

        switch ($tipo) {
            case 'criador':
                $needle = 'UserCriacao';
                break;

            case 'representante':
                $needle = 'Representante';
                break;
        }

        foreach ($listaColunasBancoReferencia as &$coluna) {
            if (strstr($coluna, $needle)) {
                $resultEmail = $coluna;
            }
        }

        $queryDest = 'SELECT * FROM ' . $bancoReferencia . ' WHERE ' . $resultId . ' = ' . $itemEnvio . ' ;';
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $celDest = $rowDest[$resultEmail];
        }

        $queryDest = "SELECT * FROM users WHERE usersUid LIKE '%$celDest%' ;";
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $celDest = $rowDest['usersCel'];
        }

        $cel = implode('', explode(' ', $celDest));
        $cel = implode('', explode('-', $cel));
        $cel = implode('', explode('(', $cel));
        $cel = implode('', explode(')', $cel));
        $celDest = '+55' . $cel;
    } else {
        $queryDest = "SELECT * FROM placeholdersnotificacao WHERE plntfNome LIKE '%$destinatario%' AND  plntfBd LIKE '%$bancoReferencia%';";
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $celDest = $rowDest['plntfVariavel'];
        }

        $celDest = '+' . $celDest;
    }


    return $celDest;
}

function enviarWpp($celular, $msg)
{
    sendNotification($celular, $msg);
}

function enviarEmail($para_email, $assunto, $html)
{

    $destino = $para_email;


    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($destino, $assunto, $html, $headers);
}
