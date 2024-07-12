<?php
if (isset($_POST["addProduto"])) {

    $smtZigoma = addslashes($_POST["idZigoma"]);
    $smtParanasal = addslashes($_POST["idParanasal"]);
    $smtMento = addslashes($_POST["idMento"]);
    $smtAngulo = addslashes($_POST["idAngulo"]);
    $smtPremaxila = addslashes($_POST["idPremaxila"]);


    require_once 'dbh.inc.php';

    consultProdRegister($conn, $codigo);
} else {
    header("location: ../solicitacao");
    exit();
}

function consultProdRegister($conn, $codigo)
{
    $sql = "SELECT * FROM produtos WHERE prodCodCallisto = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../solicitacao?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $codigo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}
