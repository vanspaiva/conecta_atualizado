<?php

header("Content-Type:application/json");
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

$link = $_GET['link'];

$save = salvarArquivo($conn, $link);

if ($save) {
    echo http_response_code(200);
} else {
    echo http_response_code(500);
}
