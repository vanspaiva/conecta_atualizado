<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';
session_start();

// print_r($_SESSION);
//print_r($_POST);
//exit();

$id = addslashes(trim($_POST['id']));
$empresa = addslashes(formatarNome(trim($_POST['empresa'])));
$cnpj = addslashes(trim($_POST['cnpj']));
$status = addslashes(trim($_POST['status']));
$usercriacao = addslashes(trim($_POST['userCriador']));
$nomedr = addslashes(formatarNome(trim($_POST['nomedr'])));
$crm = addslashes(trim($_POST['crm']));
$telefone = addslashes(trim($_POST['telefone']));
$emaildr = addslashes(strtolower(trim($_POST['emaildr'])));
$emailenvio = addslashes(strtolower(trim($_POST['emailenvio'])));
$nomepac = addslashes(strtoupper(tirarEspaco(tirarDots(trim($_POST['nomepac'])))));
$convenio = addslashes(trim($_POST['convenio']));
$tipoProd = addslashes(trim($_POST['tipoProd']));
$validade = addslashes(trim($_POST['validade']));
$ufProp = addslashes(trim($_POST['ufProp']));
$representante = addslashes(trim($_POST['representante']));
$pedido = addslashes(trim($_POST['pedido']));
$listaIdsItens = addslashes(trim($_POST['listaIdsItens']));
$listaItens = addslashes(trim($_POST['listaItens']));
$listaValoresItens = addslashes(trim($_POST['listaValoresItens']));
$planovendas = addslashes(trim($_POST['planovendas']));
$listaQtdsItens = addslashes(trim($_POST['listaQtdsItens']));
$valorTotalItens = addslashes(trim($_POST['valorTotalItens']));
// $valorTotalParafusos = $_POST['valorTotalParafusos'];
$valorTotal = addslashes(trim($_POST['valorTotal']));
$porcentagemDesconto = addslashes(trim($_POST['porcentagemDesconto']));
$valorDesconto = addslashes(trim($_POST['valorDesconto']));
$valorTotalPosDesconto = addslashes(trim($_POST['valorTotalPosDesconto']));
$nomeenvio = addslashes(trim($_POST["nomeenvio"]));
$telenvio = addslashes(trim($_POST["telenvio"]));
//$textComercial = addslashes(trim($_POST["textComercial"]));
$drrespuid = addslashes(trim($_POST["drrespuid"]));
$loteop = addslashes(trim($_POST["loteop"]));


date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$dataAtual = $dt->format("Y-m-d") . " " . $dt->format("H:i:s");

$numprop = $id;
$user = $_SESSION['useruid'];
$date = $dataAtual;

registerstatusproposta($conn, $status, $numprop, $user, $date);


$data = array(
    'id' => $id,
    'empresa' => $empresa,
    'cnpj' => $cnpj,
    'status' => $status,
    'usercriacao' => $usercriacao,
    'nomedr' => $nomedr,
    'crm' => $crm,
    'telefone' => $telefone,
    'emaildr' => $emaildr,
    'emailenvio' => $emailenvio,
    'nomepac' => $nomepac,
    'convenio' => $convenio,
    'tipoProd' => $tipoProd,
    'validade' => $validade,
    'ufProp' => $ufProp,
    'representante' => $representante,
    'pedido' => $pedido,
    'listaIdsItens' => $listaIdsItens,
    'listaItens' => $listaItens,
    'listaValoresItens' => $listaValoresItens,
    'planovendas' => $planovendas,
    'listaQtdsItens' => $listaQtdsItens,
    'valorTotalItens' => $valorTotalItens,
    'valorTotal' => $valorTotal,
    'porcentagemDesconto' => $porcentagemDesconto,
    'valorDesconto' => $valorDesconto,
    'valorTotalPosDesconto' => $valorTotalPosDesconto,
    'nomeenvio' => $nomeenvio,
    'telenvio' => $telenvio,
    // 'textComercial' => $textComercial,
    'drrespuid' => $drrespuid,
    'loteop' => $loteop
);


