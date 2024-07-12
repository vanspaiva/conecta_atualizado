<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

//Envio E-mail para user criador
$tipoNotificacao = 'email';
$idMsg = '4';
$itemEnvio = 136;

sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);
