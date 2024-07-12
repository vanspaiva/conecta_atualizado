<?php
require_once "includes/dbh.inc.php";
require_once "includes/functions.inc.php";
require_once "graficosadm/pizza-chart.php";
require_once "graficosadm/line-chart.php";
require_once "counterHelpers/counterOrtog.php";

$values_line = get_values_line($conn);
$options_line = get_options_line($conn);

$valorPropostasTotal = number_format(soma_geral_valores_propostas($conn), 2, ",", ".");

$arrayColors = getSetOfColors($conn);


$counterProposta = intval(countPropostas($conn));
$counterPropostaPendente = intval(countPropostasPendente($conn));
$counterPedido = intval(countPedido($conn));
$counterPedidoPendente = intval(countPedidoPendente($conn));
$counterPedidoPlanejando = intval(counterPedidoPlanejando($conn));
$counterPedidoCriado = intval(counterPedidoCriado($conn));
$counterTCReprovada = intval(counterTCReprovada($conn));
$counterTCAnalisar = intval(counterTCAnalisar($conn));
$counterIBMF = intval(counterPedidosIBMF($conn));

// $counterPendente = $counterPropostaPendente  + $counterPedidoPendente;
$counterPendente = $counterPedidoCriado + $counterTCAnalisar;



?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<style>
    .dataTables_length label,
    .dataTables_length select,
    .dataTables_filter label,
    .dataTables_filter label input:focus,
    .dataTables_filter label input {
        color: white;
    }

    #backButton {
        border-radius: 4px;
        padding: 8px;
        border: none;
        font-size: 16px;
        background-color: #2eacd1;
        color: white;
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    .invisible {
        display: none;
    }

    .hover-bigger {
        transform: scale(0.9);
        transition: ease-in-out all 0.4s;
    }

    .hover-bigger:hover {
        transform: scale(1);
    }

    .btn-circle {
        width: 65px;
        height: 65px;
        border-radius: 50%;
    }

    .card-chart {
        min-height: 600px;
    }

    .canvasjs-chart-canvas {
        font-family: 'Montserrat', sans-serif !important;
    }

    .canvasjs-chart-credit {
        display: none !important;
    }

    .bg-amarelo {
        background-color: #FAF53D;
    }

    .bg-verde-claro {
        background-color: #9FFFD2;
    }

    .bg-verde {
        background-color: #34B526;
    }

    .bg-rosa {
        background-color: #FAA4B5;
    }

    .bg-vermelho {
        background-color: #FA242A;
    }

    .bg-vermelho-claro {
        background-color: #FA6069;
    }

    .bg-roxo {
        background-color: #C165FF;
    }

    .bg-azul {
        background-color: #42A1DB;
    }
