<?php

require_once 'includes/dbh.inc.php';
$id = addslashes($_GET["id"]);

$ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId = $id");
while ($row = mysqli_fetch_array($ret)) {
    $propListaItens = $row['propListaItens'];

    $rep = $row['propRepresentante'];
    $retRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $rep . "';");
    while ($rowRep = mysqli_fetch_array($retRep)) {
        $representante = $rowRep['usersName'];
        $representante = explode(" ", $representante);
        $representante = $representante[0];
        $representanteFone = $rowRep['usersCel'];
    }

    $output = array(
        "ID" => $row['propId'],
        "Cliente" => tirarAcentos(strtoupper($row['propEmpresa'])),
        "Email Cliente" => $row['propEmailCriacao'],
        "Plano de Venda" => tirarAcentos($row['propPlanoVenda']),
        "CNPJ" => $row['propCnpjCpf'],
        "Representante" => tirarAcentos(strtoupper($representante)),
        "Medico" => tirarAcentos(strtoupper($row['propNomeDr'])),
        "Paciente" => tirarAcentos(strtoupper($row['propNomePac'])),
        "Convenio" => tirarAcentos(strtoupper($row['propConvenio'])),
        "Desconto(%)" => $row['propDesconto'],
        "Valor Desconto" => "R$ " . number_format($row['propoValorDesconto'], 2, ",", "."),
        "Valor Pos Desconto" => "R$ " . number_format($row['propValorPosDesconto'], 2, ",", ".")

    );
}



$listaItens = explode(",", $propListaItens);
$tamListaItens = sizeof($listaItens);


$retProd = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $id . "';");
while ($rowProd = mysqli_fetch_array($retProd)) {
    $propTipoProd = $rowProd['itemNome'];
    $propTipoProd = explode(' ', $propTipoProd);
    $propTipoProd = $propTipoProd[0];

    $produto = array();
    $produto = array(
        "Cod Alternativo" => $rowProd['itemCdg'],
        "Produto" => tirarAcentos($rowProd['itemNome']),
        "Qtd" => $rowProd['itemQtd'],
        "Anvisa" => tirarAcentos($rowProd['itemAnvisa']),
        "Preco Unitario" => "R$ " . number_format($rowProd['itemValorBase'], 2, ",", ".")
    );

    array_push($output, $produto);
}



$output = json_encode($output);


header('Content-disposition: attachment; filename=PropostasConecta_' . $id . '.json');
header('Content-type: application/json');

echo ($output);


function tirarAcentos($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);
}
