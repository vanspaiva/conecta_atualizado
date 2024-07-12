<?php

date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$today = $dt->format("d.m.Y") . "_" . $dt->format("H'i's");

header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=AceitesFinanceiroConecta_" . $today . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'includes/dbh.inc.php';


$output = "ID,Nº Prop,Status,Nome Usuário,Data Envio,IP, CPF/CNPJ, Forma Pagamento, Tipo de Arquivo\n";

$ret = mysqli_query($conn, "SELECT * FROM aceiteproposta");
while ($row = mysqli_fetch_array($ret)) {
    $output .= $row['apropId'] . "," . $row['apropNumProp'] . "," . $row['apropStatus'] . "," . $row['apropNomeUsuario'] . "," . $row['apropData'] . "," . $row['apropIp'] . "," . $row['apropCPFCNPJ'] . "," . $row['apropFormaPgto'] . "," . $row['apropExtensionFile'] . "\n";
}

echo $output;
