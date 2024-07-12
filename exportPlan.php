<?php

date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$today = $dt->format("d.m.Y") . "_" . $dt->format("H'i's");

header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=PropostasConecta_" . $today . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'includes/dbh.inc.php';


$output = "ID,Data Chegada,Status CN,Status TC,Dr(a),Pac,E-mail,Usuario Criador,Produto,Itens,UF,Empresa,Representante,Nº Pedido\n";

$ret = mysqli_query($conn, "SELECT * FROM propostas");
while ($row = mysqli_fetch_array($ret)) {
    $output .= $row['propId'] . "," . $row['propDataCriacao'] . "," . $row['propStatus'] . "," . $row['propStatusTC'] . "," . $row['propNomeDr'] . "," . $row['propNomePac'] . "," . $row['propEmailEnvio'] . "," . $row['propUserCriacao'] . "," . $row['propTipoProd'] . "," . implode(" | ", explode(",", $row['propListaItens'])) . "," . $row['propUf'] . "," . $row['propEmpresa'] . "," . $row['propRepresentante'] . "," . $row['propPedido'] . "\n";
}

echo $output;
