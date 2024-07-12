<?php
require 'includes/phpmailer/PHPMailerAutoload.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

if (isset($_SESSION["useruid"])) {

    // $to = 'vanessa.paiva@fixgrupo.com.br';
    // $from_name = 'CPMH Digital';
    // $from = 'notificacao@dev.conecta.cpmhdigital.com.br';
    // $subject = "Nova proposta";
    // $body = "Teste 2\n\n";

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;

    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 465;
    $mail->Username = 'notificacao@dev.conecta.cpmhdigital.com.br';
    $mail->Password = 'Senha123';

    //   $path = 'reseller.pdf';
    //   $mail->AddAttachment($path);

    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addReplyTo('negocios@cpmh.com.br', 'CPMH igital');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        header("Location: index?wentwrong");
    } else {
        header("Location: index?mailsend");
    }

    // function smtpmailer($to, $from, $from_name, $subject, $body)
    // {

    // }

    // $to   = '';
    // $from = '';
    // $name = '';
    // $subj = 'PHPMailer 5.2 testing from DomainRacer';
    // $msg = 'This is mail about testing mailing using PHP.';
    // smtpmailer($to, $from, $name, $subj, $msg);



} else {
    header("location: index");
    exit();
}
