<?php


if (isset($_POST["agendar"])) {

    $tipo = addslashes($_POST['tipo']);
    $user = addslashes($_POST['user']);
    $email = addslashes($_POST['email']);
    $doutor = addslashes($_POST['doutor']);
    $pac = addslashes($_POST['pac']);
    $produto = addslashes($_POST['produto']);
    $truedate = addslashes($_POST['truedate']);
    $truetime = addslashes($_POST['truetime']);
    $cdghora = addslashes($_POST['timecode']);
    $obs = addslashes($_POST['obs']);
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    updateAgendaTecnica($conn, $tipo, $user, $doutor, $pac, $produto, $truedate, $truetime, $cdghora, $email, $obs);

} else{
    header("location: ../agendartecnicacir");
    exit();
} 

