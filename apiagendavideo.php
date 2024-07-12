<?php

header("Content-Type:application/json");
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';


//print_r($_POST);


$opvideo = addslashes($_POST['tipovideo']);

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

$user = addslashes($_POST['usuario']);
$projeto = addslashes($_POST['projeto5']);
$doutor = addslashes($_POST['doutor']);
$paciente = addslashes($_POST['paciente']);
$produto = addslashes($_POST['produto']);
$dateANDtime = addslashes($_POST['agendamentode']['date']);
$duracao = addslashes($_POST['agendamentode']['duration']);
// print_r($dateANDtime);
// echo "\n";

$newdateANDtime = explode(" ", $dateANDtime);
$data = $newdateANDtime[0];
$hora = $newdateANDtime[1];

$hora = explode(":", $hora);
$hora[0] = intval($hora[0]) + 1;
$hora = $hora[0] . ":" . $hora[1];

// print_r($data);
// echo "\n";
// print_r($hora);

// exit();

saveAgenda($conn, $tipovideo, $user, $projeto, $doutor, $paciente, $produto, $data, $hora, $duracao);
