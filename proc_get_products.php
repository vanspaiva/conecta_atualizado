<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

//array Tipos de Produtos das propostas
$arrayTipoProdutos = array();

//array Quantidade de cada Tipos de Produtos das propostas
$arrayQtdeTipoProdutos = array();

//insere Tipos de Produtos no array
$searchProd = mysqli_query($conn, "SELECT DISTINCT propTipoProd FROM propostas;");
while ($rowProd = mysqli_fetch_array($searchProd)) {

    array_push($arrayTipoProdutos, $rowProd["propTipoProd"]);
}


foreach ($arrayTipoProdutos as &$produto) {
    //Contagem cada tipo produto
    $res = mysqli_query($conn, "SELECT * FROM propostas WHERE propTipoProd = '" . $produto . "';");
    $contagem = mysqli_num_rows($res);

    array_push($arrayQtdeTipoProdutos, $contagem);
}

$dataPoints = array();
for ($i = 0; $i < sizeof($arrayTipoProdutos); $i++) {
    // echo $arrayOptionsName[$i] . " - " . $arrayValues[$i] . "<br>";
    $array = array(
        "label" => $arrayTipoProdutos[$i],
        "y" => $arrayQtdeTipoProdutos[$i]
    );
    array_push($dataPoints, $array);
}

?>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Quantidade de Propostas Por Produto"
            },
            axisY: {
                title: "Produtos",
                includeZero: true,
            },
            data: [{
                type: "column",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>

<div class="row">
    <div class="col d-flex justify-content-center">
        <div class="card w-100">
            <div class="card-body bg-qualidade rounded">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col bg-white p-2 rounded" style="height: fit-content;">
                            <!-- <canvas id="realchart1"></canvas> -->
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>