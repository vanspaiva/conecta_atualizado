<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
    ob_start();
    include("php/head_index.php");


    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);

    //Muda Status da Proposta
    $novoStatus = 'PROP. ENVIADA';
    $sql = "UPDATE propostas SET propStatus='$novoStatus' WHERE propId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../comercial?error=edit");
    } else {
        header("location: ../comercial?error=stmfailed");
    }

    //Pesquisa proposta
    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $id . "';");
    while ($row = mysqli_fetch_array($ret)) {
        $email = $row['propEmailEnvio'];
        $nome = $row['propUserCriacao'];
        $produto = $row['propTipoProd'];
        $empresa = $row['propEmpresa'];
        $nomedr = $row['propNomeDr'];
        $nomepac = $row['propNomePac'];
        $conv = $row['propConvenio'];
        $uf = $row['propUf'];
        $representante = $row['propRepresentante'];
        $crm = $row['propNConselhoDr'];
        $telefone = $row['propTelefoneDr'];
        $emaildr = $row['propEmailDr'];
        $emailenvio = $row['propEmailEnvio'];
        $listaItens = $row['propListaItens'];
        $validade = $row['propValidade'];
    }

    sendPropCliente($id, $nome, $empresa, $novoStatus, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $conv, $listaItens, $produto, $validade, $uf, $representante);

    // $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $nome . "';");
    // while ($rowUser = mysqli_fetch_array($retUser)) {
    //     $nomeCompletoBD = $rowUser['usersName'];
    // }

    // $primeiroNome = explode(" ", $nomeCompletoBD);
    // $primeiroNome = $primeiroNome[0];

    // //Variáveis

    // // $nome = $_POST['name'];
    // // $email = $_POST['email'];
    // // $mensagem = $_POST['comments'];
    // // $data_envio = date('d/m/Y');
    // // $hora_envio = date('H:i:s');


    // $data_envio = date('d/m/Y');
    // $hora_envio = date('H:i:s');

    // // Campo E-mail
    // $arquivo = '
    // <html>
    //     <head>
    //         <link rel="preconnect" href="https://fonts.googleapis.com">
    //         <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    //         <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    //         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    //         integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    //         <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    //         integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    //         crossorigin="anonymous"></script>
    //         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    //         integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    //         crossorigin="anonymous"></script>
    //         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    //         integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    //         crossorigin="anonymous"></script>
    //     </head>
    //     <style>
    //         html,
    //         body,
    //         .container-fluid {
    //             margin: 0;
    //             padding: 0;
    //             border: 0;
    //             font-size: 100%;
    //             font: inherit;
    //             vertical-align: baseline;

    //         }
    //     </style>

    //     <body>
    //         <div class="container-fluid box mb-1">
    //             <div class="container py-2">

    //                 <div class="row d-flex justify-content-center">
    //                     <h1 class="p-2" style="font-weight: 500px; font-family: Montserrat, sans-serif; color: #000000;" ><b>Proposta Liberada</b></h1>
    //                 </div>
    //             </div>
    //         </div>
    //         <div class="container-fluid py-4">
    //             <div class="container">
    //                 <div class="row d-flex justify-content-center">
    //                     <div class="d-block ">
    //                         <h3 class="p-2" style="font-weight: 300px; font-family:  Montserrat, sans-serif; color: #000000;"><b>Olá ' .
    //     $primeiroNome . '!</b></h3>
    //                     </div>
    //                 </div>
    //                 <div class="row d-flex justify-content-center">
    //                     <p class="text-center p-1" style="font-weight: 300px; font-family:  Montserrat, sans-serif; color: #000000;">Sua
    //                         proposta de Nº ' . $id . ' foi liberada para aprovação.</p>
    //                     <p class="text-center p-1" style="font-weight: 300px; font-family:  Montserrat, sans-serif; color: #000000;">
    //                         <a
    //                             href="https://dev.conecta.cpmhdigital.com.br/minhassolicitacoes">Clique aqui</a> para acessar sua
    //                         proposta no posrtal Conecta.</p>
    //                     <p class="text-center p-1" style="font-weight: 300px; font-family:  Montserrat, sans-serif; color: #000000;">
    //                         Certifique-se de estar logado na sua conta e confira se a proposta está conforme sua solicitação.
    //                         Para maior agilidade você poderá fazer o aceite da proposta diretamente pelo portal.
    //                     </p>
    //                 </div>
    //                 <div class="row d-flex justify-content-center">
    //                     <div class="col">
    //                         <div class="d-flex justify-content-center">
    //                             <table class="table table-striped" style="width: 300px; text-align: center;">
    //                                 <tbody>
    //                                     <tr>
    //                                         <td style="text-align: start; font-family: Montserrat, sans-serif; color: #000000;">Produto: </td>
    //                                         <td style="text-align: center; font-family: Montserrat, sans-serif; color: #000000;">' . $produto .
    //     '</td>
    //                                     </tr>
    //                                     <tr>
    //                                         <td style="text-align: start; font-family: Montserrat, sans-serif; color: #000000;">Empresa: </td>
    //                                         <td style="text-align: center; font-family: Montserrat, sans-serif; color: #000000;">' . $empresa .
    //     '</td>
    //                                     </tr>
    //                                     <tr>
    //                                         <td style="text-align: start; font-family: Montserrat, sans-serif; color: #000000;">Dr(a): </td>
    //                                         <td style="text-align: center; font-family: Montserrat, sans-serif; color: #000000;">' . $nomedr . '
    //                                         </td>
    //                                     </tr>
    //                                     <tr>
    //                                         <td style="text-align: start; font-family: Montserrat, sans-serif; color: #000000;">Pac: </td>
    //                                         <td style="text-align: center; font-family: Montserrat, sans-serif; color: #000000;">' . $nomepac .
    //     '</td>
    //                                     </tr>
    //                                     <tr>
    //                                         <td style="text-align: start; font-family: Montserrat, sans-serif; color: #000000;">Convênio:</td>
    //                                         <td style="text-align: center; font-family: Montserrat, sans-serif; color: #000000;">' . $conv . '
    //                                         </td>
    //                                     </tr>
    //                                     <tr>
    //                                         <td style="text-align: start; font-family: Montserrat, sans-serif; color: #000000;">UF: </td>
    //                                         <td style="text-align: center; font-family: Montserrat, sans-serif; color: #000000;">' . $uf . '
    //                                         </td>
    //                                     </tr>
    //                                     <tr>
    //                                         <td style="text-align: start; font-family: Montserrat, sans-serif; color: #000000;">Representante:
    //                                         </td>
    //                                         <td style="text-align: center; font-family: Montserrat, sans-serif; color: #000000;">' .
    //     $representante . '</td>
    //                                     </tr>

    //                                 </tbody>
    //                             </table>
    //                         </div>
    //                         <div class="d-block d-flex justify-content-center">
    //                             <small style="font-family: Montserrat, sans-serif; color: gray; text-align: center;">Caso você
    //                                 não tenha solicitado essa proposta, mude sua senha na plataforma para sua segurança e nos
    //                                 notifique para verificação de segurança do uso do seu cadastro.</small>
    //                         </div>
    //                     </div>

    //                 </div>
    //             </div>
    //         </div>

    //         <div class="container-fluid my-4">
    //             <div class="container">
    //                 <div class="row d-flex justify-content-center">
    //                     <div class="d-block">
    //                         <small style="font-family: Montserrat, sans-serif; color: gray; text-align: center;">&copy; Portal
    //                             Conecta 2021</small>
    //                     </div>
    //                 </div>
    //             </div>
    //         </div>



    //     </body>


    // </html>';

    // //enviar

    // // sendEmailNotificationCreateProposta($conn, $idprop, $nomecriador);

    // //Envio E-mail para user criador
    // $tipoNotificacao = 'email';
    // $idMsg = 7;
    // $itemEnvio = intval($id);

    // sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    // // // emails para quem será enviado o formulário
    // // // $emailenviar = $email;
    // // $destino = $email;
    // // $assunto = "Proposta Liberada - Conecta";

    // // // É necessário indicar que o formato do e-mail é html
    // // $headers  = 'MIME-Version: 1.0' . "\r\n";
    // // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // // // $headers .= 'From: Portal Conecta';
    // // //$headers .= "Bcc: $EmailPadrao\r\n";

    // // $enviaremail = mail($destino, $assunto, $arquivo, $headers);
    // // if ($enviaremail) {
    // //     // echo "<script>alert('Seu email foi enviado com sucesso!'); </script>";
    // //     header("Location: comercial?error=sent");
    // // } else {
    // //     header("Location: comercial?error=senteerror");
    // // }
    header("Location: comercial?error=sent");
} else {
    header("location: index");
    exit();
}