if ($drrespuid != null) {
    $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid=" . $drrespuid . ";");
    if (($searchUser) && ($searchUser->num_rows != 0)) {
        while ($rowUser = mysqli_fetch_array($searchUser)) {
            $nomedr = trim($rowUser['usersName']);
            $crm = trim($rowUser['usersCrm']);
            $telefone = trim($rowUser["usersFone"]);
            $emaildr = trim($rowUser["usersEmail"]);
        }
    }
}

// print_r($status);
// exit();

switch ($status) {
    case 'PENDENTE':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'EM ANÁLISE':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'PROP. ENVIADA':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        sendPropCliente($id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante);
        break;
    case 'APROVADO':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'PEDIDO':
        $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$pedido'");
        $num_rows = mysqli_num_rows($ret);
        // print_r($ret);
        // exit();
        if (($ret) && ($ret->num_rows != 0)) {
            atualizarProp($conn, $data, $id);
            atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
            exit();
        } else {
            atualizarPropPedido($conn, $data, $id);
            atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);

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

        break;
    case 'CANCELADO':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'JÁ COTADO':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'NÃO COTAR':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'AGUARD. INFOS ADICIO':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'COTADO OUTRO DIST':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'DPS':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'PRÉ PEDIDO':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;
    case 'AGUARD. QUALIFICAÇÃO':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);

        $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiUsuario='$usercriacao'");
        if (($ret) && ($ret->num_rows != 0)) {
            //EXISTE

            //verifica status
            $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiUsuario='$usercriacao'");
            while ($row = mysqli_fetch_array($ret)) {
                $statusQualificacao = $row['qualiStatus'];
            }

            switch ($statusQualificacao) {
                case 'Enviado': //Enviar email novamente
                    //Enviar Email Link para Cliente
                    $tipoNotificacao = 'email';
                    $idMsg = 22;
                    $itemEnvio = intval($id);

                    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

                    criarRegistroEnvioQualificacao($conn, $usercriacao);
                    notificarQualificacaoClienteSlack($conn, $usercriacao, $id, $statusQualificacao, $null);
                    break;

                case 'Analisar':
                    //Enviar msg Slack Qualidade
                    notificarQualificacaoClienteSlack($conn, $usercriacao, $id, $statusQualificacao, $null);
                    break;

                case 'Qualificado':
                    //Enviar msg Slack Qualidade
                    notificarQualificacaoClienteSlack($conn, $usercriacao, $id, $statusQualificacao, $null);
                    break;
                case 'Recusado': //Enviar Email novamente com msg
                    //Enviar Email Link para Cliente
                    $tipoNotificacao = 'email';
                    $idMsg = 22;
                    $itemEnvio = intval($id);

                    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

                    criarRegistroEnvioQualificacao($conn, $usercriacao);
                    notificarQualificacaoClienteSlack($conn, $usercriacao, $id, $statusQualificacao, $null);
                    break;
                default:
                    break;
            }

            exit();
        } else {
            //NÃO EXISTE

            //Criar novo item em BD Qualificação Cliente
            criarQualificacaoCliente($conn, $data);

            //Enviar Email Link para Cliente
            $tipoNotificacao = 'email';
            $idMsg = 22;
            $itemEnvio = intval($id);

            sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

            //Enviar Email Link para Cliente
            //Enviar Email Copia Qualidade
            //Enviar Email Copia Representante
        }
        break;
    case 'CLIENTE QUALIFICADO':
        atualizarProp($conn, $data, $id);
        atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens);
        break;

    default:
        break;
}

