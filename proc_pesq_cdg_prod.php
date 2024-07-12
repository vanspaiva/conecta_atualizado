<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$cdg = $_POST['cdg'];

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_prod = "SELECT DISTINCT * FROM produtos WHERE prodCodCallisto LIKE '%$cdg%';";
$resultado_prod = mysqli_query($conn, $result_prod);
if (($resultado_prod) and ($resultado_prod->num_rows != 0)) {
    // $prod = $resultado_prod['prodCodCallisto'];
    while ($row = mysqli_fetch_array($resultado_prod)) {

        echo '
        <tr id="trNew">
            <td><input type="text" class="form-control" id="itemCdg" name="itemCdg" value="' . $row['prodCodCallisto'] . '" readonly></td>
            <td><input type="text" class="form-control" id="itemNome" name="itemNome" value="' . $row['prodDescricao'] . '" readonly></td>
            <td><input type="text" class="form-control text-center" id="itemQtd" name="itemQtd" value="1" readonly></td>
            <td><input type="text" class="form-control text-center" id="itemAnvisa" name="itemAnvisa" value="' . $row['prodAnvisa'] . '" readonly></td>
            <td><input type="text" class="form-control text-center itemValor" id="itemValor" name="itemValor" onchange="resomarItens()" value="' . number_format($row['prodPreco'], 2, ",", ".") . '" readonly></td>
            <td><span class="btn" onclick="adicionarnalista(this)"><i class="far fa-plus-square" style="color: #000;"></i></span></td>
        </tr>
        ';
    }
} 
