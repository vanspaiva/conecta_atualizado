<?php
if (isset($_POST["send"])) {

    $opAvaliacao = addslashes($_POST['op-avalicao']);
    $projeto = addslashes($_POST['projeto']);
    
    if (empty($_POST["coment-txt-avaliacao"])) {
        $coment = null;
    } else { 
        $coment = addslashes($_POST['coment-txt-avaliacao']);
    }

    switch ($opAvaliacao) {
        case '1':
            $resposta = 'Não Melhorar';
            break;

        case '0':
            $resposta = 'Melhorar';
            break;

        default:
        $resposta = 'undefined';
        break;
            break;
    }


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    updateAvaliacao($conn, $projeto, $resposta, $coment);

} else{
    header("location: ../casos");
    exit();
} 

