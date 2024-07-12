<?php
function get_options($conn)
{

    $sql = "SELECT `propStatus`, COUNT(*) 
    FROM `propostas` WHERE `propRepresentante` = '" . $_SESSION["useruid"] . "'
    GROUP BY `propStatus`;";
    // $arrayOptions = array();
    $arrayOptions = "";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {

        $arrayOptions .= $row['propStatus'];
        $arrayOptions .= ",";
    }
    $arrayOptions = substr($arrayOptions, 0, -1);

    return $arrayOptions;
}

function get_values($conn)
{


    $sql = "SELECT `propStatus`, COUNT(*) 
    FROM `propostas` WHERE `propRepresentante` = '" . $_SESSION["useruid"] . "'
    GROUP BY `propStatus`;";
    $arrayValues = "";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $arrayValues .= $row['COUNT(*)'];
        $arrayValues .= ",";
    }
    $arrayValues = substr($arrayValues, 0, -1);

    return $arrayValues;
}
