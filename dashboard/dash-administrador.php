<?php
require_once "includes/dbh.inc.php";
require_once "includes/functions.inc.php";
require_once "graficosadm/pizza-chart.php";
require_once "graficosadm/line-chart.php";
require_once "counterHelpers/counterAll.php";

$values_line = get_values_line($conn);
$options_line = get_options_line($conn);

$valorPropostasTotal = number_format(soma_geral_valores_propostas($conn), 2, ",", ".");
$valorPedidosTotal = number_format(soma_geral_valores_pedidos($conn), 2, ",", ".");

$arrayColors = getSetOfColors($conn);


$counterProposta = intval(countPropostas($conn));
$counterPropostaPendente = intval(countPropostasPendente($conn));
$counterPedido = intval(countPedido($conn));
$counterPedidoPendente = intval(countPedidoPendente($conn));

$counterPendente = $counterPropostaPendente  + $counterPedidoPendente;

$lastProp = getLastProp($conn);

$retLast = mysqli_query($conn, "SELECT *, DATEDIFF(now(),`propData`) as dataContada FROM `propostas` WHERE `propId`='" . $lastProp . "';");
while ($rowLast = mysqli_fetch_array($retLast)) {
    $dateProp = dateFormat($rowLast['propDataCriacao']);
    // $hourProp = hourFormat($rowLast['propDataCriacao']);
    $lastPropDr = $rowLast['propNomeDr'];
    $lastPropStatus = $rowLast['propStatus'];
    $lastPropModalidade = $rowLast['propTipoProd'];
    $lastPropDaysOn = $rowLast['dataContada'];
}


$lastPed = getLastPed($conn);

