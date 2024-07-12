<?php
if (isset($_POST["submit"])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $id = addslashes($_POST["id"]);
    $comentario = addslashes($_POST["comentario"]);
    $status = addslashes($_POST["status"]);


    $data = getAllDataQualificacao($conn, $id);



    editQualificacao($conn, $id, $comentario, $status);

    switch ($status) {
        case 'Enviado':
            //nada
            break;
        case 'Analisar':
            //nada
            break;
        case 'Qualificado':
            //envia email de qualificado
            editPropostaFromQualificacao($conn, $data);
            //pesquisa todas as propostas do usuario que tem status = 'AGUARDANDO QUALIFICACAO'
            //MUDA PARA 'CLIENTE QUALIFICADO'

            break;
        case 'Recusado':
            //reenvia email com msg
            // //Enviar Email Link para Cliente
            // $tipoNotificacao = 'email';
            // $idMsg = 22;
            // $itemEnvio = intval($id);

            // sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

            criarRegistroEnvioQualificacao($conn, $data["qualiUsuario"]);
            notificarQualificacaoClienteSlack($conn, $data["qualiUsuario"], $id, $status, $null);
            break;
    }

    header("location: ../qualificacaocliente?error=none");
} else {
    header("location: ../qualificacaocliente");
    exit();
}
