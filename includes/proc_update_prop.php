<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

$id = $_POST['id'];
$empresa = $_POST['empresa'];
$cnpj = $_POST['cnpj'];
$status = $_POST['status'];
$usercriacao = $_POST['userCriador'];
$nomedr = $_POST['nomedr'];
$crm = $_POST['crm'];
$telefone = $_POST['telefone'];
$emaildr = $_POST['emaildr'];
$emailenvio = $_POST['emailenvio'];
$nomepac = $_POST['nomepac'];
$convenio = $_POST['convenio'];
$tipoProd = $_POST['tipoProd'];
$validade = $_POST['validade'];
$ufProp = $_POST['ufProp'];
$representante = $_POST['representante'];
$pedido = $_POST['pedido'];
$listaIdsItens = $_POST['listaIdsItens'];
$listaItens = $_POST['listaItens'];
$listaValoresItens = $_POST['listaValoresItens'];
$planovendas = $_POST['planovendas'];
$listaQtdsItens = $_POST['listaQtdsItens'];
$valorTotalItens = $_POST['valorTotalItens'];
// $valorTotalParafusos = $_POST['valorTotalParafusos'];
$valorTotal = $_POST['valorTotal'];
$porcentagemDesconto = $_POST['porcentagemDesconto'];
$valorDesconto = $_POST['valorDesconto'];
$valorTotalPosDesconto = $_POST['valorTotalPosDesconto'];
$nomeenvio = $_POST["nomeenvio"];
$telenvio = $_POST["telenvio"];
// $textComercial = $_POST["textComercial"];


$sql = "UPDATE propostas SET propEmpresa='$empresa', propStatus='$status', propNomeDr='$nomedr', propNConselhoDr='$crm', propTelefoneDr='$telefone', propEmailDr='$emaildr', propEmailEnvio='$emailenvio', propNomePac='$nomepac', propConvenio='$convenio', propTipoProd='$tipoProd', propValidade='$validade', propUf='$ufProp', propRepresentante='$representante', propPedido='$pedido', propValorSomaItens='$valorTotalItens', propValorSomaTotal='$valorTotal', propDesconto='$porcentagemDesconto', propoValorDesconto='$valorDesconto', propValorPosDesconto='$valorTotalPosDesconto', propPlanoVenda='$planovendas', propNomeEnvio='$nomeenvio', propTelEnvio='$telenvio', propCnpjCpf='$cnpj' WHERE propId ='$id'";

mysqli_query($conn, $sql);


if ($status == 'PROP. ENVIADA') {
    sendPropCliente($id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante);
}

if ($status == 'PEDIDO') {


    createModuloII($conn, $id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante, $pedido, $drrespuid, $cnpj);
    //Envio E-mail para user criador
    $tipoNotificacao = 'email';
    $idMsg = 13;
    $itemEnvio = intval($id);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    

    //Envio E-mail para user planejamento
    $tipoNotificacao = 'email';
    $idMsg = 14;
    $itemEnvio = intval($id);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);
}


$itensId = explode('/', $listaIdsItens);
$itens = explode('/', $listaItens);
$itensValores = explode('/', $listaValoresItens);
$qtds = explode('/', $listaQtdsItens);

for ($i = 0; $i <= sizeof($itens); $i++) {
    $itenid = $itensId[$i];
    $item = $itens[$i];
    $valor = $itensValores[$i];
    $qtd = $qtds[$i];

    $sqlitens = "UPDATE itensproposta SET itemValor='$valor', itemQtd='$qtd' WHERE itemId='$itenid';";
    mysqli_query($conn, $sqlitens);
}

mysqli_close($conn);
verifyStatusProp($conn, $id);

// header("location: update-proposta?id=".$id);
// exit();