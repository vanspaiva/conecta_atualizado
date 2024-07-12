<?php

if (isset($_POST["submit"])) {
    require_once 'dbh.inc.php';
    require_once 'functionsqualidade.inc.php';

    $nomecriador = addslashes($_POST['nomecriador']);
    $tp_contacriador = addslashes($_POST['tp_contacriador']);
    $dtcriacao = addslashes($_POST['dtcriacao']);
    $id = addslashes($_POST['docid']);
    $nomedr = addslashes($_POST['nomedr']);
    $data = addslashes($_POST['data']);
    $crm = addslashes($_POST['crm']);


    $statusQualidade = 'EM ANÁLISE';
    $statusEnvio = 'ENVIADO';

    sendAnexoIIIDr($conn, $id, $nomecriador, $tp_contacriador, $nomedr, $crm, $data, $statusQualidade, $statusEnvio);
    
} else {
    header("location: ../anexoidr");
    exit();
}
