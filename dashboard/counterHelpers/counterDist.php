<?php
function countPropostas($conn)
{
    $res = 0;

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    $sql = "SELECT COUNT(*) 
    FROM `propostas` WHERE `propCnpjCpf` = '" . $cnpjUser . "'";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function countPropostasPendente($conn)
{
    $res = 0;

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    $sql = "SELECT COUNT(*) 
    FROM `propostas` WHERE (`propStatus`='PENDENTE' OR `propStatus`='PROP. ENVIADA' OR `propStatus`='AGUARD. INFOS ADICIO')
    AND `propCnpjCpf` = '" . $cnpjUser . "';";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function countPedido($conn)
{
    $res = 0;

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    $sql = "SELECT COUNT(*) 
    FROM `pedido` WHERE `pedCpfCnpj` = '" . $cnpjUser . "'";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['COUNT(*)'];
    }

    return $res;
}

function countPedidoPendente($conn)
{
    $res = 0;

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    $sql = "SELECT COUNT(*) 
    FROM `pedido` WHERE `pedCpfCnpj` = '" . $cnpjUser . "'
    AND (`pedStatus`='CRIADO' OR `pedStatus`='PLAN' OR `pedStatus`='VIDEO' OR `pedStatus`='ACEITE');";

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
    FROM `propostas` WHERE `propCnpjCpf` = '" . $cnpjUser . "'
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
    FROM `pedido` WHERE `pedCpfCnpj` = '" . $cnpjUser . "'
    ORDER BY pedId DESC LIMIT 1;
    ";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $res = $row['pedNumPedido'];
    }

    return $res;
}