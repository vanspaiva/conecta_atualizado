<?php
require_once "includes/dbh.inc.php";
require_once "includes/functions.inc.php";
require_once "graficosdist/pizza-chart.php";
require_once "graficosdist/line-chart.php";
require_once "counterHelpers/counterDoutor.php";

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
    $lastPedDr = $rowLastPed['pedNomeDr'];
    $lastPedModalidade = $rowLastPed['pedTipoProduto'];
    $lastPedDaysOn = $rowLastPed['dataContada'];
}


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

    #span-img {
        background-color: #645a82 !important;
        padding: 10px !important;
        border: 2px solid #645a82 !important;
        border-radius: 10px !important;
        height: auto !important;
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

    .bg-cinza {
        background-color: #cfcfcf;
    }

    .bg-lilas {
        background-color: #8665E6;
    }
</style>
<div id="main" class="font-montserrat">
    <div hidden>
        <input class="form-control" id="values_line" type="text" value="<?php echo $values_line; ?>">
        <input class="form-control" id="options_line" type="text" value="<?php echo $options_line; ?>">
    </div>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-start">
            <div class="col">
                <div class="container-fluid">
                    <div class="row p-2">
                        <div class="col">
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
                    <div class="row p-2">
                        <div class="col">
                            <div class="card shadow rounded" style="border-top: #ee7624 7px solid;">
                                <div class="card-body">
                                    <h5 class="text-conecta" style="font-weight: 400;"><i class="fas fa-chart-line"></i> Olá, <?php echo $_SESSION["userfirstname"]; ?>! Bem-vindo a <b style="font-weight: 700;">sua Dashboard </b></h5>
                                    <span class="text-muted text-small"><?php echo $_SESSION["userperm"]; ?></span>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-conecta" id="titulo-dash">Pedidos</h6>
                                    </div>
                                    <div id="div-dash-dinamic2">

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
                    </div>
                    
                    <div class="row p-2">
                        <div class="col">
                            <div class="card shadow rounded">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h6 class="text-muted" id="titulo-dash">Menu Rápido</h6>
                                    </div>
                                    <hr>
                                    <div id="div-dash-dinamic2">
                                        <a class="text-decoration-none text-conecta" href="dadosproduto" target="_blank">
                                            <div>
                                                <i class="fas fa-angle-double-right"></i>
                                                Formulários dos Produtos
                                            </div>
                                        </a>
                                        <br>
                                        <a class="text-decoration-none text-conecta" href="materiais" target="_blank">
                                            <div>
                                                <i class="fas fa-angle-double-right"></i>
                                                Materiais de Mídia
                                            </div>
                                        </a>
                                        <br>
                                        <a class="text-decoration-none text-conecta" href="tecnicacir" target="_blank">
                                            <div>
                                                <i class="fas fa-angle-double-right"></i>
                                                Técnica Cirúrgica
                                            </div>
                                        </a>
                                        <br>
                                        <a class="text-decoration-none text-conecta" href="sac" target="_blank">
                                            <div>
                                                <i class="fas fa-angle-double-right"></i>
                                                Deixe Seus Elogios Ou Reclamações
                                            </div>
                                        </a>
                                        <br>
                                        <a class="text-decoration-none text-conecta" href="https://api.whatsapp.com/send?phone=5561999468880&text=Ol%C3%A1!%20Vim%20do%20Conecta%202.0%2C%20estou%20precisando%20de%20ajuda" target="_blank">
                                            <div>
                                                <i class="fas fa-angle-double-right"></i>
                                                Suporte Técnico
                                            </div>
                                        </a>
                                        <br>
                                        <a class="text-decoration-none text-conecta" href="visitafabrica" target="_blank">
                                            <div>
                                                <i class="fas fa-angle-double-right"></i>
                                                Visitar a Fábrica
                                            </div>
                                        </a>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <div class="container-fluid">
                    <div class="row py-4 d-flex justify-content-center">
                        <div class="col-sm-10">
                            <div class="card w-100" style="overflow-x: scroll;">
                                <div class="card-body">
                                    <!--Casos Abertos, Casos Pendentes, Casos Finalizados e Casos Arquivados-->
                                    <!--Tabs for large devices-->
                                    <ul class="nav nav-pills mb-3 px-2" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-tab" id="pills-abertos-tab" data-toggle="pill" href="#pills-abertos" role="tab" aria-controls="pills-abertos" aria-selected="true">Abertos</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active text-tab" id="pills-pendentes-tab" data-toggle="pill" href="#pills-pendentes" role="tab" aria-controls="pills-pendentes" aria-selected="true">Pendentes</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-tab" id="pills-finalizados-tab" data-toggle="pill" href="#pills-finalizados" role="tab" aria-controls="pills-finalizados" aria-selected="false">Finalizados</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-tab" id="pills-arquivados-tab" data-toggle="pill" href="#pills-arquivados" role="tab" aria-controls="pills-arquivados" aria-selected="false">Arquivados</a>
                                        </li>
                                    </ul>

                                    <!--Tabs for smaller devices-->
                                    <ul class="nav nav-pills mb-3 px-2" id="pills-tab-small" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-tab" id="pills-abertos-tab" data-toggle="pill" href="#pills-abertos" role="tab" aria-controls="pills-abertos" aria-selected="true">
                                                <div class="svg-iten-nav">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21.899" height="29.45" viewBox="0 0 21.899 29.45">
                                                        <g id="Grupo_972" data-name="Grupo 972" transform="translate(0 0)">
                                                            <g id="Grupo_967" data-name="Grupo 967" transform="translate(0 0)">
                                                                <path id="Caminho_2444" data-name="Caminho 2444" d="M671.792,2267.69a6.049,6.049,0,0,1,0-.764,1.963,1.963,0,0,1,1.971-1.746c1.864-.017,3.728-.02,5.592,0a1.978,1.978,0,0,1,1.984,2.04c0,.143,0,.286,0,.47h.319q1.8,0,3.6,0a1.982,1.982,0,0,1,2.082,2.082q0,11.212,0,22.425a1.992,1.992,0,0,1-2.116,2.109q-3.833.005-7.667,0-4.842,0-9.685,0a1.989,1.989,0,0,1-2.069-1.6,2.655,2.655,0,0,1-.04-.544c0-7.427.014-14.854-.015-22.281a2.109,2.109,0,0,1,2.218-2.2c1.151.047,2.306.01,3.458.01Zm-.041,1.369h-3.762c-.668,0-.859.189-.859.851q0,11.1,0,22.193c0,.634.207.841.848.841h17.149c.675,0,.867-.194.867-.881q0-3.229,0-6.456,0-7.854,0-15.709c0-.647-.192-.838-.844-.838q-1.758,0-3.516,0c-.092,0-.183.01-.289.016,0,.2,0,.373,0,.545a1.975,1.975,0,0,1-1.936,1.938q-2.853.022-5.707,0a1.939,1.939,0,0,1-1.872-1.58A8.767,8.767,0,0,1,671.751,2269.06Zm4.809-2.521c-.9,0-1.806,0-2.709,0a.627.627,0,0,0-.7.688q-.007,1.138,0,2.276a.63.63,0,0,0,.718.7q2.694.007,5.388,0a.64.64,0,0,0,.719-.734q0-1.095,0-2.189c0-.525-.227-.745-.762-.746Q677.885,2266.537,676.56,2266.539Z" transform="translate(-665.603 -2265.013)" fill="#4f4f51" />
                                                                <path id="Caminho_2445" data-name="Caminho 2445" d="M681.555,2294.173h-6.827q-3.568,0-7.137,0a2.139,2.139,0,0,1-2.22-1.721,2.774,2.774,0,0,1-.043-.576q0-3.1,0-6.2c0-5.269,0-10.718-.016-16.077a2.376,2.376,0,0,1,.708-1.743,2.256,2.256,0,0,1,1.67-.613c.795.032,1.607.025,2.392.017.353,0,.707-.007,1.06-.007h.2c0-.037,0-.073,0-.109a3.1,3.1,0,0,1,.012-.522,2.126,2.126,0,0,1,2.122-1.879c2.069-.019,3.9-.018,5.595,0a2.123,2.123,0,0,1,2.136,2.191c0,.1,0,.192,0,.3v.019h3.768a2.141,2.141,0,0,1,2.236,2.235v22.425a2.146,2.146,0,0,1-2.269,2.262Zm-4.278-.308h2.14q2.764,0,5.527,0a1.837,1.837,0,0,0,1.962-1.955v-22.425a1.827,1.827,0,0,0-1.929-1.928H680.9v-.327c0-.106,0-.2,0-.3a1.826,1.826,0,0,0-1.832-1.887c-1.694-.019-3.522-.02-5.589,0a1.8,1.8,0,0,0-1.82,1.613,2.812,2.812,0,0,0-.009.47c0,.087.006.177.006.273v.154h-.512c-.352,0-.7,0-1.057.007-.789.007-1.6.016-2.408-.017a1.939,1.939,0,0,0-1.445.528,2.071,2.071,0,0,0-.614,1.521c.02,5.36.018,10.809.016,16.078q0,3.1,0,6.2a2.492,2.492,0,0,0,.037.512,1.844,1.844,0,0,0,1.919,1.478q3.568,0,7.136,0Zm7.561-1.057H667.688c-.721,0-1-.278-1-.994v-22.193a1.037,1.037,0,0,1,.224-.783,1.053,1.053,0,0,1,.787-.221H671.6l.011.141c.008.108.014.212.019.314a4.449,4.449,0,0,0,.056.589,1.777,1.777,0,0,0,1.722,1.455c2.095.014,3.961.014,5.7,0a1.813,1.813,0,0,0,1.783-1.789c0-.114,0-.228,0-.35v-.336l.244-.015c.069-.005.134-.01.2-.01q1.759,0,3.517,0c.736,0,1,.26,1,.992v22.164C685.857,2292.548,685.6,2292.808,684.837,2292.808Zm-17.14-23.885a.819.819,0,0,0-.57.133.8.8,0,0,0-.133.565v22.193c0,.552.136.688.694.688h17.149c.593,0,.712-.123.713-.728V2269.61c0-.563-.123-.685-.69-.685q-1.758,0-3.516,0c-.044,0-.088,0-.135.006v.044c0,.126,0,.244,0,.362a2.119,2.119,0,0,1-2.088,2.087c-1.745.014-3.612.013-5.709,0a2.085,2.085,0,0,1-2.022-1.705,4.691,4.691,0,0,1-.061-.63c0-.053-.006-.109-.009-.164H667.7Zm9,1.151q-1.56,0-3.119,0a.783.783,0,0,1-.871-.855q-.007-1.139,0-2.278a.776.776,0,0,1,.856-.841c.642,0,1.283,0,1.925,0h3.435c.623,0,.914.287.916.9q0,1.1,0,2.191a.789.789,0,0,1-.872.887ZM674.7,2266.4h-1.14c-.373,0-.548.172-.55.535q-.007,1.138,0,2.274c0,.385.171.549.565.55q2.693.006,5.387,0c.4,0,.564-.169.565-.581q0-1.094,0-2.188c0-.437-.161-.592-.609-.593H674.7Z" transform="translate(-665.314 -2264.723)" fill="#4f4f51" />
                                                            </g>
                                                            <g id="Grupo_971" data-name="Grupo 971" transform="translate(5.505 10.538)">
                                                                <g id="Grupo_968" data-name="Grupo 968" transform="translate(0.002 5.358)">
                                                                    <path id="Caminho_2446" data-name="Caminho 2446" d="M686.929,2311h4.378a2.663,2.663,0,0,1,.345.008.673.673,0,0,1,.578.624.661.661,0,0,1-.513.7,1.544,1.544,0,0,1-.342.03q-4.45,0-8.9,0a1.3,1.3,0,0,1-.423-.06.668.668,0,0,1-.4-.747.675.675,0,0,1,.7-.555Q684.639,2311,686.929,2311Z" transform="translate(-681.48 -2310.843)" fill="#4f4f51" />
                                                                    <path id="Caminho_2447" data-name="Caminho 2447" d="M687.125,2312.228l-4.94,0a1.4,1.4,0,0,1-.475-.069.831.831,0,0,1,.35-1.6q1.546,0,3.092,0H691.1a1.852,1.852,0,0,1,.283.01.825.825,0,0,1,.711.766.813.813,0,0,1-.633.862,1.734,1.734,0,0,1-.377.034Zm-2.777-1.366-2.287,0a.522.522,0,0,0-.553.432.514.514,0,0,0,.306.571,1.129,1.129,0,0,0,.373.051q4.449,0,8.9,0a1.426,1.426,0,0,0,.309-.026.51.51,0,0,0,.394-.543.516.516,0,0,0-.445-.481,1.613,1.613,0,0,0-.238-.008h-6.756Z" transform="translate(-681.19 -2310.554)" fill="#4f4f51" />
                                                                </g>
                                                                <g id="Grupo_969" data-name="Grupo 969" transform="translate(0)">
                                                                    <path id="Caminho_2448" data-name="Caminho 2448" d="M686.936,2296.92h-4.262c-.106,0-.212,0-.317,0a.686.686,0,1,1,.018-1.367c.912,0,1.824,0,2.736,0,2.1,0,4.2,0,6.307.009a1.09,1.09,0,0,1,.6.2.582.582,0,0,1,.165.707.664.664,0,0,1-.669.451c-.653.007-1.306,0-1.959,0Z" transform="translate(-681.474 -2295.394)" fill="#4f4f51" />
                                                                    <path id="Caminho_2449" data-name="Caminho 2449" d="M690.22,2296.785H682.3c-.081,0-.162,0-.242,0a.839.839,0,1,1,.024-1.674c.684,0,1.368,0,2.053,0h2.023c1.657,0,3.313,0,4.969.01a1.236,1.236,0,0,1,.692.231.727.727,0,0,1,.218.883.82.82,0,0,1-.812.551Q690.724,2296.785,690.22,2296.785Zm-6.767-1.372q-.684,0-1.367,0a.533.533,0,1,0-.012,1.06c.075,0,.152,0,.227,0h7.469c.485,0,.97,0,1.454,0a.512.512,0,0,0,.527-.351.444.444,0,0,0-.113-.529.94.94,0,0,0-.511-.17c-1.656-.012-3.312-.011-4.967-.01h-2.708Z" transform="translate(-681.185 -2295.105)" fill="#4f4f51" />
                                                                </g>
                                                                <g id="Grupo_970" data-name="Grupo 970" transform="translate(0 10.719)">
                                                                    <path id="Caminho_2450" data-name="Caminho 2450" d="M686.938,2326.452c1.526,0,3.052,0,4.578,0a.675.675,0,0,1,.292,1.3,1.183,1.183,0,0,1-.395.056q-2.332.005-4.665,0c-1.449,0-2.9,0-4.348,0a.683.683,0,1,1-.012-1.356Q684.663,2326.449,686.938,2326.452Z" transform="translate(-681.473 -2326.297)" fill="#4f4f51" />
                                                                    <path id="Caminho_2451" data-name="Caminho 2451" d="M683.824,2327.675q-.856,0-1.713,0a.936.936,0,0,1-.793-.382.8.8,0,0,1-.073-.754.828.828,0,0,1,.854-.528q1.729,0,3.458,0h2.476q1.6,0,3.195,0a.828.828,0,0,1,.344,1.6,1.315,1.315,0,0,1-.447.064q-1.828,0-3.656,0h-3.644Zm.311-1.36H682.1a.539.539,0,0,0-.568.332.5.5,0,0,0,.04.469.637.637,0,0,0,.54.248q1.515,0,3.03,0h2.326q1.828,0,3.656,0a1.01,1.01,0,0,0,.343-.047.521.521,0,0,0-.24-1q-1.6,0-3.194,0h-3.9Z" transform="translate(-681.185 -2326.008)" fill="#4f4f51" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active text-tab" id="pills-pendentes-tab" data-toggle="pill" href="#pills-pendentes" role="tab" aria-controls="pills-pendentes" aria-selected="true">
                                                <div class="svg-iten-nav">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21.899" height="29.45" viewBox="0 0 21.899 29.45">
                                                        <g id="Grupo_976" data-name="Grupo 976" transform="translate(0 0)">
                                                            <g id="Grupo_973" data-name="Grupo 973" transform="translate(5.183 11.195)">
                                                                <path id="Caminho_2452" data-name="Caminho 2452" d="M820.847,2308.533a5.766,5.766,0,1,1,5.766-5.766A5.773,5.773,0,0,1,820.847,2308.533Zm0-10.61a4.844,4.844,0,1,0,4.844,4.844A4.849,4.849,0,0,0,820.847,2297.922Z" transform="translate(-815.081 -2297)" fill="#4f4f51" />
                                                                <path id="Caminho_2453" data-name="Caminho 2453" d="M829.751,2312.708a1.038,1.038,0,1,1,1.038-1.038A1.039,1.039,0,0,1,829.751,2312.708Zm0-1.153a.115.115,0,1,0,.115.115A.115.115,0,0,0,829.751,2311.555Z" transform="translate(-823.985 -2305.904)" fill="#4f4f51" />
                                                                <path id="Caminho_2454" data-name="Caminho 2454" d="M831.12,2308.043a.462.462,0,0,1-.461-.461v-2.306a.461.461,0,1,1,.923,0v1.75l3.1-.588a.461.461,0,1,1,.172.906l-3.65.692A.444.444,0,0,1,831.12,2308.043Z" transform="translate(-825.256 -2302.104)" fill="#4f4f51" />
                                                            </g>
                                                            <g id="Grupo_975" data-name="Grupo 975" transform="translate(0 0)">
                                                                <g id="Grupo_974" data-name="Grupo 974">
                                                                    <path id="Caminho_2455" data-name="Caminho 2455" d="M806.616,2267.69a6.033,6.033,0,0,1,0-.764,1.962,1.962,0,0,1,1.971-1.746c1.864-.017,3.728-.02,5.592,0a1.977,1.977,0,0,1,1.984,2.04c0,.143,0,.286,0,.47h.319q1.8,0,3.6,0a1.982,1.982,0,0,1,2.083,2.082q0,11.212,0,22.425a1.992,1.992,0,0,1-2.116,2.109q-3.834.005-7.667,0-4.843,0-9.685,0a1.989,1.989,0,0,1-2.069-1.6,2.638,2.638,0,0,1-.04-.544c0-7.427.013-14.854-.014-22.281a2.109,2.109,0,0,1,2.218-2.2c1.151.047,2.306.01,3.458.01Zm-.041,1.369h-3.762c-.668,0-.859.189-.859.851q0,11.1,0,22.193c0,.634.207.841.848.841h17.15c.675,0,.866-.194.866-.881q0-3.229,0-6.456,0-7.854,0-15.709c0-.647-.193-.838-.844-.838q-1.759,0-3.516,0c-.092,0-.183.01-.289.016,0,.2,0,.373,0,.545a1.975,1.975,0,0,1-1.935,1.938q-2.853.022-5.707,0a1.939,1.939,0,0,1-1.872-1.58A8.952,8.952,0,0,1,806.575,2269.06Zm4.809-2.521c-.9,0-1.805,0-2.708,0a.627.627,0,0,0-.7.688q-.007,1.138,0,2.276a.631.631,0,0,0,.718.7q2.694.007,5.388,0a.639.639,0,0,0,.718-.734q0-1.095,0-2.189c0-.525-.228-.745-.762-.746Q812.709,2266.537,811.384,2266.539Z" transform="translate(-800.427 -2265.013)" fill="#4f4f51" />
                                                                    <path id="Caminho_2456" data-name="Caminho 2456" d="M816.378,2294.173h-6.827q-3.568,0-7.137,0a2.139,2.139,0,0,1-2.219-1.721,2.774,2.774,0,0,1-.043-.576q0-3.1,0-6.2c0-5.269,0-10.718-.016-16.077a2.375,2.375,0,0,1,.708-1.743,2.256,2.256,0,0,1,1.67-.613c.795.032,1.607.025,2.392.017.353,0,.707-.007,1.06-.007h.2c0-.037,0-.073,0-.109a3.1,3.1,0,0,1,.012-.522,2.125,2.125,0,0,1,2.122-1.879c2.069-.019,3.9-.018,5.6,0a2.123,2.123,0,0,1,2.136,2.191c0,.1,0,.192,0,.3v.019H819.8a2.141,2.141,0,0,1,2.235,2.235v22.425a2.147,2.147,0,0,1-2.269,2.262Zm-4.278-.308h2.14q2.764,0,5.527,0a1.837,1.837,0,0,0,1.963-1.955v-22.425a1.828,1.828,0,0,0-1.929-1.928h-4.076v-.327c0-.106,0-.2,0-.3a1.826,1.826,0,0,0-1.832-1.887c-1.694-.019-3.522-.02-5.589,0a1.8,1.8,0,0,0-1.82,1.613,2.818,2.818,0,0,0-.009.47c0,.087.006.177.006.273v.154h-.512c-.352,0-.7,0-1.057.007-.789.007-1.6.016-2.408-.017a1.938,1.938,0,0,0-1.444.528,2.071,2.071,0,0,0-.614,1.521c.02,5.36.018,10.809.016,16.078q0,3.1,0,6.2a2.518,2.518,0,0,0,.037.512,1.845,1.845,0,0,0,1.919,1.478q3.568,0,7.136,0Zm7.561-1.057h-17.15c-.72,0-1-.278-1-.994v-22.193a1.036,1.036,0,0,1,.224-.783,1.053,1.053,0,0,1,.787-.221h3.906l.011.141c.008.108.014.212.019.314a4.378,4.378,0,0,0,.056.589,1.776,1.776,0,0,0,1.722,1.455c2.095.014,3.961.014,5.7,0a1.813,1.813,0,0,0,1.783-1.789c0-.114,0-.228,0-.35v-.336l.244-.015c.069-.005.133-.01.2-.01q1.759,0,3.517,0c.736,0,1,.26,1,.992v22.164C820.681,2292.548,820.423,2292.808,819.661,2292.808Zm-17.14-23.885a.818.818,0,0,0-.57.133.8.8,0,0,0-.134.565v22.193c0,.552.136.688.694.688h17.15c.593,0,.713-.123.713-.728V2269.61c0-.563-.123-.685-.691-.685q-1.758,0-3.516,0c-.044,0-.088,0-.135.006v.044c0,.126,0,.244,0,.362a2.119,2.119,0,0,1-2.088,2.087c-1.745.014-3.612.013-5.709,0a2.085,2.085,0,0,1-2.022-1.705,4.652,4.652,0,0,1-.061-.63c0-.053-.006-.109-.009-.164h-3.621Zm9,1.151q-1.56,0-3.119,0a.782.782,0,0,1-.871-.855q-.007-1.139,0-2.278a.776.776,0,0,1,.856-.841c.642,0,1.284,0,1.925,0h3.435c.623,0,.914.287.916.9q0,1.1,0,2.191a.789.789,0,0,1-.872.887Zm-1.993-3.672h-1.14c-.373,0-.548.172-.55.535q-.007,1.138,0,2.274c0,.385.171.549.565.55q2.694.006,5.387,0c.4,0,.564-.169.565-.581q0-1.094,0-2.188c0-.437-.161-.592-.609-.593h-4.219Z" transform="translate(-800.138 -2264.723)" fill="#4f4f51" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-tab" id="pills-finalizados-tab" data-toggle="pill" href="#pills-finalizados" role="tab" aria-controls="pills-finalizados" aria-selected="false">
                                                <div class="svg-iten-nav">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21.899" height="29.45" viewBox="0 0 21.899 29.45">
                                                        <g id="Grupo_979" data-name="Grupo 979" transform="translate(0 0)">
                                                            <g id="Grupo_978" data-name="Grupo 978" transform="translate(0 0)">
                                                                <g id="Grupo_977" data-name="Grupo 977">
                                                                    <path id="Caminho_2457" data-name="Caminho 2457" d="M941.439,2267.69a6.025,6.025,0,0,1,0-.764,1.963,1.963,0,0,1,1.971-1.746c1.864-.017,3.728-.02,5.592,0a1.978,1.978,0,0,1,1.984,2.04c0,.143,0,.286,0,.47h.319q1.8,0,3.6,0a1.982,1.982,0,0,1,2.082,2.082q0,11.212,0,22.425a1.992,1.992,0,0,1-2.116,2.109q-3.833.005-7.667,0-4.842,0-9.685,0a1.989,1.989,0,0,1-2.069-1.6,2.659,2.659,0,0,1-.04-.544c0-7.427.014-14.854-.015-22.281a2.109,2.109,0,0,1,2.218-2.2c1.151.047,2.305.01,3.458.01Zm-.041,1.369h-3.762c-.668,0-.859.189-.859.851q0,11.1,0,22.193c0,.634.206.841.848.841h17.149c.675,0,.867-.194.867-.881q0-3.229,0-6.456,0-7.854,0-15.709c0-.647-.192-.838-.844-.838q-1.758,0-3.516,0c-.091,0-.183.01-.289.016,0,.2,0,.373,0,.545a1.975,1.975,0,0,1-1.935,1.938q-2.853.022-5.707,0a1.939,1.939,0,0,1-1.872-1.58A8.8,8.8,0,0,1,941.4,2269.06Zm4.809-2.521c-.9,0-1.806,0-2.708,0a.627.627,0,0,0-.7.688q-.007,1.138,0,2.276a.631.631,0,0,0,.718.7q2.694.007,5.388,0a.64.64,0,0,0,.719-.734q0-1.095,0-2.189c0-.525-.228-.745-.762-.746Q947.533,2266.537,946.207,2266.539Z" transform="translate(-935.251 -2265.013)" fill="#4f4f51" />
                                                                    <path id="Caminho_2458" data-name="Caminho 2458" d="M951.2,2294.173h-6.827q-3.568,0-7.136,0a2.139,2.139,0,0,1-2.219-1.721,2.75,2.75,0,0,1-.043-.576q0-3.1,0-6.2c0-5.269,0-10.718-.016-16.077a2.375,2.375,0,0,1,.707-1.743,2.256,2.256,0,0,1,1.67-.613c.795.032,1.607.025,2.392.017.353,0,.707-.007,1.06-.007h.2c0-.037,0-.073,0-.109a3.065,3.065,0,0,1,.012-.522,2.125,2.125,0,0,1,2.122-1.879c2.069-.019,3.9-.018,5.595,0a2.123,2.123,0,0,1,2.136,2.191c0,.1,0,.192,0,.3v.019h3.769a2.141,2.141,0,0,1,2.235,2.235v22.425a2.146,2.146,0,0,1-2.269,2.262Zm-4.279-.308h2.14q2.764,0,5.528,0a1.837,1.837,0,0,0,1.962-1.955v-22.425a1.827,1.827,0,0,0-1.929-1.928h-4.076v-.327c0-.106,0-.2,0-.3a1.826,1.826,0,0,0-1.832-1.887c-1.693-.019-3.521-.02-5.589,0a1.8,1.8,0,0,0-1.82,1.613,2.8,2.8,0,0,0-.009.47c0,.087.006.177.006.273v.154h-.512c-.352,0-.7,0-1.057.007-.789.007-1.6.016-2.408-.017a1.939,1.939,0,0,0-1.445.528,2.072,2.072,0,0,0-.614,1.521c.02,5.36.018,10.809.016,16.078q0,3.1,0,6.2a2.492,2.492,0,0,0,.037.512,1.845,1.845,0,0,0,1.919,1.478q3.567,0,7.136,0Zm7.561-1.057h-17.15c-.721,0-1-.278-1-.994v-22.193a1.035,1.035,0,0,1,.224-.783,1.052,1.052,0,0,1,.786-.221h3.906l.011.141c.009.108.014.212.019.314a4.49,4.49,0,0,0,.056.589,1.777,1.777,0,0,0,1.722,1.455c2.1.014,3.961.014,5.7,0a1.813,1.813,0,0,0,1.783-1.789c0-.114,0-.228,0-.35v-.336l.244-.015c.069-.005.134-.01.2-.01q1.759,0,3.517,0c.736,0,1,.26,1,.992v22.164C955.5,2292.548,955.247,2292.808,954.485,2292.808Zm-17.14-23.885a.818.818,0,0,0-.57.133.8.8,0,0,0-.134.565v22.193c0,.552.136.688.694.688h17.15c.593,0,.712-.123.713-.728V2269.61c0-.563-.123-.685-.69-.685q-1.758,0-3.516,0c-.044,0-.088,0-.135.006v.044c0,.126,0,.244,0,.362a2.119,2.119,0,0,1-2.088,2.087c-1.745.014-3.612.013-5.709,0a2.085,2.085,0,0,1-2.022-1.705,4.662,4.662,0,0,1-.061-.63c0-.053-.006-.109-.009-.164h-3.621Zm9,1.151q-1.56,0-3.119,0a.783.783,0,0,1-.871-.855q-.007-1.139,0-2.278a.776.776,0,0,1,.856-.841c.642,0,1.283,0,1.925,0h3.435c.623,0,.914.287.915.9q0,1.1,0,2.191a.789.789,0,0,1-.872.887Zm-1.993-3.672h-1.14c-.373,0-.548.172-.55.535q-.007,1.138,0,2.274c0,.385.171.549.565.55q2.694.006,5.387,0c.4,0,.563-.169.565-.581q0-1.094,0-2.188c0-.437-.16-.592-.608-.593H944.35Z" transform="translate(-934.962 -2264.723)" fill="#4f4f51" />
                                                                </g>
                                                            </g>
                                                            <path id="Caminho_2459" data-name="Caminho 2459" d="M953.26,2304.571a.866.866,0,0,1-.526-.178l-4.04-3.088a.867.867,0,1,1,1.053-1.378l3.244,2.48,6.347-11.375a.867.867,0,1,1,1.514.845l-6.835,12.249a.867.867,0,0,1-.757.444Z" transform="translate(-943.708 -2281.617)" fill="#4f4f51" />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-tab" id="pills-arquivados-tab" data-toggle="pill" href="#pills-arquivados" role="tab" aria-controls="pills-arquivados" aria-selected="false">
                                                <div class="svg-iten-nav">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21.896" height="29.446" viewBox="0 0 21.896 29.446">
                                                        <g id="Grupo_1036" data-name="Grupo 1036" transform="translate(-1051.03 -2256.671)">
                                                            <g id="Grupo_1035" data-name="Grupo 1035" transform="translate(1051.03 2256.671)">
                                                                <g id="Grupo_1034" data-name="Grupo 1034">
                                                                    <g id="Grupo_1033" data-name="Grupo 1033">
                                                                        <path id="Caminho_2481" data-name="Caminho 2481" d="M1057.506,2259.637a6.017,6.017,0,0,1,0-.764,1.962,1.962,0,0,1,1.971-1.746c1.864-.017,3.728-.021,5.591,0a1.977,1.977,0,0,1,1.984,2.039c0,.143,0,.286,0,.47h.319q1.8,0,3.6,0a1.981,1.981,0,0,1,2.082,2.081q0,11.211,0,22.422a1.992,1.992,0,0,1-2.116,2.109q-3.833,0-7.666,0-4.842,0-9.683,0a1.989,1.989,0,0,1-2.069-1.6,2.657,2.657,0,0,1-.04-.544c0-7.426.013-14.852-.015-22.278a2.109,2.109,0,0,1,2.218-2.2c1.151.047,2.305.01,3.458.01Zm-.041,1.369H1053.7c-.668,0-.859.189-.859.851q0,11.1,0,22.19c0,.634.206.841.848.841h17.147c.675,0,.866-.195.866-.881q0-3.228,0-6.456,0-7.853,0-15.706c0-.648-.192-.838-.844-.839q-1.758,0-3.516,0c-.091,0-.183.01-.289.016,0,.2,0,.373,0,.544a1.975,1.975,0,0,1-1.935,1.938q-2.853.022-5.706,0a1.94,1.94,0,0,1-1.872-1.581A8.813,8.813,0,0,1,1057.465,2261.007Zm4.808-2.521c-.9,0-1.805,0-2.708,0a.627.627,0,0,0-.7.688q-.007,1.138,0,2.276a.631.631,0,0,0,.718.7q2.693.005,5.387,0a.639.639,0,0,0,.719-.734q0-1.095,0-2.189c0-.525-.228-.745-.762-.746Q1063.6,2258.484,1062.274,2258.486Z" transform="translate(-1051.319 -2256.96)" fill="#4f4f51" />
                                                                        <path id="Caminho_2482" data-name="Caminho 2482" d="M1067.268,2286.117h-6.826q-3.567,0-7.135,0a2.138,2.138,0,0,1-2.219-1.721,2.74,2.74,0,0,1-.043-.576q0-3.1,0-6.2c0-5.269,0-10.717-.016-16.075a2.374,2.374,0,0,1,.707-1.743,2.256,2.256,0,0,1,1.67-.613c.795.033,1.607.024,2.392.017.353,0,.707-.007,1.06-.007h.2c0-.037,0-.073,0-.109a3.037,3.037,0,0,1,.012-.522,2.124,2.124,0,0,1,2.121-1.879c2.069-.019,3.9-.019,5.594,0a2.123,2.123,0,0,1,2.136,2.192c0,.1,0,.191,0,.3v.019h3.768a2.141,2.141,0,0,1,2.235,2.235v22.422a2.146,2.146,0,0,1-2.269,2.262Zm-4.278-.308h2.14q2.764,0,5.527,0a1.837,1.837,0,0,0,1.962-1.955v-22.422a1.827,1.827,0,0,0-1.928-1.928q-1.253,0-2.506,0h-1.569v-.326c0-.106,0-.2,0-.3a1.826,1.826,0,0,0-1.832-1.888c-1.693-.019-3.521-.019-5.588,0a1.8,1.8,0,0,0-1.82,1.613,2.825,2.825,0,0,0-.009.471c0,.087.006.177.006.272v.153h-.512c-.352,0-.7,0-1.057.007-.789.008-1.6.016-2.407-.017a1.937,1.937,0,0,0-1.444.528,2.071,2.071,0,0,0-.614,1.52c.02,5.359.018,10.807.016,16.076q0,3.1,0,6.2a2.5,2.5,0,0,0,.037.512,1.844,1.844,0,0,0,1.919,1.477q3.567,0,7.135,0Zm7.56-1.056H1053.4c-.721,0-1-.279-1-.994v-22.191a1.034,1.034,0,0,1,.224-.783,1.051,1.051,0,0,1,.786-.222h3.906l.011.141c.009.108.014.212.019.314a4.442,4.442,0,0,0,.056.588,1.777,1.777,0,0,0,1.721,1.455c2.095.013,3.961.013,5.7,0a1.813,1.813,0,0,0,1.783-1.789c0-.114,0-.228,0-.35v-.335l.244-.015c.069-.005.134-.01.2-.01q1.758,0,3.516,0c.736,0,1,.26,1,.992v22.162C1071.57,2284.492,1071.313,2284.753,1070.55,2284.753Zm-17.138-23.882a.817.817,0,0,0-.57.133.8.8,0,0,0-.134.565v22.191c0,.552.136.687.694.687h17.147c.593,0,.713-.123.713-.728v-22.162c0-.562-.123-.684-.69-.685h-3.516c-.044,0-.088,0-.135.006v.045c0,.126,0,.244,0,.361a2.118,2.118,0,0,1-2.088,2.087c-1.745.014-3.612.013-5.708,0a2.085,2.085,0,0,1-2.022-1.705,4.628,4.628,0,0,1-.061-.63c0-.054-.006-.109-.009-.164h-3.62Zm9,1.15q-1.56,0-3.119,0a.783.783,0,0,1-.871-.855q-.007-1.139,0-2.278a.777.777,0,0,1,.856-.841q.963,0,1.925,0h3.434c.623,0,.913.287.915.9q0,1.095,0,2.19a.789.789,0,0,1-.872.887Zm-1.993-3.671h-1.14c-.373,0-.548.172-.55.536q-.007,1.137,0,2.274c0,.385.171.549.565.55q2.693.006,5.387,0c.4,0,.563-.169.565-.58q0-1.095,0-2.188c0-.437-.161-.592-.609-.593h-4.218Z" transform="translate(-1051.03 -2256.671)" fill="#4f4f51" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <path id="Caminho_2483" data-name="Caminho 2483" d="M1073.725,2293.336V2285h-3.291v8.336h-3.939l5.585,5.585,5.585-5.585Z" transform="translate(-10.101 -18.504)" fill="#4f4f51" />
                                                        </g>
                                                    </svg>


                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="pills-abertos" role="tabpanel" aria-labelledby="pills-abertos-tab">
                                            <h5 style="padding-top: 20px !important;" class="text-dark-gray" id="titulo-tab-small">Casos Abertos</h5>
                                            <p style="color: silver;">Aqui você encontrará todos os seus casos que estão em andamento</p>
                                            <div class="content-panel">
                                                <table id="tableAberto" class="table table-striped table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº Pedido</th>
                                                            <th>Dr(a)</th>
                                                            <th>Paciente</th>
                                                            <th>Especificação</th>
                                                            <th>Fluxo</th>
                                                            <th>Dias no Status</th>
                                                            <th>Data Criação</th>
                                                            <th>Ação</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--inicio linha de cartões-->
                                                        <div class="row py-2">

                                                            <?php
                                                            //chamar do banco de dados todos os casos
                                                            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedAndamento='ABERTO'");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                $userCriador = $row['pedUserCriador'];
                                                                $propID = $row['pedPropRef'];
                                                                $pedID = $row['pedNumPedido'];
                                                                $tipoProd = $row['pedTipoProduto'];

                                                                $nomeFluxo = getNomeFluxoPed($conn, $pedID);
                                                                $corFluxo = getCorFluxoPed($conn, $pedID);
                                                                $contagemDias = getAndamentoForTableFluxoPed($conn, $pedID);
                                                                $cpfcnpj = $row['pedCpfCnpj'];

                                                                $numFluxo = $row['pedPosicaoFluxo'];
                                                                $numFluxo = intval($numFluxo);
                                                                $numFluxo = $numFluxo * 20;

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
                                                                if ($_SESSION["userperm"] == 'Distribuidor(a)') {
                                                                    if (($userSessionIdentifier == $cpfcnpj)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                            ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php //if ($_SESSION["userperm"] == "Doutor(a)") { 
                                                                                ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                //}
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else if ($_SESSION["userperm"] == 'Dist. Comercial') {
                                                                    if (($userSessionIdentifier == $cpfcnpj)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php //if ($_SESSION["userperm"] == "Doutor(a)") { 
                                                                                ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                //}
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else if ($_SESSION["userperm"] == 'Doutor(a)') {
                                                                    if (($_SESSION["useruid"] == $userCriador)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php if ($_SESSION["userperm"] == "Doutor(a)") { ?>
                                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                        <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else {

                                                                    // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                    // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                    // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                    // $encrypted = urlencode($encrypted);

                                                                    $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                    <tr>
                                                                        <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                        <td><?php echo $row['pedNumPedido']; ?></td>
                                                                        <td><?php echo $row['pedNomeDr']; ?></td>
                                                                        <td><?php echo $row['pedNomePac']; ?></td>
                                                                        <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                        <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                        <td><?php echo $contagemDias; ?></td>
                                                                        <td><?php echo $data; ?></td>
                                                                        <td class="d-flex">
                                                                            <?php if ($_SESSION["userperm"] == "Doutor(a)") { ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>

                                                                    </tr>
                                                            <?php

                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade show active" id="pills-pendentes" role="tabpanel" aria-labelledby="pills-pendentes-tab">
                                            <h5 style="padding-top: 20px !important;" class="text-dark-gray" id="titulo-tab-small">Casos Pendentes</h5>
                                            <p style="color: silver;">Estes casos estão pendentes. Seja por falta de documentos, falta de TC ou falta de dados. Certifique-se de todas as especificações e dê continuidade ao projeto.</p>

                                            <div class="content-panel">
                                                <table id="tablePendente" class="table table-striped table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº Pedido</th>
                                                            <th>Dr(a)</th>
                                                            <th>Paciente</th>
                                                            <th>Especificação</th>
                                                            <th>Fluxo</th>
                                                            <th>Dias no Status</th>
                                                            <th>Data Criação</th>
                                                            <th>Ação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--inicio linha de cartões-->
                                                        <div class="row py-2">

                                                            <?php
                                                            //chamar do banco de dados todos os casos
                                                            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedAndamento='PENDENTE'");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                $userCriador = $row['pedUserCriador'];
                                                                $propID = $row['pedPropRef'];
                                                                $pedID = $row['pedNumPedido'];
                                                                $tipoProd = $row['pedTipoProduto'];

                                                                $nomeFluxo = getNomeFluxoPed($conn, $pedID);
                                                                $corFluxo = getCorFluxoPed($conn, $pedID);
                                                                $contagemDias = getAndamentoForTableFluxoPed($conn, $pedID);
                                                                $cpfcnpj = $row['pedCpfCnpj'];

                                                                $numFluxo = $row['pedPosicaoFluxo'];
                                                                $numFluxo = intval($numFluxo);
                                                                $numFluxo = $numFluxo * 20;

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
                                                                if ($_SESSION["userperm"] == 'Distribuidor(a)') {
                                                                    if (($userSessionIdentifier == $cpfcnpj)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                            ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php //if ($_SESSION["userperm"] == "Doutor(a)") { 
                                                                                ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                //}
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else if ($_SESSION["userperm"] == 'Dist. Comercial') {
                                                                    if (($userSessionIdentifier == $cpfcnpj)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php //if ($_SESSION["userperm"] == "Doutor(a)") { 
                                                                                ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                //}
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else if ($_SESSION["userperm"] == 'Doutor(a)') {
                                                                    if (($_SESSION["useruid"] == $userCriador)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php //if ($_SESSION["userperm"] == "Doutor(a)") { 
                                                                                ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                //}
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else {

                                                                    // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                    // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                    // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                    // $encrypted = urlencode($encrypted);

                                                                    $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                    <tr>
                                                                        <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                        <td><?php echo $row['pedNumPedido']; ?></td>
                                                                        <td><?php echo $row['pedNomeDr']; ?></td>
                                                                        <td><?php echo $row['pedNomePac']; ?></td>
                                                                        <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                        <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                        <td><?php echo $contagemDias; ?></td>
                                                                        <td><?php echo $data; ?></td>
                                                                        <td class="d-flex">
                                                                            <?php //if ($_SESSION["userperm"] == "Doutor(a)") { 
                                                                            ?>
                                                                            <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                            <?php
                                                                            //}
                                                                            ?>
                                                                        </td>

                                                                    </tr>
                                                            <?php

                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="pills-finalizados" role="tabpanel" aria-labelledby="pills-finalizados-tab">
                                            <h5 class="text-dark-gray row-3" id="titulo-tab-small">Casos Finalizados</h5>
                                            <p style="color: silver;">Estes casos já foram finalizados.</p>
                                            <div class="content-panel">
                                                <table id="tableFinalizado" class="table table-striped table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº Pedido</th>
                                                            <th>Dr(a)</th>
                                                            <th>Paciente</th>
                                                            <th>Especificação</th>
                                                            <th>Fluxo</th>
                                                            <th>Dias no Status</th>
                                                            <th>Data Criação</th>
                                                            <th>Ação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--inicio linha de cartões-->
                                                        <div class="row py-2">

                                                            <?php
                                                            //chamar do banco de dados todos os casos
                                                            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedAndamento='FINALIZADO'");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                $userCriador = $row['pedUserCriador'];
                                                                $propID = $row['pedPropRef'];
                                                                $pedID = $row['pedNumPedido'];
                                                                $tipoProd = $row['pedTipoProduto'];

                                                                $nomeFluxo = getNomeFluxoPed($conn, $pedID);
                                                                $corFluxo = getCorFluxoPed($conn, $pedID);
                                                                $contagemDias = getAndamentoForTableFluxoPed($conn, $pedID);
                                                                $cpfcnpj = $row['pedCpfCnpj'];

                                                                $numFluxo = $row['pedPosicaoFluxo'];
                                                                $numFluxo = intval($numFluxo);
                                                                $numFluxo = $numFluxo * 20;

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
                                                                if ($_SESSION["userperm"] == 'Distribuidor(a)') {
                                                                    if (($userSessionIdentifier == $cpfcnpj)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                            ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php //if ($_SESSION["userperm"] == "Doutor(a)") { 
                                                                                ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                //}
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else if ($_SESSION["userperm"] == 'Dist. Comercial') {
                                                                    if (($userSessionIdentifier == $cpfcnpj)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php if ($_SESSION["userperm"] == "Doutor(a)") { ?>
                                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                        <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else if ($_SESSION["userperm"] == 'Doutor(a)') {
                                                                    if (($_SESSION["useruid"] == $userCriador)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php if ($_SESSION["userperm"] == "Doutor(a)") { ?>
                                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                        <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else {

                                                                    // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                    // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                    // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                    // $encrypted = urlencode($encrypted);

                                                                    $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                    <tr>
                                                                        <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                        <td><?php echo $row['pedNumPedido']; ?></td>
                                                                        <td><?php echo $row['pedNomeDr']; ?></td>
                                                                        <td><?php echo $row['pedNomePac']; ?></td>
                                                                        <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                        <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                        <td><?php echo $contagemDias; ?></td>
                                                                        <td><?php echo $data; ?></td>
                                                                        <td class="d-flex">
                                                                            <?php if ($_SESSION["userperm"] == "Doutor(a)") { ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>

                                                                    </tr>
                                                            <?php

                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="pills-arquivados" role="tabpanel" aria-labelledby="pills-arquivados-tab">
                                            <h5 class="text-dark-gray row-3" id="titulo-tab-small">Casos Arquivados</h5>
                                            <p style="color: silver;">Estes casos foram arquivados. Caso deseje recuperá-los entre em contato com nossa equipe.</p>

                                            <div class="content-panel">
                                                <table id="tableArquivado" class="table table-striped table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº Pedido</th>
                                                            <th>Dr(a)</th>
                                                            <th>Paciente</th>
                                                            <th>Especificação</th>
                                                            <th>Fluxo</th>
                                                            <th>Dias no Status</th>
                                                            <th>Data Criação</th>
                                                            <th>Ação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--inicio linha de cartões-->
                                                        <div class="row py-2">

                                                            <?php
                                                            //chamar do banco de dados todos os casos
                                                            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedAndamento='ARQUIVADO'");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                $userCriador = $row['pedUserCriador'];
                                                                $propID = $row['pedPropRef'];
                                                                $pedID = $row['pedNumPedido'];
                                                                $tipoProd = $row['pedTipoProduto'];

                                                                $nomeFluxo = getNomeFluxoPed($conn, $pedID);
                                                                $corFluxo = getCorFluxoPed($conn, $pedID);
                                                                $contagemDias = getAndamentoForTableFluxoPed($conn, $pedID);
                                                                $cpfcnpj = $row['pedCpfCnpj'];

                                                                $numFluxo = $row['pedPosicaoFluxo'];
                                                                $numFluxo = intval($numFluxo);
                                                                $numFluxo = $numFluxo * 20;

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
                                                                if ($_SESSION["userperm"] == 'Distribuidor(a)') {
                                                                    if (($userSessionIdentifier == $cpfcnpj)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                            ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php //if ($_SESSION["userperm"] == "Doutor(a)") { 
                                                                                ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                //}
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else if ($_SESSION["userperm"] == 'Dist. Comercial') {
                                                                    if (($userSessionIdentifier == $cpfcnpj)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php if ($_SESSION["userperm"] == "Doutor(a)") { ?>
                                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                        <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else if ($_SESSION["userperm"] == 'Doutor(a)') {
                                                                    if (($_SESSION["useruid"] == $userCriador)) {
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                        <tr>
                                                                            <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                            <td><?php echo $row['pedNumPedido']; ?></td>
                                                                            <td><?php echo $row['pedNomeDr']; ?></td>
                                                                            <td><?php echo $row['pedNomePac']; ?></td>
                                                                            <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                            <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                            <td><?php echo $contagemDias; ?></td>
                                                                            <td><?php echo $data; ?></td>
                                                                            <td class="d-flex">
                                                                                <?php if ($_SESSION["userperm"] == "Doutor(a)") { ?>
                                                                                    <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                        <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else {

                                                                    // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                    // $encrypted = openssl_encrypt($row['pedNumPedido'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                    // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                    // $encrypted = urlencode($encrypted);

                                                                    $encrypted = hashItemNatural($row['pedNumPedido']);
                                                                    ?>
                                                                    <tr>
                                                                        <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                        <td><?php echo $row['pedNumPedido']; ?></td>
                                                                        <td><?php echo $row['pedNomeDr']; ?></td>
                                                                        <td><?php echo $row['pedNomePac']; ?></td>
                                                                        <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                        <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                        <td><?php echo $contagemDias; ?></td>
                                                                        <td><?php echo $data; ?></td>
                                                                        <td class="d-flex">
                                                                            <?php if ($_SESSION["userperm"] == "Doutor(a)") { ?>
                                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                                    <button class="btn btn-conecta"><i class="fas fa-arrow-right"></i></button></a>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>

                                                                    </tr>
                                                            <?php

                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
                                    triggerTabList.forEach(function(triggerEl) {
                                        var tabTrigger = new bootstrap.Tab(triggerEl)

                                        triggerEl.addEventListener('click', function(event) {
                                            event.preventDefault()
                                            tabTrigger.show()
                                        })
                                    })
                                </script>
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
        $('#tableAberto').DataTable({
            "lengthMenu": [
                [20, 40, 80, -1],
                [20, 40, 80, "Todos"],
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
                [1, "desc"]
            ]
        });
        $('#tablePendente').DataTable({
            "lengthMenu": [
                [20, 40, 80, -1],
                [20, 40, 80, "Todos"],
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
                [1, "desc"]
            ]
        });
        $('#tableFinalizado').DataTable({
            "lengthMenu": [
                [20, 40, 80, -1],
                [20, 40, 80, "Todos"],
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
                [1, "desc"]
            ]
        });
        $('#tableArquivado').DataTable({
            "lengthMenu": [
                [20, 40, 80, -1],
                [20, 40, 80, "Todos"],
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
                [1, "desc"]
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