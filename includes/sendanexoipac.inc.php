<?php

if (isset($_POST["submit"])) {

    require_once 'dbh.inc.php';
    require_once 'functionsqualidade.inc.php';

    $nomecriador = addslashes($_POST['nomecriador']);
    $tp_contacriador = addslashes($_POST['tp_contacriador']);
    $dtcriacao = addslashes($_POST['dtcriacao']);
    $id = addslashes($_POST["docid"]);

    $nomepac = addslashes($_POST['nomepac']);
    $identidade = addslashes($_POST['identidade']);
    $orgaoid = addslashes($_POST['orgaoid']);
    $cpf = addslashes($_POST['cpf']);
    $reside = addslashes($_POST['reside']);
    $bairro = addslashes($_POST['bairro']);
    $cidade = addslashes($_POST['cidade']);
    $estado = addslashes($_POST['estado']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);

    $statusQualidade = 'EM ANÁLISE';
    $statusEnvio = 'ENVIADO';

    sendAnexoIPac($conn, $id, $nomecriador, $tp_contacriador, $nomepac, $identidade, $orgaoid, $cpf, $residente, $bairro, $cidade, $estado, $telefone, $email, $statusQualidade, $statusEnvio);    




} else {
    header("location: ../anexoipac");
    exit();
}