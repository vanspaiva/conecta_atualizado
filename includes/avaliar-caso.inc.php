<?php ob_start();
if (isset($_POST["avaliarprojeto"])) {

    $casoId = addslashes($_POST['casoId']);
    $ped = addslashes($_POST['ped']);
    $opaceite = addslashes($_POST['op-aceite']);
    $user = addslashes($_POST['user']);
    
    if (empty($_POST["coment-txt-aceite"])) {
        $comenttxtaceite = null;
    } else {
        $comenttxtaceite = addslashes($_POST["coment-txt-aceite"]);
    }

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit();

    newAvaliacaoCaso($conn, $casoId, $ped, $opaceite, $comenttxtaceite, $user);
} else {
    header("location: ../laudos");
    exit();
}
