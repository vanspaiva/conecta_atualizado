<?php

require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

$nome = 'Vanessa';
$cel = "+5561983652810";

//definir data atual
date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$hoje = new DateTime("now", $dtz);

//data referencia
$date1 = date_create("2022-05-25");
//formatar data referencia
$data = $date1->format("d/m/Y");

//diferença entre as datas
$diff = date_diff($hoje, $date1);
$diff = $diff->format("%R%a days");

//texto envio msg
$content = 'Olá, ' . $nome . '! Gostaria de lembrar que sua video está agendada para o dia ' . $data;


//regra para envio msg
if ($diff > 0) {
    sendNotification($cel, $content);
}
