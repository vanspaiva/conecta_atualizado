<?php

if (isset($_POST["submit"])) {
    require_once 'dbh.inc.php';
    require_once 'functionsqualidade.inc.php';

    $nomecriador = addslashes($_POST['nomecriador']);
    $tp_contacriador = addslashes($_POST['tp_contacriador']);
    $dtcriacao = addslashes($_POST['dtcriacao']);
    $id = addslashes($_POST['docid']);
    $nomepac = addslashes($_POST['nomepac']);
    $data = addslashes($_POST['data']);
   


    $statusQualidade = 'EM ANÁLISE';
    $statusEnvio = 'ENVIADO';

    sendAnexoIIIPac($conn, $id, $nomecriador, $tp_contacriador, $nomepac, $data, $statusQualidade, $statusEnvio);
    
} else {
    header("location: ../anexoidr");
    exit();
}