function atualizarProp($conn, $data, $id)
{

    //Atualiza a nova proposta
    $sql = "UPDATE propostas SET propStatus = ?, propEmpresa = ?, propNomeDr = ?, propNConselhoDr = ?, propEmailDr = ?, propTelefoneDr = ?, propNomePac = ?, propConvenio = ?, propEmailEnvio = ?, propTipoProd = ?, propUf = ?, propRepresentante = ?, propValidade = ?, propValorSomaItens = ?, propValorSomaTotal = ?, propDesconto = ?, propoValorDesconto = ?, propValorPosDesconto = ?, propPlanoVenda = ?, propDrUid = ?, propCnpjCpf = ?, propNomeEnvio = ?, propTelEnvio = ?, propTxtComercial = ? WHERE propId ='$id'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=saveerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssss", $data['status'], $data['empresa'], $data['nomedr'], $data['crm'], $data['emaildr'], $data['telefone'], $data['nomepac'], $data['convenio'], $data['emailenvio'], $data['tipoProd'], $data['ufProp'], $data['representante'], $data['validade'], $data['valorTotalItens'], $data['valorTotal'], $data['porcentagemDesconto'], $data['valorDesconto'], $data['valorTotalPosDesconto'], $data['planovendas'], $data['drrespuid'], $data['cnpj'], $data['nomeenvio'], $data['telenvio'], $data['textComercial']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function atualizarPropPedido($conn, $data, $id)
{

    //Atualiza a nova proposta
    $sql = "UPDATE propostas SET propStatus = ?, propEmpresa = ?, propNomeDr = ?, propNConselhoDr = ?, propEmailDr = ?, propTelefoneDr = ?, propNomePac = ?, propConvenio = ?, propEmailEnvio = ?, propTipoProd = ?, propUf = ?, propRepresentante = ?, propValidade = ?, propValorSomaItens = ?, propValorSomaTotal = ?, propDesconto = ?, propoValorDesconto = ?, propValorPosDesconto = ?, propPedido = ?, propPlanoVenda = ?, propDrUid = ?, propCnpjCpf = ?, propNomeEnvio = ?, propTelEnvio = ?, propTxtComercial = ? WHERE propId ='$id'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=saveerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssss", $data['status'], $data['empresa'], $data['nomedr'], $data['crm'], $data['emaildr'], $data['telefone'], $data['nomepac'], $data['convenio'], $data['emailenvio'], $data['tipoProd'], $data['ufProp'], $data['representante'], $data['validade'], $data['valorTotalItens'], $data['valorTotal'], $data['porcentagemDesconto'], $data['valorDesconto'], $data['valorTotalPosDesconto'], $data['pedido'], $data['planovendas'], $data['drrespuid'], $data['cnpj'], $data['nomeenvio'], $data['telenvio'], $data['textComercial']);
    mysqli_stmt_execute($stmt);

    //Criar Pedido
    criarPedido($conn, $data);
}

function atualizarItensProposta($conn, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens)
{

    $itensId = explode('/', $listaIdsItens);
    $itens = explode('/', $listaItens);
    $itensValores = explode('/', $listaValoresItens);
    $qtds = explode('/', $listaQtdsItens);

    for ($i = 0; $i < sizeof($itens); $i++) {
        $itenid = $itensId[$i];
        $item = $itens[$i];
        $valor = $itensValores[$i];
        $qtd = $qtds[$i];

        $sqlitens = "UPDATE itensproposta SET itemValor='$valor', itemQtd='$qtd', itemCdg='$item' WHERE itemId='$itenid';";
        mysqli_query($conn, $sqlitens);
    }
}

