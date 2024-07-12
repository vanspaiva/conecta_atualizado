<?php
function get_options_line($conn)
{
    $sql = "SELECT CONCAT(EXTRACT(YEAR FROM `propData`), EXTRACT(MONTH FROM `propData`)) as year_and_month, 
    EXTRACT(YEAR FROM `propData`) as year, 
    EXTRACT(MONTH FROM `propData`) as month, 
    COUNT(*) as qtd 
    FROM `propostas` 
    GROUP BY year_and_month;";

    // $sql = "SELECT `propTipoProd`, COUNT(*) 
    // FROM `propostas` 
    // GROUP BY `propTipoProd`;";
    // $arrayOptions = array();
    $arrayOptions = "";
    $thisYear = date('Y');

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

    // $sql = "SELECT `propTipoProd`, COUNT(*) 
    // FROM `propostas` 
    // GROUP BY `propTipoProd`;";
    $sql = "SELECT CONCAT(EXTRACT(YEAR FROM `propData`), EXTRACT(MONTH FROM `propData`)) as year_and_month, 
    EXTRACT(YEAR FROM `propData`) as year, 
    EXTRACT(MONTH FROM `propData`) as month, 
    COUNT(*) as qtd 
    FROM `propostas`
    GROUP BY year_and_month;";

    $thisYear = date('Y');
    $arrayValues = "";

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
