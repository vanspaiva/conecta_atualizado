<?php
$totalVisitors = 883000;

$newVsReturningVisitorsDataPoints = array(
    array("y" => 519960, "name" => "Propostas", "color" => "#E7823A"),
    array("y" => 363040, "name" => "Pedidos", "color" => "#546BC1")
);

$newVisitorsDataPoints = array(
    array("x" => 1420050600000, "y" => 33000),
    array("x" => 1422729000000, "y" => 35960),
    array("x" => 1425148200000, "y" => 42160),
    array("x" => 1427826600000, "y" => 42240),
    array("x" => 1430418600000, "y" => 43200),
    array("x" => 1433097000000, "y" => 40600),
    array("x" => 1435689000000, "y" => 42560),
    array("x" => 1438367400000, "y" => 44280),
    array("x" => 1441045800000, "y" => 44800),
    array("x" => 1443637800000, "y" => 48720),
    array("x" => 1446316200000, "y" => 50840),
    array("x" => 1448908200000, "y" => 51600)
);

$returningVisitorsDataPoints = array(
    array("x" => 1420050600000, "y" => 22000),
    array("x" => 1422729000000, "y" => 26040),
    array("x" => 1425148200000, "y" => 25840),
    array("x" => 1427826600000, "y" => 23760),
    array("x" => 1430418600000, "y" => 28800),
    array("x" => 1433097000000, "y" => 29400),
    array("x" => 1435689000000, "y" => 33440),
    array("x" => 1438367400000, "y" => 37720),
    array("x" => 1441045800000, "y" => 35200),
    array("x" => 1443637800000, "y" => 35280),
    array("x" => 1446316200000, "y" => 31160),
    array("x" => 1448908200000, "y" => 34400)
);
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
</style>
<div id="main" class="font-montserrat">
    <div class="container-fluid">
        <?php include("dashComponents/rowofbuttons.comp.php"); ?>
        <div class="row d-flex align-items-end mb-4">
            <div class="col-4">
                <div class="card shadow rounded" style="border-top: #ee7624 7px solid;">
                    <div class="card-body">
                        <h5 class="text-conecta pb-4" style="font-weight: 400;"><i class="fas fa-chart-line"></i> Olá, <?php echo $_SESSION["userfirstname"]; ?>! Bem-vindo a sua <b style="font-weight: 700;">Dashboard </b></h5>
                        <p style="line-height: 1.5em;"><i class="fas fa-boxes"></i> Ultimo pedido <b><span class="text-conecta">1037</span></b>
                            <br><br>
                            <i class="fas fa-smile"></i> Fase: <span class="badge bg-warning text-white">Planejando Aceite</span> há <b><span class="text-conecta">10</span></b> dias
                        </p>
                        <p style="line-height: 1.5em;"><i class="far fa-calendar"></i> Entrega (previsão): <b><span class="text-conecta">20/01/2023</span></b></p>


                    </div>
                    <div class="card-footer d-flex justify-content-center bg-white h-auto">
                        <a href="?prop=1"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver essa proposta </button></a>
                    </div>

                </div>
            </div>

            <div class="col d-flex justify-content-center align-items-center">
                <div class="container-fluid p-1">
                    <div class="row">
                        <h4 class="text-conecta" style="font-weight: 400;">Dados Rápidos</h4>
                        <hr style="border-color: #ee7624;">
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col p-1">
                            <div class="card shadow rounded" style="border-left: #2eacd1 7px solid;">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pb-2">
                                        <span class="badge p-2" style="background-color: #ccf6ff; color: #2eacd1;"><i class="fas fa-file-alt"></i> Propostas</span>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <h2 style="text-align: center;" class="pt-3"><b>25</b></h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <a href="minhassolicitacoes"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>

                                </div>
                            </div>

                        </div>
                        <div class="col p-1">
                            <div class="card shadow rounded" style="border-left: #00AB30 7px solid;">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pb-2">
                                        <span class="badge p-2" style="background-color: #baedc8; color: #00AB30;"><i class="fas fa-boxes"></i> Pedidos</span>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <h2 style="text-align: center;" class="pt-3"><b>11</b></h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <a href="#"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>
                                </div>
                            </div>

                        </div>
                        <div class="col p-1">
                            <div class="card shadow rounded" style="border-left: #FCB805 7px solid;">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pb-2">
                                        <span class="badge p-2" style="background-color: #fdefca; color: #FCB805;"><i class="fas fa-clock"></i> Aguardando Cliente</span>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <h2 style="text-align: center;" class="pt-3"><b>4</b></h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer d-flex justify-content-center">
                                    <a href="#"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>
                                </div>
                            </div>

                        </div>
                        <div class="col p-1">
                            <div class="card shadow rounded" style="background-color: #ee7624; height: 140px;">
                                <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                    <div class="container-fluid text-center">
                                        <div class="row">
                                            <div class="col d-flex justify-content-center">
                                                <div class="p-1">
                                                    <h4 class="text-white" style="text-align: center; font-size: 10pt;"><i class="fas fa-plus"></i> Nova Solicitação de Proposta</h4>
                                                    <a href="solicitacao" class="text-decoration-none"><button class="btn btn-light hover-bigger" style="color: #ee7624; font-size: 8pt;">Acesse aqui</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-4">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col pb-4">
                                    <h4 style="color: #ee7624; font-weight: 400;">Oportunidade</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                    <button class="btn invisible" id="backButton">&lt; Back</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <h4 style="color: #ee7624; font-weight: 400;">Propostas/Pedidos</h4>
                        <table id="table" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Data Envio</th>
                                    <th>TC</th>
                                    <th>Status</th>
                                    <th>Nome Dr</th>
                                    <th>Paciente</th>
                                    <th>Produto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php
                            if ($_SESSION["userperm"] == 'Distribuidor(a)') {
                                $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
                                while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
                                    $cnpjUser = $rowCnpj['usersCnpj'];
                                }
                            ?>
                                <tbody>
                                    <?php
                                    require_once 'includes/dbh.inc.php';
                                    $ret = mysqli_query($conn, "SELECT * FROM propostas ORDER BY propId DESC");

                                    while ($row = mysqli_fetch_array($ret)) {
                                        //cnpj da proposta deve ser igual ao cnpj do usuario
                                        if ($row['propCnpjCpf'] == $cnpjUser) {
                                            $dataCompleta = $row['propDataCriacao'];
                                            $dataArray = explode(" ", $dataCompleta);
                                            $data = $dataArray[0];
                                            $statustc = $row['propStatusTC'];
                                            $needle = 'REPROVADA';

                                            $numProp = "Prop-" . $row['propId'];
                                    ?>

                                            <tr>
                                                <td><?php echo $numProp; ?></td>
                                                <td><?php echo $data; ?></td>
                                                <td><?php echo $row['propStatusTC']; ?></td>
                                                <td><?php echo $row['propStatus']; ?></td>
                                                <td><?php echo $row['propNomeDr']; ?></td>
                                                <td><?php echo $row['propNomePac']; ?></td>
                                                <td><?php echo $row['propTipoProd']; ?></td>
                                                <td>
                                                    <?php
                                                    // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                    // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                    // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                    // $encrypted = urlencode($encrypted);
                                                    $encrypted = hashItem($row['propId']);

                                                    if ($row['propStatus'] == 'PROP. ENVIADA') {
                                                    ?>
                                                        <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                            <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>

                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($row['propStatus'] == 'APROVADO') {
                                                    ?>
                                                        <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                            <button class="btn text-success btn-xs"><i class="bi bi-check-lg"></i></button></a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                        <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>

                                                </td>
                                            </tr>
                                    <?php

                                        }
                                    }
                                    ?>

                                </tbody>
                            <?php } else { ?>
                                <tbody>
                                    <?php
                                    require_once 'includes/dbh.inc.php';
                                    $ret = mysqli_query($conn, "SELECT * FROM propostas ORDER BY propId DESC");

                                    while ($row = mysqli_fetch_array($ret)) {
                                        if ($row['propUserCriacao'] == $_SESSION["useruid"]) {
                                            $dataCompleta = $row['propDataCriacao'];
                                            $dataArray = explode(" ", $dataCompleta);
                                            $data = $dataArray[0];

                                            $statustc = $row['propStatusTC'];
                                            $needle = 'REPROVADA';

                                            $numProp = $row['propId'];
                                    ?>

                                            <tr>
                                                <td><?php echo $numProp; ?></td>
                                                <td><?php echo $data; ?></td>
                                                <td><?php echo $row['propStatusTC']; ?></td>
                                                <td><?php echo $row['propStatus']; ?></td>
                                                <td><?php echo $row['propNomeDr']; ?></td>
                                                <td><?php echo $row['propNomePac']; ?></td>
                                                <td><?php echo $row['propTipoProd']; ?></td>

                                                <td>
                                                    <?php
                                                    // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                    // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                    // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                    // $encrypted = urlencode($encrypted);

                                                    $encrypted = hashItem($row['propId']);

                                                    if ($row['propStatus'] == 'PROP. ENVIADA') {

                                                    ?>
                                                        <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                            <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($row['propStatus'] == 'APROVADO') {
                                                    ?>
                                                        <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                            <button class="btn text-success btn-xs"><i class="bi bi-check-lg"></i></button></a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                        <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>


                                                </td>
                                            </tr>
                                    <?php

                                        }
                                    }
                                    ?>

                                </tbody>
                            <?php } ?>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<script>
    window.onload = function() {

        var totalVisitors = <?php echo $totalVisitors ?>;
        var visitorsData = {
            "Propostas x Pedidos": [{
                click: visitorsChartDrilldownHandler,
                cursor: "pointer",
                explodeOnClick: false,
                innerRadius: "75%",
                legendMarkerType: "square",
                name: "Propostas x Pedidos",
                radius: "100%",
                showInLegend: true,
                startAngle: 90,
                type: "doughnut",
                dataPoints: <?php echo json_encode($newVsReturningVisitorsDataPoints, JSON_NUMERIC_CHECK); ?>
            }],
            "Propostas": [{
                color: "#E7823A",
                name: "Propostas",
                type: "column",
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($newVisitorsDataPoints, JSON_NUMERIC_CHECK); ?>
            }],
            "Pedidos": [{
                color: "#546BC1",
                name: "Pedidos",
                type: "column",
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($returningVisitorsDataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        };

        var newVSReturningVisitorsOptions = {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Propostas x Pedidos"
            },
            subtitles: [{
                text: "Clique no gráfico",
                backgroundColor: "#ee7624",
                fontSize: 12,
                fontColor: "white",
                padding: 10
            }],
            legend: {
                fontFamily: "calibri",
                fontSize: 12,
                itemTextFormatter: function(e) {
                    return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalVisitors * 100) + "%";
                }
            },
            data: []
        };

        var visitorsDrilldownedChartOptions = {
            animationEnabled: true,
            theme: "light2",
            axisX: {
                labelFontColor: "#717171",
                lineColor: "#a2a2a2",
                tickColor: "#a2a2a2"
            },
            axisY: {
                gridThickness: 0,
                includeZero: false,
                labelFontColor: "#717171",
                lineColor: "#a2a2a2",
                tickColor: "#a2a2a2",
                lineThickness: 1
            },
            data: []
        };

        var chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
        chart.options.data = visitorsData["Propostas x Pedidos"];
        chart.render();

        function visitorsChartDrilldownHandler(e) {
            chart = new CanvasJS.Chart("chartContainer", visitorsDrilldownedChartOptions);
            chart.options.data = visitorsData[e.dataPoint.name];
            chart.options.title = {
                text: e.dataPoint.name
            }
            chart.render();
            $("#backButton").toggleClass("invisible");
        }

        $("#backButton").click(function() {
            $(this).toggleClass("invisible");
            chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
            chart.options.data = visitorsData["Propostas x Pedidos"];
            chart.render();
        });

    }
</script>
<script>
    $(document).ready(function() {
        $('#table').DataTable({
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