function criarPedido($conn, $data)
{
    /*Variáveis Fixas*/
    $statusPedInicial = "CRIADO";
    $valueAbasFechado = "fechado";
    $valueAbasLiberado = "liberado";
    $pedAndamento = 'ABERTO';
    $pedPosicaoFluxoInicial = 0;
    $pedTecnico = '0 Padrão';

    //Criar BD Pedido
    $sql = "INSERT INTO pedido (pedNumPedido, pedPropRef, pedUserCriador, pedRep, pedNomeDr, pedNomePac, pedCrmDr, pedProduto, pedTipoProduto, pedStatus, pedAbaAgenda, pedAbaVisualizacao, pedAbaAceite, pedAbaRelatorio, pedAbaDocumentos, pedAndamento, pedCpfCnpj, pedPosicaoFluxo, pedTecnico, loteop) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailedPED");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssss", $data['pedido'], $data['id'], $data['drrespuid'], $data['representante'], $data['nomedr'], $data['nomepac'], $data['crm'], $data['listaItens'], $data['tipoProd'], $statusPedInicial, $valueAbasFechado, $valueAbasFechado, $valueAbasFechado, $valueAbasFechado, $valueAbasFechado, $pedAndamento, $data['cnpj'], $pedPosicaoFluxoInicial, $pedTecnico, $data['loteop']);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_execute($stmt)) {
        echo "Comando SQL executado com sucesso.";
    } else {
        echo "Erro ao executar comando SQL: " . mysqli_stmt_error($stmt);
    }

    print_r($stmt);
    mysqli_stmt_close($stmt);



    //Módulo II
    criarAgendarModuloII($conn, $data);
    criarVisualizarModuloII($conn, $data);
    criarAceiteModuloII($conn, $data);
    criarFeedbackAceiteModuloII($conn, $data);
    criarAnexoIDrModuloII($conn, $data);
    criarAnexoIPacModuloII($conn, $data);
    criarAnexoIIDrModuloII($conn, $data);
    criarAnexoIIIDrModuloII($conn, $data);
    criarAnexoIIIPacModuloII($conn, $data);
    criarRelatorioModuloII($conn, $data);
    $statusPrazo = 'PCP';
    criarPrazoModuloII($conn, $data, $statusPrazo);
    enviarParaGoogleSheets($data);
    //Envio Slack no grupo Sob_medida
    notificarSlackNovoPedido($data);
    enviarParaKommo($conn,$data);
    
    //registra Log
    $dados = array(
        'tipo' => "pedido",
        'dataAtual' => hoje(),
        'horaAtual' => agora(),
        'usuario' => $_SESSION['useruid'],
        'numero' => $data['pedido'],
        'atividade' => "Pedido Criado"
    );

    logAtividadePedProp($conn, $dados);
}

