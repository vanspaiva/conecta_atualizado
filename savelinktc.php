<?php

header("Content-Type:application/json");
require_once 'includes/dbh.inc.php';

$idhashed = addslashes($_POST['id']);
$link = addslashes($_POST['link']);

// $idhashed = '%24%8B%F2%88_%87%ED6%7F%3B%A0c%A5%86%A4%8C%3Avj5Qm1PKZ3VfdfV66viYsw%3D%3D';
// $link = 'google.com';

// // decrypt to get again $plaintext
// $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
// $idhashed = urldecode($idhashed);
// $parts = explode(':', $idhashed);
// $id = openssl_decrypt($parts[0], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, base64_decode($parts[1]));


$queryID = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef='$id'");
if (mysqli_num_rows($queryID) > 0) {
    while ($row = mysqli_fetch_assoc($queryID)) {

        $sql = "UPDATE filedownload SET fileCdnUrl='$link' WHERE fileNumPropRef='$id'";
        mysqli_query($conn, $sql);
        response(200, "Link salvo", $id);
        header("location: ../update-plan?id=" . $id);
    }
} else {
    response(200, "Id não encontrado", $id);
    header("location: ../update-plan?id=" . $id . "&error=stmfailed");
}

function response($status, $status_message, $data)
{
    header("HTTP/1.1 " . $status);

    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    echo $json_response;
}

// 142 - https://conecta.cpmhdigital.com.br/savelinktc?idhashed=%F77u%E0%A2%E3%8EF%AE%01I%F7%99a%94%A3%3A%2FWHY0D0npEyQFnkS3v%2BEPQ%3D%3D&link=https://drive.google.com/drive/folders/1IrbcZsVoedps1E3ESm_7HaWKT247HTon
// 145 - https://conecta.cpmhdigital.com.br/savelinktc?idhashed=9%A3%8A%A5%A1%1E%9B%97o%DA%9E%7Dk%B8%24%EC%3APP7F%2FkQaVjOQQrMmVfF8Zg%3D%3D&link=https://drive.google.com/drive/folders/1pXyvXbLBhaAZaVZKoXDRny_iqsPWsQ7x
// 148 - https://conecta.cpmhdigital.com.br/savelinktc?idhashed=%8C%AE%CB%5D%C4%CC%0E%04%3A%02%01%C3%21o%F6%13%3AOjxVfSOsOJeSWLRYDXvCWQ%3D%3D&link=https://drive.google.com/drive/folders/1PVxF5CGtXGq8Yv7LuzPlqjdkfpsDj2Iw
// 149 - https://conecta.cpmhdigital.com.br/savelinktc?idhashed=%02T%E1%C6G%98%9D%01s%3D%19%FD%C2U%90%F3%3AwYruwE4BlRpHb9SqfRZVuA%3D%3D&link=https://drive.google.com/drive/folders/1UQ5Vh8Hj5t6PJhzrk-H75aMSgv9vLEsB
