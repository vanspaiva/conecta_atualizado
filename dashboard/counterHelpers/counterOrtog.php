<?php
function countPropostas($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `propostas` WHERE propTipoProd = 'ORTOGNÁTICA';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function countPropostasPendente($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `propostas` WHERE `propStatus`='PROP. ENVIADA' OR `propStatus`='AGUARD. INFOS ADICIO' AND propTipoProd = 'ORTOGNÁTICA';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function countPedido($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `pedido` WHERE pedTipoProduto = 'ORTOGNÁTICA';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function countPedidoPendente($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `pedido` WHERE pedTipoProduto = 'ORTOGNÁTICA' AND `pedAndamento`='PENDENTE';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function counterPedidoPlanejando($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `pedido` WHERE pedTipoProduto = 'ORTOGNÁTICA' AND `pedAndamento`='ABERTO';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function counterPedidoCriado($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `pedido` WHERE pedTipoProduto = 'ORTOGNÁTICA' AND  `pedAndamento`='ABERTO';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function counterTCReprovada($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `propostas` WHERE `propStatusTC` LIKE ('%REPROVADA%');";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function counterTCAnalisar($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `propostas` WHERE `propStatusTC` LIKE ('%REENVIADA%') OR `propStatusTC` LIKE ('%ANALISAR%') AND propTipoProd = 'ORTOGNÁTICA';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function getLastProp($conn)
{
    $res = 0;

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    $sql = "SELECT * 
    FROM `propostas`
    ORDER BY propId DESC LIMIT 1;
    ";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['propId'];
    }

    return $res;
}

function getLastPed($conn)
{
    $res = 0;

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    $sql = "SELECT * 
    FROM `pedido`
    ORDER BY pedId DESC LIMIT 1;
    ";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['pedNumPedido'];
    }

    return $res;
}

function counterPedidosIBMF($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `pedido` WHERE pedStatus='IBMF';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}
