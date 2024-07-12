<?php
require_once "includes/dbh.inc.php";
require_once "includes/functions.inc.php";
require_once "graficosdist/pizza-chart.php";
require_once "graficosdist/line-chart.php";
require_once "counterHelpers/counterDist.php";

$values_line = get_values_line($conn);
$options_line = get_options_line($conn);

$valorPropostasTotal = number_format(soma_usuario_valores_propostas($conn), 2, ",", ".");

$arrayColors = getSetOfColors($conn);

$counterProposta = intval(countPropostas($conn));
$counterPropostaPendente = intval(countPropostasPendente($conn));
$counterPedido = intval(countPedido($conn));
$counterPedidoPendente = intval(countPedidoPendente($conn));

$counterPendente = $counterPropostaPendente  + $counterPedidoPendente;

$lastProp = getLastProp($conn);

$retLast = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $lastProp . "';");
while ($rowLast = mysqli_fetch_array($retLast)) {
    $dateProp = dateFormat($rowLast['propDataCriacao']);
    $hourProp = hourFormat($rowLast['propDataCriacao']);
    $lastPropDr = $rowLast['propNomeDr'];
    $lastPropModalidade = $rowLast['propTipoProd'];
}

$lastPropDt = $dateProp . " " . $hourProp;

$lastPed = getLastPed($conn);

$retLastPed = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='" . $lastPed . "';");
while ($rowLastPed = mysqli_fetch_array($retLastPed)) {
    $datePed = dateFormat2($rowLastPed['pedDtCriacaoPed']);
    $hourPed = hourFormat($rowLastPed['pedDtCriacaoPed']);
    $lastPedDr = $rowLastPed['pedNomeDr'];
    $lastPedModalidade = $rowLastPed['pedTipoProduto'];
}

