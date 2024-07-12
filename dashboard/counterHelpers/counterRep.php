<?php
function countPropostas($conn)
{
    $res = 0;

    $sql = "SELECT COUNT(*) 
    FROM `propostas` WHERE `propRepresentante` = '" . $_SESSION["useruid"] . "'";

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
    AND `propRepresentante` = '" . $_SESSION["useruid"] . "';";

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
    FROM `pedido` WHERE `pedRep` = '" . $_SESSION["useruid"] . "'";

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
    FROM `pedido` WHERE `pedRep` = '" . $_SESSION["useruid"] . "'
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

    $sql = "SELECT * 
    FROM `propostas` WHERE `propRepresentante` = '" . $_SESSION["useruid"] . "'
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


    $sql = "SELECT * 
    FROM `pedido` WHERE `pedRep` = '" . $_SESSION["useruid"] . "'
    ORDER BY pedId DESC LIMIT 1;
    ";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['pedNumPedido'];
    }

    return $res;
}
