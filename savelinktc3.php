<?php
header("Content-Type:application/json");
require_once 'includes/dbh.inc.php';

$id = $_POST['id'];
$linkqualidade = $_POST['linkqualidade'];
$linkplanejamento = $_POST['linkplanejamento'];


$sql1 = "UPDATE filedownload SET fileCdnUrl='$link' WHERE fileNumPropRef='$id'";
mysqli_query($conn, $sql1);

$sql2 = "UPDATE filedownloadlaudo SET fileCdnUrl='$link' WHERE fileNumPropRef='$id'";
mysqli_query($conn, $sql2);

response(200, "Link salvo", $id);

function response($status, $status_message, $data)
{
    header("HTTP/1.1 " . $status);

    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    echo $json_response;
}