function enviarParaGoogleSheets($data)
{
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y");

    $datacriacao = $dataAtual;
    $nped = $data['pedido'];
    $nproporef = $data['id'];
    $uiddr = $data['drrespuid'];
    $rep = $data['representante'];
    $dr = $data['nomedr'];
    $pac = $data['nomepac'];
    $crm = $data['crm'];
    $produto = $data['listaItens'];
    $tipoproduto = $data['tipoProd'];
    $cpf = $data['cnpj'];

    $url = 'https://webhooks.integrately.com/a/webhooks/6618f968c79c46a5ba186eb2b52fc501?';

    $data = array(
        'datacriacao' => $datacriacao,
        'nped' => $nped,
        'nproporef' => $nproporef,
        'uiddr' => $uiddr,
        'rep' => $rep,
        'dr' => $dr,
        'pac' => $pac,
        'crm' => $crm,
        'produto' => $produto,
        'tipoproduto' => $tipoproduto,
        'cpf' => $cpf
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

function notificarSlackNovoPedido($data)
{
    require_once 'includes/dbh.inc.php';

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y");

    $uiddr = $data['drrespuid'];



    $datacriacao = $dataAtual;
    $nomedr = $data['nomedr'];
    $nped = $data['pedido'];
    $nproporef = $data['id'];
    $rep = $data['representante'];
    $pac = $data['nomepac'];
    $produto = $data['listaItens'];
    $tipoproduto = $data['tipoProd'];
    $cpf = $data['cnpj'];
    $ufProp = $data['ufProp'];
    $crmdr = $data['crm'];
    $telefonedr = $data['telefone'];
    $emaildr = $data['emaildr'];


    $url = 'https://hooks.zapier.com/hooks/catch/8414821/35cn7fi?';

    $dataSent = array(
        'datacriacao' => $datacriacao,
        'nped' => $nped,
        'nproporef' => $nproporef,
        'uiddr' => $uiddr,
        'rep' => $rep,
        'dr' => $nomedr,
        'pac' => $pac,
        'crm' => $crmdr,
        'produto' => $produto,
        'tipoproduto' => $tipoproduto,
        'cpf' => $cpf,
        'telefonedr' => $telefonedr,
        'ufProp' => $ufProp,
        'emaildr' => $emaildr
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($dataSent)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

function enviarParaKommo($conn,$data)
{
    require_once 'includes/dbh.inc.php';

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("Y-m-d");

    $uiddr = $data['drrespuid'];

    $dadosDr = getAllDataFromRep($conn, $uiddr);

    $nomeDr = $dadosDr["usersName"];
    $emailDr = $dadosDr["usersEmail"];
    $celulareDr = $dadosDr["usersCel"];
    $telefoneDr = $dadosDr["usersFone"];
    $ufDr = $dadosDr["usersUf"];
    $especialidadeDr = $dadosDr["usersEspec"];
    $numped = $data['pedido'];
    $tipoPorduto = $data['tipoProd'];
    $representante = $data['representante'];
    $paciente = $data['nomepac'];


    $url = 'https://webhooks.integrately.com/a/webhooks/5c607e60a1854e0184051c305bb86d8c?';

    $dataSent = array(
        'nomeDr' => $nomeDr,
        'emailDr' => $emailDr,
        'celulareDr' => $celulareDr,
        'telefoneDr' => $telefoneDr,
        'ufDr' => $ufDr,
        'especialidadeDr' => $especialidadeDr,
        'numped' => $numped,
        'tipoPorduto' => $tipoPorduto,
        'representante' => $representante,
        'paciente' => $paciente,
        'dataCriacao' => $dataAtual
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($dataSent)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}


function tirarDots($string)
{
    return str_replace(".", "", $string);
}

function tirarEspaco($string)
{
    return str_replace(" ", "", $string);
}

function criarAgendarModuloII($conn, $data)
{
    //Criar BD Agendar
    $statusAgendaInicial = "VAZIO";
    $sql = "INSERT INTO agenda (agdNumPedRef, agdNomeDr, agdNomPac, agdProd, agdStatus) VALUES (?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedAGD");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $data['pedido'], $data['nomedr'], $data['nomepac'], $data['tipoProd'], $statusAgendaInicial);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarVisualizarModuloII($conn, $data)
{
    //Criar BD Visualização de Projeto
    $statusVisualizacaoInicial = "BLOQUEADO";
    $sql = "INSERT INTO visualizador (visNumPed, visStatus) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedVIS");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $data['pedido'], $statusVisualizacaoInicial);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarAceiteModuloII($conn, $data)
{
    //Criar BD Aceite
    $statusAceiteInicial = "VAZIO";
    $sql = "INSERT INTO aceite (aceiteNumPed, aceiteStatus) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedACE");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $data['pedido'], $statusAceiteInicial);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarFeedbackAceiteModuloII($conn, $data)
{
    //Criar BD Feedback Aceite
    $statusFeedbackAceiteInicial = "VAZIO";
    $sql = "INSERT INTO feedbackaceite (fdaceiteNumPed, fdaceiteStatus) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedACE");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $data['pedido'], $statusFeedbackAceiteInicial);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarAnexoIDrModuloII($conn, $data)
{
    //Tabela anexo i dr qualidade
    $statusAnexoIdr = "VAZIO";
    $sql = "INSERT INTO qualianexoidr (xidrStatusEnvio, xidrIdProjeto) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedQUAIDR");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $statusAnexoIdr, $data['pedido']);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarAnexoIPacModuloII($conn, $data)
{
    //Tabela anexo i pac qualidade
    $statusAnexoIPac = "VAZIO";
    $sql = "INSERT INTO qualianexoipac (xipacStatusEnvio, xipacIdProjeto) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedQUAIPAC");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $statusAnexoIPac, $data['pedido']);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarAnexoIIDrModuloII($conn, $data)
{
    //Tabela anexo ii qualidade
    $statusAnexoII = "VAZIO";
    $sql = "INSERT INTO qualianexoii (xiiStatusEnvio, xiiIdProjeto) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedQUAII");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $statusAnexoII, $data['pedido']);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarAnexoIIIDrModuloII($conn, $data)
{
    //Tabela anexo iii dr qualidade
    $statusAnexoIIIDr = "VAZIO";
    $sql = "INSERT INTO qualianexoiiidr (xiiidrStatusEnvio, xiiidrIdProjeto) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedQUAIIIDR");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $statusAnexoIIIDr, $data['pedido']);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarAnexoIIIPacModuloII($conn, $data)
{
    //Tabela anexo iii pac qualidade
    $statusAnexoIIIPac = "VAZIO";
    $sql = "INSERT INTO qualianexoiiipac (xiiipacStatusEnvio, xiiipacIdProjeto) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        // header("location: ../comercial?error=stmtfailedQUAIIIPAC");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $statusAnexoIIIPac, $data['pedido']);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}

function criarRelatorioModuloII($conn, $data)
{
    //Criar BD Relatórios
    $statusRelatoriosInicial = "VAZIO";
    $sql = "INSERT INTO relatorios (relNumPedRef, relStatus) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $data['pedido'], $statusRelatoriosInicial);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

}







// // salvar log status
// $usuario = $_SESSION["useruid"];
// $origem = "PROPOSTA";
// logStatus($conn, $id, $usuario, $status, $origem);



// if ($num_rows != 0) {
//     header("location: update-proposta?id=" . $id . "&error=pedexist");
//     exit();
// } else {


//     // $sql = "UPDATE propostas SET propEmpresa='$empresa', propStatus='$status', propNomeDr='$nomedr', propNConselhoDr='$crm', propTelefoneDr='$telefone', propEmailDr='$emaildr', propEmailEnvio='$emailenvio', propNomePac='$nomepac', propConvenio='$convenio', propTipoProd='$tipoProd', propValidade='$validade', propUf='$ufProp', propRepresentante='$representante', propPedido='$pedido', propValorSomaItens='$valorTotalItens', propValorSomaTotal='$valorTotal', propDesconto='$porcentagemDesconto', propoValorDesconto='$valorDesconto', propValorPosDesconto='$valorTotalPosDesconto', propPlanoVenda='$planovendas', propNomeEnvio='$nomeenvio', propTelEnvio='$telenvio', propCnpjCpf='$cnpj', propTxtComercial='$textComercial', propDrUid='$drrespuid'  WHERE propId ='$id'";

//     if ($status == 'PROP. ENVIADA') {
//         sendPropCliente($id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante);
//     }

//     // if ($status == 'AGUARD. QUALIFICAÇÃO') {
//     //     //Criar novo item em BD Qualificação Cliente

//     //     //Envio E-mail para user criador
//     //     $tipoNotificacao = 'email';
//     //     $idMsg = 22;
//     //     $itemEnvio = intval($id);

//     //     sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);
//     //     //Enviar Email Link para Cliente
//     //     //Enviar Email Copia Qualidade
//     //     //Enviar Email Copia Representante
//     // }

//     if ($status == 'PEDIDO') {

//         $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$pedido'");
//         $num_rows = mysqli_num_rows($ret);

//         if ($num_rows == null) {

//             createModuloII($conn, $id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante, $pedido, $drrespuid);

//             //Envio E-mail para user criador
//             $tipoNotificacao = 'email';
//             $idMsg = 13;
//             $itemEnvio = intval($id);

//             sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

//             //Envio E-mail para user planejamento
//             $tipoNotificacao = 'email';
//             $idMsg = 14;
//             $itemEnvio = intval($id);

//             sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);
//         } else {
//             header("location: update-proposta?id=" . $id . "&error=pedexist");
//             exit();
//         }
//     }

//     // print_r("Proposta Atualizada!");


//     header("location: update-proposta?id=" . $id);
//     exit();
//     // print_r($id);
//     // verifyStatusProp($conn, $id);
// }
// // header("location: update-proposta?id=".$id);
// // exit();