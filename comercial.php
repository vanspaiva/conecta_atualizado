<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Comercial')) || ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_tables.php");
    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.inc.php';

    $user = $_SESSION['useruid'];
    $permBuscada = 'EXPROP';


    $temPermissao = pesquisarPermissoesExtras($conn, $user, $permBuscada);

    $ret1 = mysqli_query($conn, "SELECT COUNT(*) as 'qtd' FROM propostas WHERE propStatus = 'PENDENTE';");
    while ($row1 = mysqli_fetch_array($ret1)) {
        $qtdAnalisar = $row1['qtd'];
    }

    $ret2 = mysqli_query($conn, "SELECT COUNT(*) as 'qtd' FROM propostas WHERE propStatus = 'PROP. ENVIADA';");
    while ($row2 = mysqli_fetch_array($ret2)) {
        $qtdPropostaEnviada = $row2['qtd'];
    }

    $ret3 = mysqli_query($conn, "SELECT COUNT(*) as 'qtd' FROM propostas WHERE propStatus = 'PRÉ PEDIDO';");
    while ($row3 = mysqli_fetch_array($ret3)) {
        $qtdPrePedido = $row3['qtd'];
    }

    $ret4 = mysqli_query($conn, "SELECT COUNT(*) as 'qtd' FROM propostas WHERE propStatus = 'APROVADO';");
    while ($row4 = mysqli_fetch_array($ret4)) {
        $qtdAprovado = $row4['qtd'];
    }

