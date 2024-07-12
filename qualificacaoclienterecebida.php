<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

$data = $_POST;
// print_r($data);

// exit();

$id = addslashes($_POST['id']);

//mudar status em qualificacaocliente para pendente
// changeQualificacaoCliente($conn, $id, $data);
qualificacaoRecebida($conn, $id, $data);

header("location: agradecimentoqualificacao");
exit();
