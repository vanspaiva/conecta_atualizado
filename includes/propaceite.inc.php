<?php ob_start();
include("../php/head_index.php");

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST["submit"])) {

    $id = addslashes($_POST['propid']);
    $nomeusuario = addslashes($_POST['useruid']);
    $ip = addslashes($_POST['userip']);
    $data = addslashes($_POST['datacriacao']);
    $pgto = addslashes($_POST['pgto']);
    $meiotransporte = addslashes($_POST['transporte']);
    $observacao = addslashes($_POST['observacoes']);

    if (empty($_FILES["finfile"]["name"])) {
        $pname = null;
        $tname = null;
        $ext = null;
    } else {
        #file name with a random number so that similar dont get replaced
        $original_name = $_FILES["finfile"]["name"];
        $pname = rand(1000, 10000) . "-" . $_FILES["finfile"]["name"];

        #temporary file name to store file
        $tname = $_FILES["finfile"]["tmp_name"];
        $ext = pathinfo($original_name, PATHINFO_EXTENSION);
    }

    userAceiteProp($conn, $id, $nomeusuario, $data, $ip, $pgto, $tname, $pname, $ext, $meiotransporte, $observacao);
} else {
    header("location: ../index");
    exit();
}
