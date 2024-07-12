<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$id = $_POST['id'];


//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result = "SELECT * FROM laudostomograficos l INNER JOIN propostas p ON l.laudoNumProp = p.propId INNER JOIN pedido d ON l.laudoNumProp = d.pedPropRef WHERE l.laudoNumProp='$id';";
$resultado = mysqli_query($conn, $result);
if (($resultado) and ($resultado->num_rows != 0)) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $laudoNumProp  = $row['laudoNumProp'];
        $laudoStatus  = $row['laudoStatus'];
        $laudoDataDocumento  = $row['laudoDataDocumento'];
        $laudoDataExame  = $row['laudoDataExame'];
        $DataLaudoTC  = $row['DataLaudoTC'];
        $DataAnvisaDr  = $row['DataAnvisaDr'];
        $DataAnvisaPac  = $row['DataAnvisaPac'];
        $NTransacao  = $row['NTransacao'];
        $NExpedicao  = $row['NExpedicao'];
        $propNomeDr  = $row['propNomeDr'];
        $propNomePac  = $row['propNomePac'];
        $propRepresentante  = $row['propRepresentante'];
        $propPedido = $row['propPedido'];
        $propTipoProd = $row['propTipoProd'];
        $pedDtCriacaoPed = $row['pedDtCriacaoPed'];
    }

    $result = $laudoNumProp . ',' . $laudoStatus . ',' . $laudoDataDocumento . ',' . $laudoDataExame . ',' . $DataLaudoTC . ',' . $DataAnvisaDr . ',' . $DataAnvisaPac . ',' . $NTransacao . ',' . $NExpedicao . ',' . $propNomeDr . ',' . $propNomePac . ',' . $propRepresentante . ',' . $propPedido . ',' . $propTipoProd . ',' . $pedDtCriacaoPed;

    echo $result;
}
