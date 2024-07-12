<?php
function get_options_line($conn)
{

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    // $sql = "SELECT `propTipoProd`, COUNT(*) 
    // FROM `propostas` WHERE `propCnpjCpf` = '" . $cnpjUser . "'
    // GROUP BY `propTipoProd`;";
    $sql = "SELECT CONCAT(EXTRACT(YEAR FROM `propData`), EXTRACT(MONTH FROM `propData`)) as year_and_month, 
    EXTRACT(YEAR FROM `propData`) as year, 
    EXTRACT(MONTH FROM `propData`) as month, 
    COUNT(*) as qtd 
    FROM `propostas`
    WHERE `propCnpjCpf` = '" . $cnpjUser . "' 
    GROUP BY year_and_month;";

    $thisYear = date('Y');
    // $thisYear = "2022";

    // $arrayOptions = array();
    $arrayOptions = "";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        if ($row["year"] == $thisYear) {
            $month = getMonthAbrv($conn, $row['month']);
            $arrayOptions .= $month;
            $arrayOptions .= ",";
        }
    }
    $arrayOptions = substr($arrayOptions, 0, -1);

    return $arrayOptions;
}

function get_values_line($conn)
{

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    // $sql = "SELECT `propTipoProd`, COUNT(*) 
    // FROM `propostas` WHERE `propCnpjCpf` = '" . $cnpjUser . "'
    // GROUP BY `propTipoProd`;";
    $arrayValues = "";
    $sql = "SELECT CONCAT(EXTRACT(YEAR FROM `propData`), EXTRACT(MONTH FROM `propData`)) as year_and_month, 
    EXTRACT(YEAR FROM `propData`) as year, 
    EXTRACT(MONTH FROM `propData`) as month, 
    COUNT(*) as qtd 
    FROM `propostas`
    WHERE `propCnpjCpf` = '" . $cnpjUser . "' 
    GROUP BY year_and_month;";

    $thisYear = date('Y');
    // $thisYear = "2022";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        if ($row["year"] == $thisYear) {
            $arrayValues .= $row['qtd'];
            $arrayValues .= ",";
        }
    }
    $arrayValues = substr($arrayValues, 0, -1);

    return $arrayValues;
}

function getSetOfColors($conn)
{
    $sql = "SELECT * FROM `chartcolor`;";
    $arrayColor = [];

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        array_push($arrayColor, $row["chartColor"]);
    }

    return $arrayColor;
}
