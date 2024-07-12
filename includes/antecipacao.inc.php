<?php ob_start();
if (isset($_POST["submit"])) {

    $user = addslashes($_POST['user']);
    $nped = addslashes($_POST['nped']);
    $produto = addslashes($_POST['produto']);
    

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    newAntecipacao($conn, $user, $nped, $produto);

} else{
    header("location: ../casos");
    exit();
} 

