<?php

header("Content-Type:application/json");
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

$link1 = $_GET['link1'];
$link2 = $_GET['link2'];
$id = $_GET['id'];

$plan = editLinkPlan($conn, $id, $link1);

$quali = editLinkQuali($conn, $id, $link2);

if ($plan && $quali) {
    echo http_response_code(200);
} else {
    echo http_response_code(500);
}

