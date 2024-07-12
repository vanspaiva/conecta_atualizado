<?php

header("Content-Type:application/json");


print_r($_POST);

$data = $_POST;

$tipoForm = $data['escolhao'];

//Form 1 - Compras e Demandas Motorista
$localDestino = $data['local'];
$aosCuidadosDe = $data['aoscuidados'];
$produtoDescricao = $data['insirauma'];
$pagamento =  $data['pagamento'];
$grauUrgencia1 = $data['graude'];

//Form 2 - Envio e Coleta de Materiais
$codigo = $data['codigo'];
$descricao = $data['descricao'];
$qtd = $data['qtd'];
$destino = $data['destino'];
$endereco = $data['endereco'];
$end1 = $endereco['addr_line1'];
$end2 = $endereco['addr_line2'];
$end3 = $endereco['city'];
$end4 = $endereco['state'];
$end5 = $endereco['postal'];

$enderecoFinal = $end1 . " " . $end2 . " " . $end3 . " " . $end4 . " " . $end5;

// $complemento = $data['graude'];
// $cidade = $data['graude'];
// $estado = $data['graude'];
// $cep = $data['graude'];
$responsavelPorReceber = $data['responsavelpor'];
$numeroPedido = $data['numerodo'];
$formaEnvio = $data['formade'];
$observacoes = $data['observacoes'];
$dataEvento = $data['datado'];
$dataE1 = $dataEvento['day'];
$dataE2 = $dataEvento['month'];
$dataE3 = $dataEvento['year'];
$dataEventoFinal = $dataE1 . "/" . $dataE2 . "/" . $dataE3;

$grauUrgencia2 = $data['graude31'];

//Form 3 - Separação de Estoque
$tipoItem = $data['tipodo'];
$descricaoItem = $data['descricaodo'];

//Geral
$setor = $data['qualo'];
$solicitante = $data['nomesolicitante'];

$texto = '';
switch ($tipoForm) {
    case 'Compras e Demandas Motorista':
        $texto = '
        Formulário de Solicitação para Estoque:

        ' . $tipoForm . '
        Setor: ' . $setor . '
        Solicitante: ' . $solicitante . '
        ------------------------------------------------------------
        Local / Destino: ' . $localDestino . '
        Aos Cuidados de: ' . $aosCuidadosDe . '
        Produto Descrição: ' . $produtoDescricao . '
        Pagamento: ' . $pagamento . '
        Grau de Urgência: ' . $grauUrgencia1 . '
        ';
        // echo "</br>";
        // print_r($texto);
        sendNotification($texto);
        break;

    case 'Envio e Coleta de Materiais':
        $texto = '
        Formulário de Solicitação para Estoque:

        ' . $tipoForm . '
        Setor: ' . $setor . '
        Solicitante: ' . $solicitante . '
        ------------------------------------------------------------
        Código: ' . $codigo . '
        Descrição: ' . $descricao . '
        Qtd: ' . $qtd . '
        Destino: ' . $destino . '
        Endereço: ' . $enderecoFinal . '
        Responsável por receber: ' . $responsavelPorReceber . '
        Nº Callisto: ' . $numeroPedido . '
        Forma de Envio: ' . $formaEnvio . '
        Observações: ' . $observacoes . '
        Data do Evento: ' . $dataEventoFinal . '
        Grau de Urgência: ' . $grauUrgencia2 . '
        ';
        // echo "</br>";
        // print_r($texto);
        sendNotification($texto);
        break;

    case 'Separação de Estoque':
        $texto = '
        Formulário de Solicitação para Estoque:

        ' . $tipoForm . '
        Setor: ' . $setor . '
        Solicitante: ' . $solicitante . '
        ------------------------------------------------------------
        Tipo do Item: ' . $tipoItem . '
        Descrição do Item: ' . $descricaoItem . '
        ';
        // echo "</br>";
        // print_r($texto);
        sendNotification($texto);
        break;

    default:
        $texto = 'Erro. Verifique com o suporte.';
        break;
}

function sendNotification($texto)
{

    $url = 'https://webhooks.integrately.com/a/webhooks/d9ef581bb1674e97b24bfefa1b289fdb?';

    //Link localhost API
    $data = array(
        'texto' => $texto

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

    header("location: agradecimentoestoque");
    exit();
}
