<?php


if (isset($_POST["agendar"])) {

    $opvideo = addslashes($_POST['op-video']);

    switch ($opvideo) {
        case '1':
            $tipovideo = '1ª Video';
            break;

        case '2':
            $tipovideo = 'Remarcar';
            break;

        default:
        $tipovideo = 'undefined';
        break;
            break;
    }

    $user = addslashes($_POST['user']);
    $projeto = addslashes($_POST['projeto']);
    $doutor = addslashes($_POST['doutor']);
    $pac = addslashes($_POST['pac']);
    $produto = addslashes($_POST['produto']);
    $truedate = addslashes($_POST['truedate']);
    $truetime = addslashes($_POST['truetime']);
    $cdghora = addslashes($_POST['timecode']);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    updateAgenda($conn, $tipovideo, $user, $projeto, $doutor, $pac, $produto, $truedate, $truetime, $cdghora);

} else{
    header("location: ../casos");
    exit();
} 

