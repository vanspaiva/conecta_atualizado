<?php
require_once 'includes/dbh.inc.php';

// $ret = mysqli_query($conn, "SELECT * FROM aluno");
$ret = mysqli_query($conn, "SELECT * FROM aluno");
while ($row = mysqli_fetch_array($ret)) {
    $nome = $row["nome"];
    $tel = $row["tel"];
    $email = $row["email"];

    send_certificado($nome, $tel, $email);
}

function send_certificado($nome, $tel, $email)
{
    //Link live API
    $url = 'https://webhooks.integrately.com/a/webhooks/3d7c309b9f1c44bfaef866a605972b53?';

    $data = array(
        'nome' => $nome,
        'tel' => $tel,
        'email' => $email
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
    }
}

header("location: certificados?error=sentall");
exit();