</style>
<div id="main" class="font-montserrat">
    <div hidden>
        <input class="form-control" id="values_line" type="text" value="<?php echo $values_line; ?>">
        <input class="form-control" id="options_line" type="text" value="<?php echo $options_line; ?>">
    </div>
    <div class="container-fluid">
        <?php include("dashComponents/rowofbuttons.comp.php"); ?>
        <div class="row d-flex align-items-top mb-4">
            <div class="col-3">
                <div class="container-fluid">
                    <div class="row px-3 py-1">
                        <div class="col">
                            <h4 class="text-conecta text-center" style="font-weight: 400;">Dados <b>Rápidos</b></h4>

                        </div>
                    </div>

                    <!-- <div class="row p-3">
                        <div class="col">
                            <div class="card shadow rounded" style="background-color: #ee7624; height: 140px;">
                                <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                    <div class="container-fluid text-center">
                                        <div class="row">
                                            <div class="col d-flex justify-content-center">
                                                <div class="p-1">
                                                    <h4 class="text-white" style="text-align: center; font-size: 10pt;"><i class="fas fa-diagnoses"></i> Lista de Análises de TC</h4>
                                                    <a href="planejamento2" class="text-decoration-none"><button class="btn btn-light hover-bigger" style="color: #ee7624; font-size: 8pt;">Acesse aqui</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="row p-3">
                        <div class="col">
                            <div class="card shadow rounded" style="background-color: #ee7624; height: 140px;">
                                <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                    <div class="container-fluid text-center">
                                        <div class="row">
                                            <div class="col d-flex justify-content-center">
                                                <div class="p-1">
                                                    <h4 class="text-white" style="text-align: center; font-size: 10pt;"><i class="bi bi-collection fa-1x" class=" iconesIndex"></i> Lista de Casos</h4>
                                                    <a href="casos2" class="text-decoration-none"><button class="btn btn-light hover-bigger" style="color: #ee7624; font-size: 8pt;">Acesse aqui</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row p-3">
                        <div class="col">
                            <div class="card shadow rounded" style="border-left: #FCB805 7px solid;">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pb-2">
                                        <span class="badge p-2" style="background-color: #fdefca; color: #FCB805;"><i class="fas fa-clock"></i> Aguardando IBMF</span>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <h2 style="text-align: center;" class="pt-3"><b><?php echo $counterIBMF; ?></b></h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer d-flex justify-content-center">
                                    <a href="casos2"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row p-3">
                        <div class="col">
                            <div class="card shadow rounded" style="border-left: #2eacd1 7px solid;">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pb-2">
                                        <span class="badge p-2" style="background-color: #ccf6ff; color: #2eacd1;"><i class="fas fa-tools"></i> Aguardando Técnico</span>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <h2 style="text-align: center;" class="pt-3"><b><?php echo $counterPedidoCriado; ?></b></h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <a href="casos2"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row p-3">
                        <div class="col">
                            <div class="card shadow rounded" style="border-left: #FA242A 7px solid;">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pb-2">
                                        <span class="badge p-2" style="background-color: #ffdee0; color: #FA242A;"><i class="fas fa-file"></i> Aguardando Análise TC</span>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <h2 style="text-align: center;" class="pt-3"><b><?php echo $counterTCAnalisar; ?></b></h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <a href="planejamento2"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row p-3">
                        <div class="col">
                            <div class="card shadow rounded" style="border-left: #00AB30 7px solid;">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pb-2">
                                        <span class="badge p-2" style="background-color: #baedc8; color: #00AB30;"><i class="fas fa-tv"></i> Planejando</span>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <h2 style="text-align: center;" class="pt-3"><b><?php echo $counterPedidoPlanejando; ?></b></h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <a href="casos2"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>

            </div>

            <div class="col-9">
                <div class="container-fluid">


                    <div class="row py-2 my-1">
                        <div class="col">
                            <div class="card shadow rounded" style="overflow: scroll; border-top: #ee7624 7px solid;">
                                <!-- <div class="card-header d-flex justify-content-end align-items-center">
                                    <div class="p-1 d-flex justify-content-end align-items-center">
                                        <button class="btn text-conecta border" onclick="changetable()"><i class="fas fa-chevron-right"></i></button>
                                    </div>
                                </div> -->
                                <div class="card-body">
                                    <div id="table1">
                                        <h6 style="color: #ee7624; font-weight: 400;">Pedidos</h6>
                                        <table id="tablePed" class="table table-striped table-advance table-hover bg-white rounded">

                                            <thead>
                                                <tr>
                                                    <th>Situação</th>
                                                    <th>Nº Callisto</th>
                                                    <th>Dr(a)</th>
                                                    <th>Paciente</th>
                                                    <th>Especificação</th>
                                                    <th>Fluxo</th>
                                                    <th>Situação</th>
                                                    <th>Data Criação</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--inicio linha de cartões-->
                                                <div class="row py-2">

                                                    <?php
                                                    //chamar do banco de dados todos os casos
                                                    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedStatus='IBMF' ORDER BY pedDtCriacaoPed DESC;");
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $propID = $row['pedPropRef'];
                                                        $pedID = $row['pedNumPedido'];
                                                        $tipoProd = $row['pedTipoProduto'];

                                                        $numFluxo = $row['pedPosicaoFluxo'];
                                                        $numFluxo = intval($numFluxo);
                                                        $numFluxo = $numFluxo * 20;

                                                        // $andamento = $row['pedStatus'];
                                                        $nomeFluxo = getNomeFluxoPed($conn, $pedID);
                                                        $corFluxo = getCorFluxoPed($conn, $pedID);
                                                        $contagemDias = getAndamentoForTableFluxoPed($conn, $pedID);

                                                        $andamento = $row['pedAndamento'];


                                                        switch ($andamento) {
                                                            case 'ABERTO':
                                                                $bgcor = '#5EA324';
                                                                $lettercor = '#ffffff';
                                                                break;
                                                            case 'PENDENTE':
                                                                $bgcor = '#F04152';
                                                                $lettercor = '#ffffff';
                                                                break;
                                                            case 'FINALIZADO':
                                                                $bgcor = '#536DF0';
                                                                $lettercor = '#ffffff';
                                                                break;
                                                            case 'ARQUIVADO':
                                                                $bgcor = '#F0EA59';
                                                                $lettercor = '#000000';
                                                                break;

                                                            default:
                                                                $bgcor = '#9FA0A6';
                                                                $lettercor = '#ffffff';
                                                        }

                                                        $dataBD = $row['pedDtCriacaoPed'];
                                                        $dataBD = explode(" ", $dataBD);
                                                        $date = $dataBD[0];
                                                        $date = explode("-", $date);
                                                        $data = $date[2] . '/' . $date[1] . '/' . $date[0];

                                                        //pesquisar proposta
                                                        $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='$propID';");
                                                        while ($rowProp = mysqli_fetch_array($retProp)) {
                                                            $cdgCallisto = $rowProp['propListaItens'];
                                                            $cdgCallisto = explode(',', $cdgCallisto);
                                                            $cdgImg = $cdgCallisto[0];
                                                        }

                                                        //pesquisar imagem
                                                        $retImg = mysqli_query($conn, "SELECT * FROM imagensprodutos WHERE imgprodCodCallisto='$cdgImg';");
                                                        while ($rowImg = mysqli_fetch_array($retImg)) {
                                                            $linkImg = $rowImg['imgprodLink'];
                                                            $altImg = $rowImg['imgprodNome'];
                                                            $categoria = $rowImg['imgprodCategoria'];
                                                        }
                                                        $encrypted = hashItemNatural($row['pedNumPedido']);


                                                    ?>
                                                        <tr>
                                                            <td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>
                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                            <td><?php echo $contagemDias; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td class="d-flex">
                                                                <?php
                                                                if ($row['pedStatus'] == 'Avaliar Projeto') {
                                                                ?>
                                                                    <a disabled>
                                                                        <button class="btn text-muted"><i class="fas fa-edit"></i></button></a>
                                                                    <a disabled>
                                                                        <button class="btn text-muted"><i class="fas fa-eye"></i></button></a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="update-caso?id=<?php echo $row['pedId']; ?>">
                                                                        <button class="btn text-primary"><i class="fas fa-edit"></i></button></a>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-success"><i class="fas fa-eye"></i></button></a>
                                                                    <?php
                                                                    if ($_SESSION["userperm"] == 'Administrador') {
                                                                    ?>
                                                                        <a href="manageCasos?id=<?php echo $row['pedId']; ?>">
                                                                            <button class="btn text-danger" onClick="return confirm('Você realmente deseja apagar esse pedido?');"><i class="far fa-trash-alt"></i></button></a>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- <div class="row py-2 my-1">
                        <div class="col h-50">
                            <div class="card shadow rounded card-chart" style="border-top: #ee7624 7px solid;">
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col pb-4 d-flex justify-content-between align-items-center">
                                                <h4 style="color: #ee7624; font-weight: 400;">Oportunidade</h4>
                                                </!-- <button class="btn text-conecta border" onclick="changechart()"><i class="fas fa-chevron-right"></i></button> --/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                </!--Gráfico 1--/>
                                                <div id="chart1">

                                                    </!-- <div id="chartLine"></div> --/>
                                                    <div id="columnchart_values" style="width: auto; height: 300px;"></div>

                                                </div>

                                                </!--Gráfico 2--/>
                                                <div id="chart2" class="d-none">
                                                    </!-- <div id="chartPizza"></div> --/>
                                                    <div id="piechart" style="width: auto; height: 300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> -->

                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#tableProp').DataTable({
            "lengthMenu": [
                [5, 10, 20, 40, 80, -1],
                [5, 10, 20, 40, 80, "Todos"],
            ],
            "language": {
                "search": "Pesquisar:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
                "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                "lengthMenu": "Mostrar _MENU_ itens",
                "zeroRecords": "Nenhuma proposta encontrada"
            },
            "order": [
                [0, "desc"]
            ]
        });
        $('#tablePed').DataTable({
            "lengthMenu": [
                [5, 10, 20, 40, 80, -1],
                [5, 10, 20, 40, 80, "Todos"],
            ],
            "language": {
                "search": "Pesquisar:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
                "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                "lengthMenu": "Mostrar _MENU_ itens",
                "zeroRecords": "Nenhuma proposta encontrada"
            },
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>
<script>
    function changedash() {
        var div1 = document.getElementById("div-dash-dinamic1");
        var div2 = document.getElementById("div-dash-dinamic2");
        var titulo = document.getElementById("titulo-dash");

        if ($("#div-dash-dinamic1").hasClass("d-none")) {
            div1.classList.remove('d-none');
            div2.classList.add('d-none');
            titulo.innerHTML = "Propostas";
        } else {
            div2.classList.remove('d-none');
            div1.classList.add('d-none');
            titulo.innerHTML = "Pedidos";
        }

    }

    function changechart() {
        var div1 = document.getElementById("chart1");
        var div2 = document.getElementById("chart2");

        if ($("#chart1").hasClass("d-none")) {
            div1.classList.remove('d-none');
            div2.classList.add('d-none');
        } else {
            div2.classList.remove('d-none');
            div1.classList.add('d-none');
        }

    }

    function changetable() {
        var div1 = document.getElementById("table1");
        var div2 = document.getElementById("table2");

        if ($("#table1").hasClass("d-none")) {
            div1.classList.remove('d-none');
            div2.classList.add('d-none');
        } else {
            div2.classList.remove('d-none');
            div1.classList.add('d-none');
        }

    }
</script>

<!-- Gráfico de pizza Propostas -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Tipo de Produto', 'Qtd Propostas'],
            <?php
            $options_2 =  get_options($conn);
            $options_2 = explode(",", $options_2);
            $values_2 =  get_values($conn);
            $values_2 = explode(",", $values_2);

            for ($i = 0; $i < sizeof($values_2); $i++) {
            ?>["<?php echo $options_2[$i]; ?>", <?php echo intval($values_2[$i]); ?>],
            <?php
            }
            ?>


        ]);

        var options = {
            title: 'Status Solicitações',
            //legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>

<!-- Gráfico de coluna Propostas -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Produto", "Qtd Propostas", {
                role: "style"
            }],
            <?php
            $options_2 =  get_options_line($conn);
            $options_2 = explode(",", $options_2);
            $values_2 =  get_values_line($conn);
            $values_2 = explode(",", $values_2);

            // $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            // $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
            $setColor = ["#f0a16c", "#ee7624", "#874214", "#3b1d09", "#3b271a", "#f0a16c", "#ee7624", "#874214", "#3b1d09", "#3b271a"];

            for ($i = 0; $i < sizeof($values_2); $i++) {

            ?>["<?php echo $options_2[$i]; ?>", <?php echo intval($values_2[$i]); ?>, "<?php echo $arrayColors[$i]; ?>"],
            <?php
            }
            ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            title: "Propostas por mês",

            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
</script>