$lastPedDt = $datePed . " " . $hourPed;

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<style>
    .dataTables_length label,
    .dataTables_length select,
    .dataTables_filter label,
    .dataTables_filter label input:focus,
    .dataTables_filter label input {
        color: black;
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
        <div class="row d-flex align-items-start mb-4">
            <div class="col-4 col-md-4 col-sm">
                <div class="card shadow rounded mb-4" style="border-top: #ee7624 7px solid;">
                    <div class="card-body">
                        <h5 class="text-conecta" style="font-weight: 400;"><i class="fas fa-chart-line"></i> Olá, <?php echo $_SESSION["userfirstname"]; ?>! Bem-vindo a <b style="font-weight: 700;">sua Dashboard </b></h5>
                        <span class="text-muted text-small"><?php echo $_SESSION["userperm"]; ?></span>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-conecta" id="titulo-dash">Proposta</h6>
                            <button class="btn text-conecta border" onclick="changedash()"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div id="div-dash-dinamic1">
                            <p style="line-height: 1.5em;"><i class="fas fa-calendar"></i> Última <b><span class="text-conecta"><?php echo $lastPropDt; ?></span></b>
                                <br>
                            <p style="line-height: 1.5em;"><i class="fas fa-boxes"></i> Nº <b><span class="text-conecta"><?php echo $lastProp; ?></span></b> / <b><span class="text-conecta"><?php echo $lastPropDr; ?></span></b> / <b><span class="text-conecta"><?php echo $lastPropModalidade; ?></span></b>
                                <!--<i class="fas fa-smile"></i> Fase: <span class="badge bg-warning text-white">Em Análise</span> há <b><span class="text-conecta">10</span></b> dias-->
                            </p>
                            <!--<p style="line-height: 1.5em;"><i class="far fa-calendar"></i> Devolutiva (previsão): <b><span class="text-conecta">20/01/2023</span></b></p>-->
                            <div class="card-footer d-flex justify-content-center bg-white h-auto">
                                <a href="reenviotc?id=<?php echo hashItemNatural($lastProp); ?>"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver essa proposta </button></a>
                            </div>
                        </div>
                        <div id="div-dash-dinamic2" class="d-none">

                            <!-- <p style="line-height: 1.5em;"><i class="fas fa-boxes"></i> Última pedido <b><span class="text-conecta">1037</span></b>
                                <br><br>
                                <i class="fas fa-smile"></i> Fase: <span class="badge bg-warning text-white">Planejando Aceite</span> há <b><span class="text-conecta">10</span></b> dias
                            </p>
                            <p style="line-height: 1.5em;"><i class="far fa-calendar"></i> Entrega (previsão): <b><span class="text-conecta">20/01/2023</span></b></p> -->
                            <p style="line-height: 1.5em;"><i class="fas fa-calendar"></i> Último <b><span class="text-conecta"><?php echo $lastPedDt; ?></span></b>
                                <br>
                            <p style="line-height: 1.5em;"><i class="fas fa-boxes"></i> Nº <b><span class="text-conecta"><?php echo $lastPed; ?></span></b> / <b><span class="text-conecta"><?php echo $lastPedDr; ?></span></b> / <b><span class="text-conecta"><?php echo $lastPedModalidade; ?></span></b>
                                <!--<i class="fas fa-smile"></i> Fase: <span class="badge bg-warning text-white">Em Análise</span> há <b><span class="text-conecta">10</span></b> dias-->
                            </p>
                            <div class="card-footer d-flex justify-content-center bg-white h-auto">
                                <a href="unit?id=<?php echo hashItemNatural($lastPed); ?>"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver esse pedido </button></a>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="card shadow rounded mb-4" style="background-color: #ee7624; height: auto;">
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
                <div class="card shadow rounded card-chart overflow-scroll" style="border-top: #ee7624 7px solid;">
                    <div class="card-body">
                        <div class="container-fluid">
                            <!--<div class="row">
                                <div class="col pb-4 d-flex justify-content-between align-items-center">
                                    <h4 style="color: #ee7624; font-weight: 400;">Oportunidade</h4>
                                    <button class="btn text-conecta border" onclick="changechart()"><i class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>-->
                            <div class="row">
                                <div class="col">
                                    <!--Gráfico 1-->
                                    <div id="chart1">
                                        <h6 class="text-center">Propostas: <b class="text-conecta">R$ <?php echo $valorPropostasTotal; ?></b></h6>
                                        <h6 class="text-center">Ano: <b class="text-conecta"> <?php echo date('Y'); ?></b></h6>
                                        <!-- <div id="chartLine"></div> -->
                                        <div id="columnchart_values" style="width: auto; height: 500px;"></div>

                                    </div>

                                    <!--Gráfico 2
                                    <div id="chart2" class="d-none">
                                        <//!-- <div id="chartPizza"></div> 
                                        <div id="piechart" style="width: auto; height: 500px;"></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-8 py-0 my-0">
                <div class="card shadow rounded" style="overflow: scroll; border-top: #ee7624 7px solid;">
                    <div class="card-body">
                        <!--Tabs for large devices-->
                        <div class="d-flex justify-content-start px-4">
                            <ul class="nav nav-pills mb-3 px-3 mx-3" id="pills-tab" role="tablist">
                                <li class="nav-item mx-3" role="presentation">
                                    <a class="nav-link active text-tab" id="pills-pedidos-tab" data-toggle="pill" href="#pills-pedidos" role="tab" aria-controls="pills-pedidos" aria-selected="true">Pedidos</a>
                                </li>
                                <li class="nav-item mx-3" role="presentation">
                                    <a class="nav-link text-tab" id="pills-propostas-tab" data-toggle="pill" href="#pills-propostas" role="tab" aria-controls="pills-propostas" aria-selected="true">Propostas</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Tabs for smaller devices -->
                        <div class="d-flex justify-content-start px-4">
                            <ul class="nav nav-pills mb-3 px-3 mx-3" id="pills-tab-small" role="tablist">
                                <li class="nav-item mx-3" role="presentation">
                                    <a class="nav-link d-flex justify-content-center active text-tab" id="pills-pedidos-tab" data-toggle="pill" href="#pills-pedidos" role="tab" aria-controls="pills-pedidos" aria-selected="true">Pedidos</a>
                                </li>
                                <li class="nav-item mx-3" role="presentation">
                                    <a class="nav-link d-flex justify-content-center text-tab" id="pills-propostas-tab" data-toggle="pill" href="#pills-propostas" role="tab" aria-controls="pills-propostas" aria-selected="true">Propostas</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-pedidos" role="tabpanel" aria-labelledby="pills-pedidos-tab">
                                <div id="table1">
                                    <h6 style="color: #ee7624; font-weight: 400;" class="p-2"> Status Pendências (Pedidos)</h6>

                                    <table id="tablePed" class="table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>Data Ped</th>
                                                <th></th>
                                                <th>Nº</th>
                                                <th>Status</th>
                                                <th>Situação</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>Produto</th>
                                                <th>Contato</th>
                                                <th>User</th>

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
                                                // require_once 'includes/dbh.inc.php';
                                                $sql = "SELECT * FROM `pedido` RIGHT JOIN `propostas` ON `pedido`.pedPropRef = `propostas`.propId WHERE pedStatus IN ('CRIADO','PLAN','VIDEO','ACEITE');";
                                                $ret = mysqli_query($conn, $sql);

                                                while ($row = mysqli_fetch_array($ret)) {
                                                    //cnpj da proposta deve ser igual ao cnpj do usuario
                                                    if ($row['propCnpjCpf'] == $cnpjUser) {
                                                        $numPed = $row["pedNumPedido"];
                                                        $dataCompleta = $row['pedDtCriacaoPed'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];
                                                        $status = $row['pedStatus'];
                                                        $needle = 'REPROVADA';

                                                        $numProp = "Prop-" . $row['propId'];

                                                        $nomeFluxo = getNomeFluxoPed($conn, $numPed);
                                                        $corFluxo = getCorFluxoPed($conn, $numPed);
                                                        $contagemDias = getAndamentoForTableFluxoPed($conn, $numPed);

                                                ?>

                                                        <tr>
                                                            <td><?php echo dateFormat2($data); ?></td>
                                                            <td>
                                                                <?php
                                                                $encrypted = hashItemNatural($numPed);

                                                                ?>
                                                                <?php
                                                                if ($status == 'CRIADO') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Verificar Pedido
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($status == 'PLAN') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Verificar Pedido
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($status == 'VIDEO') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Agendar Video
                                                                        </button>
                                                                    </a>

                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($status == 'ACEITE') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Aceitar Proj
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($status == 'PROD') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Baixar Relatório
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>

                                                            </td>
                                                            <td><?php echo $numPed; ?></td>
                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                            <td><?php echo $contagemDias; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>
                                                            <td><?php echo $row['propEmailEnvio']; ?></td>
                                                            <td><?php echo $row['propUserCriacao']; ?></td>

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
                                                $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus='PEDIDO' ORDER BY propId DESC");

                                                while ($row = mysqli_fetch_array($ret)) {
                                                    if ($row['propUserCriacao'] == $_SESSION["useruid"]) {
                                                        // $dataCompleta = $row['propDataCriacao'];
                                                        // $dataArray = explode(" ", $dataCompleta);
                                                        // $data = $dataArray[0];

                                                        // $statustc = $row['propStatusTC'];
                                                        // $needle = 'REPROVADA';

                                                        // $numProp = $row['propId'];

                                                        $numPed = $row["pedNumPedido"];
                                                        $dataCompleta = $row['pedDtCriacaoPed'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];
                                                        $status = $row['pedStatus'];
                                                        $needle = 'REPROVADA';

                                                        $numProp = "Prop-" . $row['propId'];
                                                ?>

                                                        <tr>
                                                            <!-- <td><?php echo $numProp; ?></td>
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

                                                                $encrypted = hashItemNatural($row['propId']);

                                                                if ($row['propStatus'] == 'PROP. ENVIADA') {

                                                                ?>
                                                                    <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>
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


                                                            </td> -->

                                                            <td><?php echo dateFormat2($data); ?></td>
                                                            <td>
                                                                <?php
                                                                $encrypted = hashItemNatural($numPed);

                                                                ?>
                                                                <?php
                                                                if ($status == 'CRIADO') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Verificar Pedido
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($status == 'PLAN') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Verificar Pedido
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($status == 'VIDEO') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Agendar Video
                                                                        </button>
                                                                    </a>

                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($status == 'ACEITE') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Aceitar Proj
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($status == 'PROD') {
                                                                ?>
                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-arrow-right fa-1x"></i> Baixar Relatório
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>

                                                            </td>
                                                            <td><?php echo $numPed; ?></td>
                                                            <td><?php echo $status; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>
                                                            <td><?php echo $row['propEmailEnvio']; ?></td>
                                                            <td><?php echo $row['propUserCriacao']; ?></td>
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

                            <div class="tab-pane fade" id="pills-propostas" role="tabpanel" aria-labelledby="pills-propostas-tab">
                                <div id="table2">
                                    <h6 style="color: #ee7624; font-weight: 400;" class="p-2">Status Pendências (Propostas)</h6>

                                    <table id="tableProp" class="table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nº</th>
                                                <th></th>
                                                <th>Data Envio</th>
                                                <th>TC</th>
                                                <th>Status</th>
                                                <th>Nome Dr</th>
                                                <th>Paciente</th>
                                                <th>Produto</th>

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
                                                // require_once 'includes/dbh.inc.php';
                                                $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE NOT propStatus='PEDIDO' ORDER BY propId DESC");

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
                                                            <td>
                                                                <?php
                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                // $encrypted = urlencode($encrypted);
                                                                $encrypted = hashItemNatural($row['propId']);

                                                                if ($row['propStatus'] == 'PROP. ENVIADA') {
                                                                ?>
                                                                    <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="fas fa-file-pdf fa-1x"></i>
                                                                        </button>
                                                                    </a>
                                                                    <!-- <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a> -->

                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($row['propStatus'] == 'APROVADO') {
                                                                ?>
                                                                    <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn btn-conecta btn-xs">
                                                                            <i class="bi bi-check-lg fa-1x"></i>
                                                                        </button>
                                                                    </a>
                                                                    <!-- <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-success btn-xs"><i class="bi bi-check-lg"></i></button></a> -->
                                                                <?php
                                                                }
                                                                ?>
                                                                <a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                    <button class="btn btn-conecta btn-xs">
                                                                        <i class="bi bi-file-earmark-arrow-up-fill fa-1x"></i>
                                                                    </button>
                                                                </a>

                                                                <!-- <a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                    <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a> -->

                                                            </td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo $row['propStatusTC']; ?></td>
                                                            <td><?php echo $row['propStatus']; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>

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
                                                $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE NOT propStatus='PEDIDO' ORDER BY propId DESC");

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
                                                            <td>
                                                                <?php
                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                // $encrypted = urlencode($encrypted);

                                                                $encrypted = hashItemNatural($row['propId']);

                                                                if ($row['propStatus'] == 'PROP. ENVIADA') {

                                                                ?>
                                                                    <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>
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
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo $row['propStatusTC']; ?></td>
                                                            <td><?php echo $row['propStatus']; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>


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
                <div class="container-fluid p-1">
                    <div class="row pt-3">
                        <h4 class="text-conecta" style="font-weight: 400;">Atividades Distribuidor(a)</h4>
                        <hr style="border-color: #ee7624;">
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">

                        <a class="text-decoration-none pt-2 px-4" href="meususuarios" data-bs-toggle="tooltip" data-bs-placement="top" title="Meus Usuários">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-user fa-1x mr-1" class="iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="meusdoutores" data-bs-toggle="tooltip" data-bs-placement="top" title="Meus Doutores">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-user-tie fa-1x" class=" iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="minhassolicitacoes" data-bs-toggle="tooltip" data-bs-placement="top" title="Propostas Comercial">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-shopping-cart fa-1x" class=" iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="financeiro" data-bs-toggle="tooltip" data-bs-placement="top" title="Financeiro">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-university fa-1x mr-1" class="iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="antecipacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Antecipação">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-shipping-fast fa-1x mr-1" class="iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="meuscasos" data-bs-toggle="tooltip" data-bs-placement="top" title="Pedidos">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="bi bi-collection fa-1x" class=" iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                    <div class="row mb-2 mt-4">
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
                                                <h2 style="text-align: center;" class="pt-3"><b><?php echo $counterProposta; ?></b></h2>
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
                                                <h2 style="text-align: center;" class="pt-3"><b><?php echo $counterPedido; ?></b></h2>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <a href="meuscasos"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>
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
                                                <h2 style="text-align: center;" class="pt-3"><b><?php echo $counterPendente; ?></b></h2>
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

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // var dataPoints = document.getElementById("dataPoints").value;
        // var dataPoints = JSON.stringify(dataPoints);
        // console.log(dataPoints);

        var values_line = document.getElementById("values_line").value.split(',');
        var options_line = document.getElementById("options_line").value.split(',');
        // console.log(values);
        // console.log(options);
        var dataPoints_line = [];
        for (let index = 0; index < options_line.length; index++) {
            let number = parseInt(values_line[index]);
            let array = {
                y: number,
                label: `${options_line[index]}`
            }

            dataPoints_line.push(array);

        }
        console.log(dataPoints_line);

        CanvasJS.addColorSet("conectaColorSet",
            [
                "#f0a16c",
                "#ee7624",
                "#874214",
                "#3b1d09",
                "#3b271a"
            ]);


        var chart = new CanvasJS.Chart("chartLine", {
            colorSet: "conectaColorSet",
            animationEnabled: true,
            title: {
                text: "Propostas x Produtos",
                fontWeight: "normal",
                fontSize: 18,
                fontColor: "#373342"
            },
            axisY: {
                title: "Qtd Produtos",
                includeZero: true,
            },
            data: [{
                type: "bar",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                indexLabelFontColor: "white",
                dataPoints: dataPoints_line
            }]
        });

        chart.render();
    });
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
            title: "Qtd de propostas por mês",

            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
</script>