?>
    <style>
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

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Proposta editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Proposta foi deletada!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Proposta editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Proposta foi enviada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "senteerror") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>ERRO ao enviar Proposta!</p></div>";
                    } else if ($_GET["error"] == "saveerror") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>ERRO ao salvar Proposta!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row pt-4">
                    <div class="col-sm justify-content-center">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start">
                                <h2 class="text-conecta" style="font-weight: 400;">Proposta <span style="font-weight: 700;">Solicitações</span></h2>
                            </div>
                            <div class="col-sm d-none d-sm-block">
                                <div class="d-flex justify-content-end p-1">
                                    <a href="exportProp"><button class="btn btn-outline-conecta"><i class="far fa-file-excel"></i> Exportar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border-color: #ee7624;" class="pb-4">

                <div class="row">
                    <div class="col">
                        <!--Casos Abertos, Casos Pendentes, Casos Finalizados e Casos Arquivados-->
                        <!--Tabs for large devices-->
                        <div class="d-flex justify-content-center">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item px-3" role="presentation">
                                    <a class="nav-link active text-tab" id="pills-analisar-tab" data-toggle="pill" href="#pills-analisar" role="tab" aria-controls="pills-analisar" aria-selected="true">Analisar <span class="badge badge-light"><?php echo $qtdAnalisar; ?></span></a>
                                </li>
                                <li class="nav-item px-3" role="presentation">
                                    <a class="nav-link text-tab" id="pills-propostas-tab" data-toggle="pill" href="#pills-propostas" role="tab" aria-controls="pills-propostas" aria-selected="true">Todas</a>
                                </li>
                                <li class="nav-item px-3" role="presentation">
                                    <a class="nav-link text-tab" id="pills-pendente-tab" data-toggle="pill" href="#pills-pendente" role="tab" aria-controls="pills-pendente" aria-selected="true">Pendente</a>
                                </li>
                                <li class="nav-item px-3" role="presentation">
                                    <a class="nav-link text-tab" id="pills-enviadas-tab" data-toggle="pill" href="#pills-enviadas" role="tab" aria-controls="pills-enviadas" aria-selected="true">Enviadas <span class="badge badge-light"><?php echo $qtdPropostaEnviada; ?></span></a>
                                </li>
                                <li class="nav-item px-3" role="presentation">
                                    <a class="nav-link text-tab" id="pills-prepedido-tab" data-toggle="pill" href="#pills-prepedido" role="tab" aria-controls="pills-prepedido" aria-selected="false">Pré Pedido <span class="badge badge-light"><?php echo $qtdPrePedido; ?></span></a>
                                </li>
                                <li class="nav-item px-3" role="presentation">
                                    <a class="nav-link text-tab" id="pills-aprovadas-tab" data-toggle="pill" href="#pills-aprovadas" role="tab" aria-controls="pills-aprovadas" aria-selected="false">Aprovadas <span class="badge badge-light"><?php echo $qtdAprovado; ?></span></a>
                                </li>
                                <li class="nav-item px-3" role="presentation">
                                    <a class="nav-link text-tab" id="pills-pedidos-tab" data-toggle="pill" href="#pills-pedidos" role="tab" aria-controls="pills-pedidos" aria-selected="false">Pedidos</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Tabs for smaller devices -->
                        <div class="d-flex justify-content-center">
                            <ul class="nav nav-pills mb-3 " id="pills-tab-small" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex justify-content-center active text-tab" id="pills-analisar-tab" data-toggle="pill" href="#pills-analisar" role="tab" aria-controls="pills-analisar" aria-selected="true"><i class="fas fa-clock fa-2x"></i></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex justify-content-center text-tab" id="pills-propostas-tab" data-toggle="pill" href="#pills-propostas" role="tab" aria-controls="pills-propostas" aria-selected="true"><i class="fas fa-file-invoice-dollar fa-2x"></i></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex justify-content-center text-tab" id="pills-pendente-tab" data-toggle="pill" href="#pills-pendente" role="tab" aria-controls="pills-pendente" aria-selected="true"><i class="fas fa-flag"></i></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex justify-content-center text-tab" id="pills-enviadas-tab" data-toggle="pill" href="#pills-enviadas" role="tab" aria-controls="pills-enviadas" aria-selected="true"><i class="fas fa-file-import fa-2x"></i></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex justify-content-center text-tab" id="pills-prepedido-tab" data-toggle="pill" href="#pills-prepedido" role="tab" aria-controls="pills-prepedido" aria-selected="false"><i class="fas fa-clipboard fa-2x"></i></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex justify-content-center text-tab" id="pills-aprovadas-tab" data-toggle="pill" href="#pills-aprovadas" role="tab" aria-controls="pills-aprovadas" aria-selected="false"><i class="fas fa-clipboard-check fa-2x"></i></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex justify-content-center text-tab" id="pills-pedidos-tab" data-toggle="pill" href="#pills-pedidos" role="tab" aria-controls="pills-pedidos" aria-selected="false"><i class="fas fa-boxes fa-2x"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-analisar" role="tabpanel" aria-labelledby="pills-analisar-tab">
                                <h4 class="text-conecta py-2">Propostas para Analisar</h4>
                                <div class="content-panel" style="overflow: scroll;">
                                    <table id="tableProp2" class="table table-striped table-advance table-hover bg-white rounded">

                                        <thead class="text-conecta">
                                            <tr>
                                                <th>Nº</th>
                                                <th></th>
                                                <th>Data Chegada</th>
                                                <th>Status (CN)</th>
                                                <th>Status (Rep)</th>
                                                <th>Representante</th>
                                                <th>Empresa</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>E-mail</th>
                                                <th>Usuário Criador</th>
                                                <th>Produto</th>

                                            </tr>
                                        </thead>
                                        <tbody style="background-color: white;">
                                            <?php

                                            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%PENDENTE%'");
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

                                                $dataCompleta = $row['propDataCriacao'];
                                                $dataArray = explode(" ", $dataCompleta);
                                                $data = $dataArray[0];

                                                /*//Cores Status TC
                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                    $moodStatus = "bg-success";
                                                    $colorText = "";
                                                } else {

                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                        $moodStatus = "bg-danger";
                                                    } else {
                                                        $moodStatus = "bg-amarelo text-dark";
                                                    }
                                                }*/


                                                //Cores Status Comercial
                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                    $moodStatusComercial = "bg-amarelo";
                                                } else {

                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                        $moodStatusComercial = "bg-verde-claro";
                                                    } else {
                                                        if ($row['propStatus'] == 'APROVADO') {
                                                            $moodStatusComercial = "bg-verde text-white";
                                                        } else {
                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                $moodStatusComercial = "bg-roxo text-white";
                                                            } else {
                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                } else {
                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                        $moodStatusComercial = "bg-rosa";
                                                                    } else {
                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                        } else {
                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                            } else {
                                                                                $moodStatusComercial = "bg-amarelo";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($row['propEmpresa'] != null) {
                                                    $empresa = $row['propEmpresa'];
                                                    $classEmpresa = '';
                                                } else {
                                                    $empresa = '-';
                                                    $classEmpresa = 'class="text-center"';
                                                }


                                                // $idViewer = $row['propId'];
                                                // $existeAnalise = existeAnalise($conn, $idViewer);
                                                // if (!$existeAnalise) {
                                                //     $resultadoAnaliseRep = "Pendente";
                                                //     $moodStatus = "bg-amarelo text-dark";
                                                // } else {
                                                //     $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                //     if ($resultadoAnaliseRep == "Aprovado") {
                                                //         $moodStatus = "bg-success";
                                                //         $colorText = "";
                                                //     } else {
                                                //         $moodStatus = "bg-danger";
                                                //     }
                                                // }

                                                $envioTC = $row["propEnvioTC"];
                                                $envioRelatorio = $row["propEnvioRelatorio"];

                                                if (($envioTC == "true") || ($envioTC == null)) {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar TC";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                } else if ($envioRelatorio == "true") {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar Relatório";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                }

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['propId']; ?></td>
                                                    <td class="d-flex justify-content-around">
                                                        <a href="update-proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                        <?php if ($temFin) { ?>
                                                            <a href="comprovantepagamento?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-success"><i class="fas fa-file-invoice-dollar"></i></button></a>
                                                        <?php } ?>
                                                        <!-- <a href="createpdf?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a> -->
                                                        <?php if (($_SESSION["userperm"] == 'Administrador') || ($temPermissao)) { ?>
                                                            <a href="manageProp?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-danger" onClick="return confirm('Você realmente deseja deletar essa proposta?');"><i class="fas fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                    
                                                    <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                    <td><?php echo $representante; ?></td>
                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                    <td><?php echo $row['propTipoProd']; ?></td>


                                                </tr>
                                            <?php
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="pills-propostas" role="tabpanel" aria-labelledby="pills-propostas-tab">
                                <h4 class="text-conecta py-2">Propostas Em Andamento</h4>
                                <div class="content-panel" style="overflow: scroll;">
                                    <table id="tableProp" class="table table-striped table-advance table-hover bg-white">
                                        <thead class="text-conecta">
                                            <tr>
                                                <th>Nº</th>
                                                <th></th>
                                                <th>Data Chegada</th>
                                                <th>Status (CN)</th>
                                                <th>Status (Rep)</th>
                                                <th>Representante</th>
                                                <th>Empresa</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>E-mail</th>
                                                <th>Usuário Criador</th>
                                                <th>Produto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';

                                            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE NOT propStatus = 'PEDIDO'");
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

                                                $dataCompleta = $row['propDataCriacao'];
                                                $dataArray = explode(" ", $dataCompleta);
                                                $data = $dataArray[0];

                                                /*//Cores Status TC
                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                    $moodStatus = "bg-success";
                                                    $colorText = "";
                                                } else {

                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                        $moodStatus = "bg-danger";
                                                    } else {
                                                        $moodStatus = "bg-amarelo text-dark";
                                                    }
                                                }*/


                                                //Cores Status Comercial
                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                    $moodStatusComercial = "bg-amarelo";
                                                } else {

                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                        $moodStatusComercial = "bg-verde-claro";
                                                    } else {
                                                        if ($row['propStatus'] == 'APROVADO') {
                                                            $moodStatusComercial = "bg-verde text-white";
                                                        } else {
                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                $moodStatusComercial = "bg-roxo text-white";
                                                            } else {
                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                } else {
                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                        $moodStatusComercial = "bg-rosa";
                                                                    } else {
                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                        } else {
                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                            } else {
                                                                                $moodStatusComercial = "bg-amarelo";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($row['propEmpresa'] != null) {
                                                    $empresa = $row['propEmpresa'];
                                                    $classEmpresa = '';
                                                } else {
                                                    $empresa = '-';
                                                    $classEmpresa = 'class="text-center"';
                                                }

                                                // $idViewer = $row['propId'];
                                                // $existeAnalise = existeAnalise($conn, $idViewer);
                                                // if (!$existeAnalise) {
                                                //     $resultadoAnaliseRep = "Pendente";
                                                //     $moodStatus = "bg-amarelo text-dark";
                                                // } else {
                                                //     $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                //     if ($resultadoAnaliseRep == "Aprovado") {
                                                //         $moodStatus = "bg-success";
                                                //         $colorText = "";
                                                //     } else {
                                                //         $moodStatus = "bg-danger";
                                                //     }
                                                // }

                                                $envioTC = $row["propEnvioTC"];
                                                $envioRelatorio = $row["propEnvioRelatorio"];

                                                if (($envioTC == "true") || ($envioTC == null)) {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar TC";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                } else if ($envioRelatorio == "true") {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar Relatório";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                }

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['propId']; ?></td>
                                                    <td class="d-flex justify-content-around">
                                                        <a href="update-proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                        <?php if ($temFin) { ?>
                                                            <a href="comprovantepagamento?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-success"><i class="fas fa-file-invoice-dollar"></i></button></a>
                                                        <?php } ?>
                                                        <!-- <a href="createpdf?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a> -->
                                                        <?php if (($_SESSION["userperm"] == 'Administrador') || ($temPermissao)) { ?>
                                                            <a href="manageProp?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-danger" onClick="return confirm('Você realmente deseja deletar essa proposta?');"><i class="fas fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                    <td><?php echo $representante; ?></td>
                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                    <td><?php echo $row['propTipoProd']; ?></td>


                                                </tr>
                                            <?php
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-pendente" role="tabpanel" aria-labelledby="pills-pendente-tab">
                                <h4 class="text-conecta py-2">Propostas Pendentes</h4>
                                <div class="content-panel" style="overflow: scroll;">
                                    <table id="tablePropPend" class="table table-striped table-advance table-hover bg-white">
                                        <thead class="text-conecta">
                                            <tr>
                                                <th>Nº</th>
                                                <th></th>
                                                <th>Data Chegada</th>
                                                <th>Status (CN)</th>
                                                <th>Status (Rep)</th>
                                                <th>Representante</th>
                                                <th>Empresa</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>E-mail</th>
                                                <th>Usuário Criador</th>
                                                <th>Produto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';

                                            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus IN ('AGUARD. QUALIFICAÇÃO', 'CLIENTE QUALIFICADO');");
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

                                                $dataCompleta = $row['propDataCriacao'];
                                                $dataArray = explode(" ", $dataCompleta);
                                                $data = $dataArray[0];

                                                /*//Cores Status TC
                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                    $moodStatus = "bg-success";
                                                    $colorText = "";
                                                } else {

                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                        $moodStatus = "bg-danger";
                                                    } else {
                                                        $moodStatus = "bg-amarelo text-dark";
                                                    }
                                                }*/


                                                //Cores Status Comercial
                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                    $moodStatusComercial = "bg-amarelo";
                                                } else {

                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                        $moodStatusComercial = "bg-verde-claro";
                                                    } else {
                                                        if ($row['propStatus'] == 'APROVADO') {
                                                            $moodStatusComercial = "bg-verde text-white";
                                                        } else {
                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                $moodStatusComercial = "bg-roxo text-white";
                                                            } else {
                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                } else {
                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                        $moodStatusComercial = "bg-rosa";
                                                                    } else {
                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                        } else {
                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                            } else {
                                                                                $moodStatusComercial = "bg-amarelo";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($row['propEmpresa'] != null) {
                                                    $empresa = $row['propEmpresa'];
                                                    $classEmpresa = '';
                                                } else {
                                                    $empresa = '-';
                                                    $classEmpresa = 'class="text-center"';
                                                }

                                                // $idViewer = $row['propId'];
                                                // $existeAnalise = existeAnalise($conn, $idViewer);
                                                // if (!$existeAnalise) {
                                                //     $resultadoAnaliseRep = "Pendente";
                                                //     $moodStatus = "bg-amarelo text-dark";
                                                // } else {
                                                //     $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                //     if ($resultadoAnaliseRep == "Aprovado") {
                                                //         $moodStatus = "bg-success";
                                                //         $colorText = "";
                                                //     } else {
                                                //         $moodStatus = "bg-danger";
                                                //     }
                                                // }

                                                $envioTC = $row["propEnvioTC"];
                                                $envioRelatorio = $row["propEnvioRelatorio"];

                                                if (($envioTC == "true") || ($envioTC == null)) {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar TC";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                } else if ($envioRelatorio == "true") {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar Relatório";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                }

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['propId']; ?></td>
                                                    <td class="d-flex justify-content-around">
                                                        <a href="update-proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                        <?php if ($temFin) { ?>
                                                            <a href="comprovantepagamento?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-success"><i class="fas fa-file-invoice-dollar"></i></button></a>
                                                        <?php } ?>
                                                        <!-- <a href="createpdf?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a> -->
                                                        <?php if (($_SESSION["userperm"] == 'Administrador') || ($temPermissao)) { ?>
                                                            <a href="manageProp?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-danger" onClick="return confirm('Você realmente deseja deletar essa proposta?');"><i class="fas fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>                                                    
                                                    <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                    <td><?php echo $representante; ?></td>
                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                    <td><?php echo $row['propTipoProd']; ?></td>


                                                </tr>
                                            <?php
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-enviadas" role="tabpanel" aria-labelledby="pills-enviadas-tab">
                                <h4 class="text-conecta py-2">Propostas Enviadas</h4>
                                <div class="content-panel" style="overflow: scroll;">
                                    <table id="tableEnviada" class="table table-striped table-advance table-hover bg-white">
                                        <thead class="text-conecta">
                                            <tr>
                                                <th>Nº</th>
                                                <th></th>
                                                <th>Data Chegada</th>
                                                <th>Status (CN)</th>
                                                <th>Status (Rep)</th>
                                                <th>Status (Plan)</th>
                                                <th>Representante</th>
                                                <th>Empresa</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>E-mail</th>
                                                <th>Usuário Criador</th>
                                                <th>Produto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%PROP. ENVIADA%'");
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

                                                $dataCompleta = $row['propDataCriacao'];
                                                $dataArray = explode(" ", $dataCompleta);
                                                $data = $dataArray[0];

                                                //Cores Status TC
                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                    $moodStatus = "bg-success";
                                                    $colorText = "";
                                                } else {

                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                        $moodStatus = "bg-danger";
                                                    } else {
                                                        $moodStatus = "bg-amarelo text-dark";
                                                    }
                                                }


                                                //Cores Status Comercial
                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                    $moodStatusComercial = "bg-amarelo";
                                                } else {

                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                        $moodStatusComercial = "bg-verde-claro";
                                                    } else {
                                                        if ($row['propStatus'] == 'APROVADO') {
                                                            $moodStatusComercial = "bg-verde text-white";
                                                        } else {
                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                $moodStatusComercial = "bg-roxo text-white";
                                                            } else {
                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                } else {
                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                        $moodStatusComercial = "bg-rosa";
                                                                    } else {
                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                        } else {
                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                            } else {
                                                                                $moodStatusComercial = "bg-amarelo";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($row['propEmpresa'] != null) {
                                                    $empresa = $row['propEmpresa'];
                                                    $classEmpresa = '';
                                                } else {
                                                    $empresa = '-';
                                                    $classEmpresa = 'class="text-center"';
                                                }

                                                // $idViewer = $row['propId'];
                                                // $existeAnalise = existeAnalise($conn, $idViewer);
                                                // if (!$existeAnalise) {
                                                //     $resultadoAnaliseRep = "Pendente";
                                                //     $moodStatusRep = "bg-amarelo text-dark";
                                                // } else {
                                                //     $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                //     if ($resultadoAnaliseRep == "Aprovado") {
                                                //         $moodStatusRep = "bg-success";
                                                //         $colorText = "";
                                                //     } else {
                                                //         $moodStatusRep = "bg-danger";
                                                //     }
                                                // }

                                                $envioTC = $row["propEnvioTC"];
                                                $envioRelatorio = $row["propEnvioRelatorio"];

                                                if (($envioTC == "true") || ($envioTC == null)) {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar TC";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                } else if ($envioRelatorio == "true") {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar Relatório";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                }
                                            ?>

                                                <tr>
                                                    <td><?php echo $row['propId']; ?></td>
                                                    <td class="d-flex justify-content-around">
                                                        <a href="update-proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                        <?php if ($temFin) { ?>
                                                            <a href="comprovantepagamento?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-success"><i class="fas fa-file-invoice-dollar"></i></button></a>
                                                        <?php } ?>
                                                        <!-- <a href="createpdf?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a> -->
                                                        <?php if (($_SESSION["userperm"] == 'Administrador') || ($temPermissao)) { ?>
                                                            <a href="manageProp?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-danger" onClick="return confirm('Você realmente deseja deletar essa proposta?');"><i class="fas fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                    <td><?php echo $representante; ?></td>
                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                    <td><?php echo $row['propTipoProd']; ?></td>


                                                </tr>
                                            <?php
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-prepedido" role="tabpanel" aria-labelledby="pills-prepedido-tab">
                                <h4 class="text-conecta py-2"><b>Pré-Pedidos</b></h4>
                                <div class="content-panel">
                                    <table id="tablePre" class="table table-striped table-advance table-hover bg-white">
                                        <thead class="text-conecta">
                                            <tr>
                                                <th>Nº</th>
                                                <th></th>
                                                <th>Data Chegada</th>
                                                <th>Status (CN)</th>
                                                <th>Status (Rep)</th>
                                                <th>Status (Plan)</th>
                                                <th>Status (Fin)</th>
                                                <th>Representante</th>
                                                <th>Empresa</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>E-mail</th>
                                                <th>Usuário Criador</th>
                                                <th>Produto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            // $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%APROVADO%'");
                                            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus IN ('PRÉ PEDIDO')");
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

                                                $retStFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                                if (($retStFin) && ($retStFin->num_rows != 0)) {
                                                    while ($rowStFin = mysqli_fetch_array($retStFin)) {
                                                        $statusFin = $rowStFin["apropStatus"];
                                                    }
                                                } else{
                                                    $statusFin = '-';
                                                }

                                                $dataCompleta = $row['propDataCriacao'];
                                                $dataArray = explode(" ", $dataCompleta);
                                                $data = $dataArray[0];

                                                //Cores Status TC
                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                    $moodStatus = "bg-success";
                                                    $colorText = "";
                                                } else {

                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                        $moodStatus = "bg-danger";
                                                    } else {
                                                        $moodStatus = "bg-amarelo text-dark";
                                                    }
                                                }


                                                //Cores Status Comercial
                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                    $moodStatusComercial = "bg-amarelo";
                                                } else {

                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                        $moodStatusComercial = "bg-verde-claro";
                                                    } else {
                                                        if ($row['propStatus'] == 'APROVADO') {
                                                            $moodStatusComercial = "bg-verde text-white";
                                                        } else {
                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                $moodStatusComercial = "bg-roxo text-white";
                                                            } else {
                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                } else {
                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                        $moodStatusComercial = "bg-rosa";
                                                                    } else {
                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                        } else {
                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                            } else {
                                                                                $moodStatusComercial = "bg-amarelo";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                //Cores Status Financeiro
                                                if ($statusFin == "Aprovado") {
                                                    $moodStatusFin = "bg-success";
                                                } else {
                                                    if ($statusFin == "Reprovado") {
                                                        $moodStatusFin = "bg-danger";
                                                    } else {
                                                        $moodStatusFin = "bg-secondary";
                                                    }
                                                }

                                                if ($row['propEmpresa'] != null) {
                                                    $empresa = $row['propEmpresa'];
                                                    $classEmpresa = '';
                                                } else {
                                                    $empresa = '-';
                                                    $classEmpresa = 'class="text-center"';
                                                }

                                                // $idViewer = $row['propId'];
                                                // $existeAnalise = existeAnalise($conn, $idViewer);
                                                // if (!$existeAnalise) {
                                                //     $resultadoAnaliseRep = "Pendente";
                                                //     $moodStatusRep = "bg-amarelo text-dark";
                                                // } else {
                                                //     $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                //     if ($resultadoAnaliseRep == "Aprovado") {
                                                //         $moodStatusRep = "bg-success";
                                                //         $colorText = "";
                                                //     } else {
                                                //         $moodStatusRep = "bg-danger";
                                                //     }
                                                // }

                                                $envioTC = $row["propEnvioTC"];
                                                $envioRelatorio = $row["propEnvioRelatorio"];

                                                if (($envioTC == "true") || ($envioTC == null)) {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar TC";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                } else if ($envioRelatorio == "true") {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar Relatório";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                }

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['propId']; ?></td>
                                                    <td class="d-flex justify-content-around">
                                                        <a href="update-proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                        <?php if ($temFin) { ?>
                                                            <a href="comprovantepagamento?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-success"><i class="fas fa-file-invoice-dollar"></i></button></a>
                                                        <?php } ?>
                                                        <!-- <a href="createpdf?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a> -->
                                                        <?php if (($_SESSION["userperm"] == 'Administrador') || ($temPermissao)) { ?>
                                                            <a href="manageProp?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-danger" onClick="return confirm('Você realmente deseja deletar essa proposta?');"><i class="fas fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatusFin; ?>" style="color:#fff;"><?php echo $statusFin; ?></span></td>
                                                    <td><?php echo $representante; ?></td>
                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                    <td><?php echo $row['propTipoProd']; ?></td>


                                                </tr>
                                            <?php
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-aprovadas" role="tabpanel" aria-labelledby="pills-aprovadas-tab">
                                <h4 class="text-conecta py-2">Propostas Aprovadas Pelos Clientes</h4>
                                <div class="content-panel" style="overflow: scroll;">
                                    <table id="tableAprov" class="table table-striped table-advance table-hover bg-white">
                                        <thead class="text-conecta">
                                            <tr>
                                                <th>Nº</th>
                                                <th></th>
                                                <th>Data Chegada</th>
                                                <th>Status (CN)</th>
                                                <th>Status (Rep)</th>
                                                <th>Status (Plan)</th>
                                                <th>Status (Fin)</th>
                                                <th>Representante</th>
                                                <th>Empresa</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>E-mail</th>
                                                <th>Usuário Criador</th>
                                                <th>Produto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            // $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%APROVADO%'");
                                            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus IN ('APROVADO')");
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

                                                $retStFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                                if (($retStFin) && ($retStFin->num_rows != 0)) {
                                                    while ($rowStFin = mysqli_fetch_array($retStFin)) {
                                                        $statusFin = $rowStFin["apropStatus"];
                                                    }
                                                }

                                                $dataCompleta = $row['propDataCriacao'];
                                                $dataArray = explode(" ", $dataCompleta);
                                                $data = $dataArray[0];

                                                //Cores Status TC
                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                    $moodStatus = "bg-success";
                                                    $colorText = "";
                                                } else {

                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                        $moodStatus = "bg-danger";
                                                    } else {
                                                        $moodStatus = "bg-amarelo text-dark";
                                                    }
                                                }


                                                //Cores Status Comercial
                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                    $moodStatusComercial = "bg-amarelo";
                                                } else {

                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                        $moodStatusComercial = "bg-verde-claro";
                                                    } else {
                                                        if ($row['propStatus'] == 'APROVADO') {
                                                            $moodStatusComercial = "bg-verde text-white";
                                                        } else {
                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                $moodStatusComercial = "bg-roxo text-white";
                                                            } else {
                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                } else {
                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                        $moodStatusComercial = "bg-rosa";
                                                                    } else {
                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                        } else {
                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                            } else {
                                                                                $moodStatusComercial = "bg-amarelo";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                //Cores Status Financeiro
                                                if ($statusFin == "Aprovado") {
                                                    $moodStatusFin = "bg-success";
                                                } else {
                                                    if ($statusFin == "Reprovado") {
                                                        $moodStatusFin = "bg-danger";
                                                    } else {
                                                        $moodStatusFin = "bg-secondary";
                                                    }
                                                }

                                                if ($row['propEmpresa'] != null) {
                                                    $empresa = $row['propEmpresa'];
                                                    $classEmpresa = '';
                                                } else {
                                                    $empresa = '-';
                                                    $classEmpresa = 'class="text-center"';
                                                }

                                                // $idViewer = $row['propId'];
                                                // $existeAnalise = existeAnalise($conn, $idViewer);
                                                // if (!$existeAnalise) {
                                                //     $resultadoAnaliseRep = "Pendente";
                                                //     $moodStatusRep = "bg-amarelo text-dark";
                                                // } else {
                                                //     $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                //     if ($resultadoAnaliseRep == "Aprovado") {
                                                //         $moodStatusRep = "bg-success";
                                                //         $colorText = "";
                                                //     } else {
                                                //         $moodStatusRep = "bg-danger";
                                                //     }
                                                // }

                                                $envioTC = $row["propEnvioTC"];
                                                $envioRelatorio = $row["propEnvioRelatorio"];

                                                if (($envioTC == "true") || ($envioTC == null)) {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar TC";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                } else if ($envioRelatorio == "true") {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar Relatório";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                }

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['propId']; ?></td>
                                                    <td class="d-flex justify-content-around">
                                                        <a href="update-proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                        <?php if ($temFin) { ?>
                                                            <a href="comprovantepagamento?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-success"><i class="fas fa-file-invoice-dollar"></i></button></a>
                                                        <?php } ?>
                                                        <!-- <a href="createpdf?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a> -->
                                                        <?php if (($_SESSION["userperm"] == 'Administrador') || ($temPermissao)) { ?>
                                                            <a href="manageProp?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-danger" onClick="return confirm('Você realmente deseja deletar essa proposta?');"><i class="fas fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatusFin; ?>" style="color:#fff;"><?php echo $statusFin; ?></span></td>
                                                    <td><?php echo $representante; ?></td>
                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                    <td><?php echo $row['propTipoProd']; ?></td>


                                                </tr>
                                            <?php
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-pedidos" role="tabpanel" aria-labelledby="pills-pedidos-tab">
                                <h4 class="text-conecta py-2">Pedidos</h4>
                                <div class="content-panel" style="overflow: scroll;">
                                    <table id="tablePed" class="table table-striped table-advance table-hover bg-white">
                                        <thead class="text-conecta">
                                            <tr>
                                                <th>Nº</th>
                                                <th></th>
                                                <th>Data Chegada</th>
                                                <th>Status (CN)</th>
                                                <th>Status (Rep)</th>
                                                <th>Status (Plan)</th>
                                                <th>Representante</th>
                                                <th>Empresa</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>E-mail</th>
                                                <th>Usuário Criador</th>
                                                <th>Produto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            // $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%PEDIDO%'");
                                            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%PEDIDO%' AND NOT propStatus IN ('PRÉ PEDIDO')");
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

                                                $dataCompleta = $row['propDataCriacao'];
                                                $dataArray = explode(" ", $dataCompleta);
                                                $data = $dataArray[0];

                                                // //Cores Status TC
                                                // if ($row['propStatusTC'] == "TC APROVADA") {
                                                //     $moodStatus = "bg-success";
                                                //     $colorText = "";
                                                // } else {

                                                //     if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                //         $moodStatus = "bg-danger";
                                                //     } else {
                                                //         $moodStatus = "bg-amarelo text-dark";
                                                //     }
                                                // }


                                                //Cores Status Comercial
                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                    $moodStatusComercial = "bg-amarelo";
                                                } else {

                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                        $moodStatusComercial = "bg-verde-claro";
                                                    } else {
                                                        if ($row['propStatus'] == 'APROVADO') {
                                                            $moodStatusComercial = "bg-verde text-white";
                                                        } else {
                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                $moodStatusComercial = "bg-roxo text-white";
                                                            } else {
                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                } else {
                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                        $moodStatusComercial = "bg-rosa";
                                                                    } else {
                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                        } else {
                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                            } else {
                                                                                $moodStatusComercial = "bg-amarelo";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($row['propEmpresa'] != null) {
                                                    $empresa = $row['propEmpresa'];
                                                    $classEmpresa = '';
                                                } else {
                                                    $empresa = '-';
                                                    $classEmpresa = 'class="text-center"';
                                                }

                                                // $idViewer = $row['propId'];
                                                // $existeAnalise = existeAnalise($conn, $idViewer);
                                                // if (!$existeAnalise) {
                                                //     $resultadoAnaliseRep = "Pendente";
                                                //     $moodStatusRep = "bg-amarelo text-dark";
                                                // } else {
                                                //     $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                //     if ($resultadoAnaliseRep == "Aprovado") {
                                                //         $moodStatusRep = "bg-success";
                                                //         $colorText = "";
                                                //     } else {
                                                //         $moodStatusRep = "bg-danger";
                                                //     }
                                                // }

                                                $envioTC = $row["propEnvioTC"];
                                                $envioRelatorio = $row["propEnvioRelatorio"];

                                                if (($envioTC == "true") || ($envioTC == null)) {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar TC";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                } else if ($envioRelatorio == "true") {
                                                    $idViewer = $row['propId'];
                                                    $existeAnalise = existeAnalise($conn, $idViewer);
                                                    if (!$existeAnalise) {
                                                        $resultadoAnaliseRep = "Analisar Relatório";
                                                        $moodStatusRep = "bg-amarelo text-dark";
                                                    } else {
                                                        $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                        if ($resultadoAnaliseRep == "Aprovado") {
                                                            $moodStatusRep = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            $moodStatusRep = "bg-danger";
                                                        }
                                                    }
                                                }

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['propId']; ?></td>
                                                    <td class="d-flex justify-content-around">
                                                        <a href="update-proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                        <?php if ($temFin) { ?>
                                                            <a href="comprovantepagamento?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-success"><i class="fas fa-file-invoice-dollar"></i></button></a>
                                                        <?php } ?>
                                                        <!-- <a href="createpdf?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a> -->
                                                        <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                            <a href="manageProp?id=<?php echo $row['propId']; ?>">
                                                                <button class="btn text-danger" onClick="return confirm('Você realmente deseja deletar essa proposta?');"><i class="fas fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                    <td><?php echo $representante; ?></td>
                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                    <td><?php echo $row['propUserCriacao']; ?></td>
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
        </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#tablePre').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tableProp').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tableProp2').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tablePropPend').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tableEnviada').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tableAprov').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tablePed').DataTable({
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
                        [0, "desc"]
                    ]
                });
            });
        </script>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>