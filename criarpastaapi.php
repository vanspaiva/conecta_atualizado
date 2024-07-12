<?php

$url = 'https://webhooks.integrately.com/a/webhooks/48d7661813e34bd294a089ea6309f645?';


$id = addslashes($_GET["id"]);
$dt = addslashes($_GET["data"]);
$uf = addslashes($_GET["uf"]);
$nomedr = addslashes($_GET["nomedr"]);
$nomepac = addslashes($_GET["nomepac"]);

$data = array(
    'idprop' => $id,
    'data' => $dt,
    'uf' => $uf,
    'nomedr' => $nomedr,
    'nomepac' => $nomepac

);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */
} else {
    header("location: update-plan?id=" . $id . "&error=pastacriada");
    exit();
}