$retLastPed = mysqli_query($conn, "SELECT *, DATEDIFF(now(),`pedDtCriacaoPed`) as dataContada FROM pedido WHERE pedNumPedido='" . $lastPed . "';");
while ($rowLastPed = mysqli_fetch_array($retLastPed)) {
    $lastPedNumProp = $rowLastPed['pedPropRef'];
    $lastPedStatus = $rowLastPed['pedStatus'];
    $datePed = dateFormat2($rowLastPed['pedDtCriacaoPed']);
    $hourPed = hourFormat($rowLastPed['pedDtCriacaoPed']);
    $lastPedDr = $rowLastPed['pedNomeDr'];
    $lastPedModalidade = $rowLastPed['pedTipoProduto'];
    $lastPedDaysOn = $rowLastPed['dataContada'];
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
</style>
<div id="main" class="font-montserrat">
    <div hidden>
        <input class="form-control" id="values_line" type="text" value="<?php echo $values_line; ?>">
        <input class="form-control" id="options_line" type="text" value="<?php echo $options_line; ?>">
    </div>
    <div class="container-fluid">

        <?php include("dashComponents/rowofbuttons.comp.php"); ?>
        <div class="row d-flex align-items-center mb-4">
            <div class="col-4 col-md-4 col-sm">
                <div class="card shadow rounded" style="border-top: #ee7624 7px solid;">
                    <div class="card-body">
                        <h5 class="text-conecta" style="font-weight: 400;"><i class="fas fa-chart-line"></i> Olá, <?php echo $_SESSION["userfirstname"]; ?>! Bem-vindo a <b style="font-weight: 700;">sua Dashboard </b></h5>
                        <span class="text-muted text-small"><?php echo $_SESSION["userperm"]; ?></span>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-conecta" id="titulo-dash">Propostas</h6>
                            <button class="btn text-conecta border" onclick="changedash()"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div id="div-dash-dinamic1">
                            <p style="line-height: 1.5em;"><i class="fas fa-boxes"></i> Última proposta <b><span class="text-conecta"><?php echo $lastProp; ?></span></b>
                                <br><br>
                                <i class="fas fa-smile"></i> Status: <span class="badge bg-warning text-white"><?php echo $lastPropStatus; ?></span>
                                <br><br>
                                <i class="far fa-calendar"></i> Chegou há <b><span class="text-conecta"><?php echo $lastPropDaysOn; ?></span></b> dias
                            </p>
                            <div class="card-footer d-flex justify-content-center bg-white h-auto">
                                <a href="update-proposta?id=<?php echo $lastProp; ?>"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver essa proposta </button></a>
                            </div>
                        </div>
                        <div id="div-dash-dinamic2" class="d-none">

                            <p style="line-height: 1.5em;"><i class="fas fa-boxes"></i> Último pedido <b><span class="text-conecta"><?php echo $lastPed; ?></span></b>
                                <br><br>
                                <i class="fas fa-smile"></i> Status: <span class="badge bg-warning text-white"><?php echo $lastPedStatus; ?></span>
                                <br><br>
                                <i class="far fa-calendar"></i> Criado há <b><span class="text-conecta"><?php echo $lastPedDaysOn; ?></span></b> dias
                            </p>
                            <div class="card-footer d-flex justify-content-center bg-white h-auto">
                                <a href="unit?id=<?php echo hashItemNatural($lastPedNumProp); ?>"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver esse pedido </button></a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-8 d-flex justify-content-center align-items-center">
                <div class="container-fluid p-1">
                    <div class="row">
                        <h4 class="text-conecta p-0" style="font-weight: 400;">Dados Rápidos</h4>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col pb-1">
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
                                    <a href="comercial"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>
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
                                    <a href="casos"><button class="btn btn-sm text-conecta" style="border: 1px #dbdbdb solid;">Ver mais </button></a>
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
                                                    <h4 class="text-white" style="text-align: center; font-size: 10pt !important;"><i class="fas fa-plus"></i> Nova Solicitação de Proposta</h4>
                                                    <a href="solicitacao" class="text-decoration-none"><button class="btn btn-light hover-bigger" style="color: #ee7624; font-size: 8pt;">Acesse aqui</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row pt-3">
                        <h4 class="text-conecta" style="font-weight: 400;">Atividades ADM</h4>
                        <hr style="border-color: #ee7624;">
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">

                        <a class="text-decoration-none pt-2 px-4" href="users" data-bs-toggle="tooltip" data-bs-placement="top" title="Usuários">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-user fa-1x mr-1" class="iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="mudarsenha" data-bs-toggle="tooltip" data-bs-placement="top" title="Mudar Senha">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-unlock-alt fa-1x mr-1" class="iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="adicionarlink" data-bs-toggle="tooltip" data-bs-placement="top" title="Adicionar Link do Drive">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-link fa-1x mr-1" class="iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="representantes" data-bs-toggle="tooltip" data-bs-placement="top" title="Representantes">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-user-tie fa-1x" class=" iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="comercial" data-bs-toggle="tooltip" data-bs-placement="top" title="Propostas Comercial">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-shopping-cart fa-1x" class=" iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="planejamento" data-bs-toggle="tooltip" data-bs-placement="top" title="Análise de TC">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="fas fa-desktop fa-1x" class=" iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a class="text-decoration-none pt-2 px-4" href="casos" data-bs-toggle="tooltip" data-bs-placement="top" title="Planejamento de Casos">
                            <div class="indexCard d-flex justify-content-center align-items-center">
                                <div class="btn btn-conecta btn-circle shadow p-1 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <i class="bi bi-collection fa-1x" class=" iconesIndex"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-4 col-md-4 col-sm mb-2">
                <div class="card shadow rounded card-chart overflow-scroll">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col pb-4 d-flex justify-content-between align-items-center">
                                    <h4 style="color: #ee7624; font-weight: 400;">Oportunidade</h4>
                                    <button class="btn text-conecta border" onclick="changechart()"><i class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <!--Gráfico 1-->
                                    <div id="chart1">
                                        <h6 class="text-center">Propostas: <b class="text-conecta">R$ <?php echo $valorPropostasTotal; ?></b></h6>
                                        <h6 class="text-center">Pedidos: <b class="text-conecta">R$ <?php echo $valorPedidosTotal; ?></b></h6>
                                        <h6 class="text-center">Ano: <b class="text-conecta"> <?php echo date('Y'); ?></b></h6>
                                        <!-- <div id="chartLine"></div> -->
                                        <div id="columnchart_values" style="width: auto; height: 500px;"></div>

                                    </div>

                                    <!--Gráfico 2-->
                                    <div id="chart2" class="d-none">
                                        <!-- <div id="chartPizza"></div> -->
                                        <div id="piechart" style="width: auto; height: 500px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-8">
                <div class="card shadow rounded" style="overflow: scroll;">
                    <div class="card-header d-flex justify-content-end align-items-center">
                        <div class="p-1 d-flex justify-content-end align-items-center">
                            <button class="btn text-conecta border" onclick="changetable()"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="table1">
                            <h4 style="color: #ee7624; font-weight: 400;">Propostas</h4>
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
                                                    <td>
                                                        <?php
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
                                                    <td>
                                                        <?php
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
                        <div id="table2" class="d-none">
                            <h4 style="color: #ee7624; font-weight: 400;">Pedidos</h4>
                            <table id="tablePed" class="table table-striped table-advance table-hover bg-white rounded">

                                <thead class="text-conecta">
                                    <tr>
                                        <th>Nº</th>
                                        <th>Data Chegada</th>
                                        <th>Status</th>
                                        <th>Empresa</th>
                                        <th>Dr(a)</th>
                                        <th>Paciente</th>
                                        <th>Produto</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: white;">
                                    <?php
                                    require_once 'includes/dbh.inc.php';

                                    $sql = "SELECT * FROM `pedido` RIGHT JOIN `propostas` ON `pedido`.pedPropRef = `propostas`.propId WHERE pedStatus LIKE '%CRIADO%';";
                                    $ret = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($ret)) {

                                        $retFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                        if (($retFin) && ($retFin->num_rows != 0)) {
                                            $temFin = true;
                                        } else {
                                            $temFin = false;
                                        }

                                        $bdRepresentante = $row["propRepresentante"];
                                        $retRep = mysqli_query($conn, "SELECT * FROM representantes WHERE repUid='" . $bdRepresentante . "';");
                                        if (($retRep) && ($retRep->num_rows != 0)) {
                                            while ($rowRep = mysqli_fetch_array($retRep)) {
                                                $representante = $rowRep["repNome"];
                                            }
                                        }

                                        $dataCompleta = $row['pedDtCriacaoPed'];
                                        $dataArray = explode(" ", $dataCompleta);
                                        $data = $dataArray[0];
                                        $data = explode("-", $data);
                                        $data = $data[2] . "/" . $data[1] . "/" . $data[0];

                                        //Cores Status TC
                                        if ($row['pedStatus'] == "PROD") {
                                            $moodStatus = "bg-success";
                                            $colorText = "";
                                        } else {

                                            if (strpos($row['pedStatus'], 'PLAN') !== false) {
                                                $moodStatus = "bg-primary";
                                            } else {
                                                $moodStatus = "bg-amarelo text-dark";
                                            }
                                        }



                                        if ($row['propEmpresa'] != null) {
                                            $empresa = $row['propEmpresa'];
                                            $classEmpresa = '';
                                        } else {
                                            $empresa = '-';
                                            $classEmpresa = 'class="text-center"';
                                        }

                                    ?>

                                        <tr>

                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                            <td><?php echo $data; ?></td>
                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['pedStatus']; ?></span></td>
                                            <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                            <td><?php echo $row['propNomeDr']; ?></td>
                                            <td><?php echo $row['propNomePac']; ?></td>
                                            <td><?php echo $row['propTipoProd']; ?></td>

                                        </tr>
                                    <?php
                                    } ?>

                                </tbody>
                            </table>
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