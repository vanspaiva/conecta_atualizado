<?php

require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$today = $dt->format("d.m.Y") . "_" . $dt->format("H'i's");


header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=RelatorioPlan_" . $today . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

//get the post value
$datainicial = $_GET["datainicial"];
$datafinal = $_GET["datafinal"];
$status = 'PROD';

$q = "SELECT DISTINCT p.pedNumPedido,
p.*,
p.pedDtCriacaoPed AS data_iniciopedido,
z.*,
z.przData AS data_ref,
z.przStatus AS status_prazo,
z.przHora AS hora,
p.pedNomeDr AS pedNomeDr
FROM pedido p
LEFT JOIN prazoproposta z ON p.pedNumPedido = z.przNumProposta 
WHERE z.przStatus LIKE '$status' 
AND z.przData BETWEEN '$datainicial' AND '$datafinal'
ORDER BY p.pedDtCriacaoPed DESC;
";


$output = "Ped.,Dr(a),Prod.,Data,Hora,Status\n";

$ret = mysqli_query($conn, $q);
while ($rowFaq = mysqli_fetch_array($ret)) {
    $id = $rowFaq['pedId'];
    $tipoProduto = $rowFaq['pedTipoProduto'];
    $numPed = $rowFaq['pedNumPedido'];
    $dr = $rowFaq["pedNomeDr"];
    $dr = explode(" ", $dr);
    if (count($dr) > 1) {
        $dr = $dr[0] . " " . $dr[sizeof($dr)-1];
    } else {
        $dr = $dr[0];
    }

    $dataref = $rowFaq["data_ref"];
    $hora = $rowFaq["hora"];

    $status = $rowFaq["przStatus"];

    $nomeFluxo = getFullNomeFluxoPed($conn, $status);
    $corFluxo = getFullCorFluxoPed($conn, $status);


    $output .= $numPed . "," . $dr . "," . $tipoProduto . "," . dateFormat3($dataref) . "," . $hora . "," . $nomeFluxo . "\n";
}


echo $output;


function tirarAcentos($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);
}