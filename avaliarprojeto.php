<?php

session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador')) || ($_SESSION["userperm"] == 'Qualidade') || ($_SESSION["userperm"] == 'Planejador(a)')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
?>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <style>
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

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">

                        <div class="d-flex justify-content-start align-items-center">
                            <button class='button-back mx-3 px-3' style='color:#ee7624;' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                            <h2 class="text-conecta" style="font-weight: 400; text-align: left;">Casos para <span style="font-weight: 700;">Aprovar</span></h2>
                        </div>

                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow" style="overflow: scroll;">
                            <div class="card-body">

                                <!--Tabs for large devices-->
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active text-tab" id="pills-pendentes-tab" data-toggle="pill" href="#pills-pendentes" role="tab" aria-controls="pills-pendentes" aria-selected="true"><i class="fa-solid fa-box-open pr-2"></i> Aprovar</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-tab" id="pills-abertos-tab" data-toggle="pill" href="#pills-abertos" role="tab" aria-controls="pills-abertos" aria-selected="true"><i class="fa-solid fa-check-double pr-2"></i> Avaliados</a>
                                    </li>
                                </ul>

                                <!--Tabs for smaller devices-->
                                <ul class="nav nav-pills mb-3" id="pills-tab-small" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active text-tab" id="pills-pendentes-tab" data-toggle="pill" href="#pills-pendentes" role="tab" aria-controls="pills-pendentes" aria-selected="true">
                                            <div class="text-center">
                                                <i class="fa-solid fa-box-open pr-2"></i> <span class="text-small">Aprovar</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-tab" id="pills-abertos-tab" data-toggle="pill" href="#pills-abertos" role="tab" aria-controls="pills-abertos" aria-selected="true">
                                            <div class="text-center">
                                                <i class="fa-solid fa-check-double pr-2"></i> <span class="text-small">Avaliado</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-pendentes" role="tabpanel" aria-labelledby="pills-pendentes-tab">
                                        <p style="color: silver;">Aqui você encontrará todos os casos que precisam de avaliação</p>
                                        <div class="content-panel">
                                            <table id="tableAberto" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Nº Pedido</th>
                                                        <th></th>
                                                        <th>UID</th>
                                                        <th>Dr(a)</th>
                                                        <th>Paciente</th>
                                                        <th>Especificação</th>
                                                        <th>Fluxo</th>
                                                        <th>Dias no Status</th>
                                                        <th>Dias Totais</th>
                                                        <th>Técnico</th>
                                                        <th>Data Criação</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!--inicio linha de cartões-->
                                                    <div class="row py-2">

                                                        <?php
                                                        //chamar do banco de dados todos os casos
                                                        $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedStatus='Avaliar Projeto'");
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            $propID = $row['pedPropRef'];
                                                            $pedID = $row['pedNumPedido'];
                                                            $tipoProd = $row['pedTipoProduto'];

                                                            $nomeFluxo = getNomeFluxoPed($conn, $pedID);
                                                            $corFluxo = getCorFluxoPed($conn, $pedID);
                                                            $contagemDias = getAndamentoForTableFluxoPed($conn, $pedID);
                                                            $contagemDiasTotais = getDiasTotaisdoPedido($conn, $pedID);
                                                            $TecnicoIniciais = getIniciasTecnicodoPedido($conn, $pedID);


                                                            $numFluxo = $row['pedPosicaoFluxo'];
                                                            $numFluxo = intval($numFluxo);
                                                            $numFluxo = $numFluxo * 20;

                                                            $andamento = $row['pedStatus'];

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
                                                                <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                <td><?php echo $row['pedNumPedido']; ?></td>
                                                                <td class="d-flex">
                                                                    <a href="avaliar-caso?id=<?php echo $row['pedId']; ?>">
                                                                        <button class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square"></i></button></a>
                                                                </td>
                                                                <td><?php echo $row['pedUserCriador']; ?></td>
                                                                <td><?php echo $row['pedNomeDr']; ?></td>
                                                                <td><?php echo $row['pedNomePac']; ?></td>
                                                                <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                <td><?php echo $contagemDias; ?></td>
                                                                <td><?php echo $contagemDiasTotais; ?></td>
                                                                <td><?php echo $TecnicoIniciais; ?></td>
                                                                <td><?php echo $data; ?></td>

                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-abertos" role="tabpanel" aria-labelledby="pills-abertos-tab">
                                        <p style="color: silver;">Aqui você encontrará todos os casos já passaram pela avaliação</p>
                                        <div class="content-panel">
                                            <table id="tableAvaliado" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>

                                                        <th>Nº Pedido</th>
                                                        <th></th>
                                                        <th>UID</th>
                                                        <th>Dr(a)</th>
                                                        <th>Paciente</th>
                                                        <th>Especificação</th>
                                                        <th>Fluxo</th>
                                                        <th>Dias no Status</th>
                                                        <th>Dias Totais</th>
                                                        <th>Técnico</th>
                                                        <th>Data Criação</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!--inicio linha de cartões-->
                                                    <div class="row py-2">

                                                        <?php
                                                        $arrayLista = [];
                                                        $ret = mysqli_query($conn, "SELECT DISTINCT `avNumPed` FROM `avaliacaopedido`;");
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            array_push($arrayLista, $row['avNumPed']);
                                                        }

                                                        // print_r($arrayLista);

                                                        foreach ($arrayLista as $numPed) {
                                                            // Código a ser executado para cada elemento



                                                            //chamar do banco de dados todos os casos
                                                            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='" . $numPed . "'");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                $propID = $row['pedPropRef'];
                                                                $pedID = $row['pedNumPedido'];
                                                                $tipoProd = $row['pedTipoProduto'];

                                                                $nomeFluxo = getNomeFluxoPed($conn, $pedID);
                                                                $corFluxo = getCorFluxoPed($conn, $pedID);
                                                                $contagemDias = getAndamentoForTableFluxoPed($conn, $pedID);
                                                                $contagemDiasTotais = getDiasTotaisdoPedido($conn, $pedID);
                                                                $TecnicoIniciais = getIniciasTecnicodoPedido($conn, $pedID);


                                                                $numFluxo = $row['pedPosicaoFluxo'];
                                                                $numFluxo = intval($numFluxo);
                                                                $numFluxo = $numFluxo * 20;

                                                                $andamento = $row['pedStatus'];

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
                                                                    <!--<td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>-->
                                                                    <td><?php echo $row['pedNumPedido']; ?></td>
                                                                    <td class="d-flex">
                                                                        <a href="avaliar-caso?id=<?php echo $row['pedId']; ?>">
                                                                            <button class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square"></i></button></a>
                                                                    </td>
                                                                    <td><?php echo $row['pedUserCriador']; ?></td>
                                                                    <td><?php echo $row['pedNomeDr']; ?></td>
                                                                    <td><?php echo $row['pedNomePac']; ?></td>
                                                                    <td><?php echo $row['pedTipoProduto']; ?></td>
                                                                    <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                    <td><?php echo $contagemDias; ?></td>
                                                                    <td><?php echo $contagemDiasTotais; ?></td>
                                                                    <td><?php echo $TecnicoIniciais; ?></td>
                                                                    <td><?php echo $data; ?></td>

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
                        [7, "desc"]
                    ]
                });
                $('#tableAvaliado').DataTable({
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
                        [7, "desc"]
                    ]
                });
            });
        </script>

    <?php
    include_once 'php/footer_index.php';
} else {
    header("Location: login");
    exit();
}

    ?>