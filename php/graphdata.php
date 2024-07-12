
<?php
require_once 'includes/dbh.inc.php';


if ($_POST["action"] == 'fetch') {
    $order_column = array('propId', 'propDataCriacao', 'propStatus', 'propStatusTC', 'propEmpresa', 'propNomeDr', 'propTipoProd');

    $main_query = "
		SELECT propId, propDataCriacao, propStatus, propStatusTC, propEmpresa, propNomeDr, propTipoProd
		FROM propostas 
		";

    $search_query = 'WHERE propId <= 1 AND ';


    if (isset($_POST["search"]["value"])) {
        $search_query .= '(propDataCriacao LIKE "%' . $_POST["search"]["value"] . '%" OR propStatus LIKE "%' . $_POST["search"]["value"] . '%" OR propStatusTC LIKE "%' . $_POST["search"]["value"] . '%" OR propEmpresa LIKE "%' . $_POST["search"]["value"] . '%" OR propNomeDr LIKE "%' . $_POST["search"]["value"] . '%" OR propTipoProd LIKE "%' . $_POST["search"]["value"] . '%")';
    }

    $group_by_query = " GROUP BY propDataCriacao ";

    $order_by_query = "";

    if (isset($_POST["order"])) {
        $order_by_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $order_by_query = 'ORDER BY propDataCriacao DESC ';
    }

    $limit_query = '';

    if ($_POST["length"] != -1) {
        $limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $statement = $connect->prepare($main_query . $search_query . $group_by_query . $order_by_query);

    $statement->execute();

    $filtered_rows = $statement->rowCount();

    $statement = $connect->prepare($main_query . $group_by_query);

    $statement->execute();

    $total_rows = $statement->rowCount();

    $result = $connect->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

    $data = array();

    foreach ($result as $row) {
        $sub_array = array();

        $sub_array[] = $row['propId'];

        $sub_array[] = $row['propDataCriacao'];

        $sub_array[] = $row['propStatus'];

        $sub_array[] = $row['propStatusTC'];

        $sub_array[] = $row['propEmpresa'];

        $sub_array[] = $row['propNomeDr'];

        $sub_array[] = $row['propTipoProd'];

        $data[] = $sub_array;
    }

    $output = array(
        "draw"            =>    intval($_POST["draw"]),
        "recordsTotal"    =>    $total_rows,
        "recordsFiltered" => $filtered_rows,
        "data"            =>    $data
    );

    echo json_encode($output);
}
