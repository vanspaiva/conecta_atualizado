<?php
function countPropostas($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `propostas` WHERE `propDrUid` = '" . $_SESSION["useruid"] . "'";

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
    FROM `propostas` WHERE (`propStatus`='PROP. ENVIADA' OR `propStatus`='AGUARD. INFOS ADICIO')
    AND `propDrUid` = '" . $_SESSION["useruid"] . "';";

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
    FROM `pedido` WHERE `pedUserCriador` = '" . $_SESSION["useruid"] . "'";

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
    FROM `pedido` WHERE `pedUserCriador` = '" . $_SESSION["useruid"] . "'
    AND (`pedStatus`='VIDEO' OR `pedStatus`='ACEITE');";

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
        $cnpjUser = $rowCnpj['usersCpf'];
    }

    $sql = "SELECT * 
    FROM `propostas` WHERE `propCnpjCpf` = '" . $cnpjUser . "' OR `propDrUid` = '" . $_SESSION["useruid"] . "'
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
        $cnpjUser = $rowCnpj['usersCpf'];
    }

    $sql = "SELECT * 
    FROM `pedido` WHERE `pedCpfCnpj` = '" . $cnpjUser . "' OR `pedUserCriador` = '" . $_SESSION["useruid"] . "'
    ORDER BY pedId DESC LIMIT 1;
    ";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['pedNumPedido'];
    }

    return $res;
}