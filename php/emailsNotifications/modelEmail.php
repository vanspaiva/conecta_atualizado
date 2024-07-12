<?php
include("phpmailer/class.phpmailer.php");

function email($para_email, $para_nome, $assunto, $html)
{

    $mail2 = new PHPMailer;
    $mail2->IsSMTP();

    /*
        $mail2->Host = "smtp.mybotgram.com";
        $mail2->Port = 587;
        $mail2->SMTPAuth = true;
        $mail2->Username = "email";
        $mail2->Password = "senha";
        $mail2->Subject = $assunto;
    */

    $mail2->From = "email";
    $mail2->FromName = "none";

    $mail2->AddAddress($para_email, $para_nome);


    $mail2->Subject = $assunto;
    $mail2->AltBody = "Para ver essa mensagem, use um rograma compatível com HTML";

    $mail2->MsgHTML($html);


    if ($mail2->Send()) {
        return "1";
    } else {
        return $mail2->ErrorInfo;
    }
}


$corpo_email = "
<html>
    <body>
        <p>Olá esse é um teste de envio de e-mail</p>
    </body>
</html>";

$controle = email("email@email.com", "Nome", "Teste de envio", $corpo_email);



if ($controle == "1") {
    echo "Envio OK";
} else {
    echo $controle;
}
