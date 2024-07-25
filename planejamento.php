<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Administrador')) || $_SESSION["useruid"] == "lenicomercial" || $_SESSION["useruid"] == "lenirodrigues" || $_SESSION["useruid"] == "thaissa" || $_SESSION["useruid"] == "samuel900" ) {
    include("php/head_tables.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

?>

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
                    if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Proposta editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Proposta foi deletada!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start">
                                <h2 class="text-conecta" style="font-weight: 400;">Análise de <span style="font-weight: 700;">TC</span></h2>
                            </div>
                            <div class="col-sm d-none d-sm-block">
                                <div class="d-flex justify-content-end p-1">
                                    <a href="exportPlan"><button class="btn btn-conecta"><i class="far fa-file-excel"></i> Exportar</button></a>
                                </div>

                            </div>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">

                                <!--Tabs for large devices-->
                                <div class="d-flex justify-content-center">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link active text-tab" id="pills-analisar-tab" data-toggle="pill" href="#pills-analisar" role="tab" aria-controls="pills-analisar" aria-selected="true">Analisar</a>
                                        </li>
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link text-tab" id="pills-aprovadas-tab" data-toggle="pill" href="#pills-aprovadas" role="tab" aria-controls="pills-aprovadas" aria-selected="true">Aprovadas</a>
                                        </li>
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link text-tab" id="pills-reprovadas-tab" data-toggle="pill" href="#pills-reprovadas" role="tab" aria-controls="pills-reprovadas" aria-selected="false">Reprovadas</a>
                                        </li>
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link text-tab" id="pills-todas-tab" data-toggle="pill" href="#pills-todas" role="tab" aria-controls="pills-todas" aria-selected="false">Todas</a>
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
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-aprovadas-tab" data-toggle="pill" href="#pills-aprovadas" role="tab" aria-controls="pills-aprovadas" aria-selected="true"><i class="fas fa-check-circle fa-2x"></i></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-reprovadas-tab" data-toggle="pill" href="#pills-reprovadas" role="tab" aria-controls="pills-reprovadas" aria-selected="false"><i class="fas fa-times-circle fa-2x"></i></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-todas-tab" data-toggle="pill" href="#pills-todas" role="tab" aria-controls="pills-todas" aria-selected="false"><i class="fas fa-border-all fa-2x"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-analisar" role="tabpanel" aria-labelledby="pills-analisar-tab">
                                        <h4 class="text-black py-2"><b>Analisar</b></h4>
                                        <div class="content-panel">
                                            <table id="table1" class="table table-striped table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nº Prop</th>
                                                        <th>Data Chegada</th>
                                                        <th>TC</th>
                                                        <th>Analise Rep</th>
                                                        <th>Link</th>
                                                        <th>Status</th>
                                                        <th>Dr(a)</th>
                                                        <th>Paciente</th>
                                                        <th>Modalidade</th>

                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus IN ('PEDIDO','PRÉ PEDIDO') AND propStatusTC IN ('ANALISAR','REENVIADA')");
                                                    $cnt = 1;

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $ID = $row['propId'];
                                                        $dataCompleta = $row['propDataCriacao'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if (strpos($row['propStatusTC'], 'APROVADA')) {
                                                            $moodStatus = "bg-success text-white";
                                                            $colorText = "";
                                                        } else {
                                                            if (strpos($row['propStatusTC'], 'REPROVADA')) {
                                                                $moodStatus = "bg-danger text-white";
                                                            } else {
                                                                $moodStatus = "bg-warning text-black";
                                                            }
                                                        }

                                                        $linktcBD = null;
                                                        $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $ID . "' ;");
                                                        while ($rowFile = mysqli_fetch_array($retFile)) {
                                                            $linktcBD = $rowFile['fileCdnUrl'];
                                                        }
                                                        if ($linktcBD != null) {
                                                            $linktc = '<span class="badge badge-success"><i class="fas fa-folder"></i></span>';
                                                        } else {
                                                            $linktc = '<a href="adicionarlink?type=plan&id=' . $ID . '" target="_blank"><span class="badge badge-danger"><i class="far fa-folder-open"></i></span></a>';
                                                        }


                                                        $existeAnalise = existeAnalise($conn, $ID);
                                                        if (!$existeAnalise) {
                                                            $resultadoAnaliseRep = "Pendente";
                                                            $moodStatusRep = "bg-warning text-dark";
                                                        } else {
                                                            $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                            if ($resultadoAnaliseRep == "Aprovado") {
                                                                $moodStatusRep = "bg-success";
                                                                $colorText = "";
                                                            } else {
                                                                $moodStatusRep = "bg-danger";
                                                            }
                                                        }
                                                        
                                                        if ($existeAnalise && $existeAnalise['aprovStatus'] == "Aprovado") {
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['propId']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>"><?php echo $row['propStatusTC']; ?></span></td>
                                                            <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                            <td class="d-flex justify-content-center"><?php echo $linktc; ?></td>
                                                            <td><?php echo $row['propStatus']; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>


                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="update-plan?id=<?php echo $row['propId']; ?>">
                                                                    <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        }
                                                        $cnt = $cnt + 1;
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-aprovadas" role="tabpanel" aria-labelledby="pills-aprovadas-tab">
                                        <h4 class="text-black py-2"><b>Aprovadas</b></h4>
                                        <div class="content-panel">
                                            <table id="table2" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Nº Prop</th>
                                                        <th>Data Chegada</th>
                                                        <th>TC</th>
                                                        <th>Analise Rep</th>
                                                        <th>Link</th>
                                                        <th>Status</th>
                                                        <th>Dr(a)</th>
                                                        <th>Paciente</th>
                                                        <th>Modalidade</th>

                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatusTC  LIKE '%APROVADA%'");
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $ID = $row['propId'];
                                                        $dataCompleta = $row['propDataCriacao'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if (strpos($row['propStatusTC'], 'APROVADA')) {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if (strpos($row['propStatusTC'], 'REPROVADA')) {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }
                                                        $linktcBD = null;
                                                        $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $ID . "' ;");
                                                        while ($rowFile = mysqli_fetch_array($retFile)) {
                                                            $linktcBD = $rowFile['fileCdnUrl'];
                                                        }
                                                        if ($linktcBD != null) {
                                                            $linktc = '<span class="badge badge-success"><i class="fas fa-folder"></i></span>';
                                                        } else {
                                                            $linktc = '<a href="adicionarlink?type=plan&id=' . $ID . '" target="_blank"><span class="badge badge-danger"><i class="far fa-folder-open"></i></span></a>';
                                                        }


                                                        $existeAnalise = existeAnalise($conn, $ID);
                                                        if (!$existeAnalise) {
                                                            $resultadoAnaliseRep = "Pendente";
                                                            $moodStatusRep = "bg-warning text-dark";
                                                        } else {
                                                            $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                            if ($resultadoAnaliseRep == "Aprovado") {
                                                                $moodStatusRep = "bg-success";
                                                                $colorText = "";
                                                            } else {
                                                                $moodStatusRep = "bg-danger";
                                                            }
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['propId']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                            <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                            <td class="d-flex justify-content-center"><?php echo $linktc; ?></td>
                                                            <td><?php echo $row['propStatus']; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>


                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="update-plan?id=<?php echo $row['propId']; ?>">
                                                                    <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                            </td>
                                                        </tr>
                                                    <?php

                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-reprovadas" role="tabpanel" aria-labelledby="pills-reprovadas-tab">
                                        <h4 class="text-black py-2"><b>Reprovadas</b></h4>
                                        <div class="content-panel">
                                            <table id="table3" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Nº Prop</th>
                                                        <th>Data Chegada</th>
                                                        <th>TC</th>
                                                        <th>Analise Rep</th>
                                                        <th>Link</th>
                                                        <th>Status</th>
                                                        <th>Dr(a)</th>
                                                        <th>Paciente</th>
                                                        <th>Modalidade</th>

                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                
                                                 <tbody>
                                                    <?php

                                                    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatusTC  LIKE '%REPROVADA%'");
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $ID = $row['propId'];
                                                        $dataCompleta = $row['propDataCriacao'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if (strpos($row['propStatusTC'], 'APROVADA')) {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if (strpos($row['propStatusTC'], 'REPROVADA')) {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }
                                                        $linktcBD = null;
                                                        $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $ID . "' ;");
                                                        while ($rowFile = mysqli_fetch_array($retFile)) {
                                                            $linktcBD = $rowFile['fileCdnUrl'];
                                                        }
                                                        if ($linktcBD != null) {
                                                            $linktc = '<span class="badge badge-success"><i class="fas fa-folder"></i></span>';
                                                        } else {
                                                            $linktc = '<a href="adicionarlink?type=plan&id=' . $ID . '" target="_blank"><span class="badge badge-danger"><i class="far fa-folder-open"></i></span></a>';
                                                        }


                                                        $existeAnalise = existeAnalise($conn, $ID);
                                                        if (!$existeAnalise) {
                                                            $resultadoAnaliseRep = "Pendente";
                                                            $moodStatusRep = "bg-warning text-dark";
                                                        } else {
                                                            $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                            if ($resultadoAnaliseRep == "Aprovado") {
                                                                $moodStatusRep = "bg-success";
                                                                $colorText = "";
                                                            } else {
                                                                $moodStatusRep = "bg-danger";
                                                            }
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['propId']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                            <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                            <td class="d-flex justify-content-center"><?php echo $linktc; ?></td>
                                                            <td><?php echo $row['propStatus']; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>


                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="update-plan?id=<?php echo $row['propId']; ?>">
                                                                    <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                            </td>
                                                        </tr>
                                                    <?php

                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="pills-todas" role="tabpanel" aria-labelledby="pills-todas-tab">
                                        <h4 class="text-black py-2"><b>Todas</b></h4>
                                        <div class="content-panel">
                                            <table id="table4" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Nº Prop</th>
                                                        <th>Data Chegada</th>
                                                        <th>TC</th>
                                                        <th>Analise Rep</th>
                                                        <th>Link</th>
                                                        <th>Status</th>
                                                        <th>Dr(a)</th>
                                                        <th>Paciente</th>
                                                        <th>Modalidade</th>

                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $ret = mysqli_query($conn, "SELECT * FROM propostas;");
                                                    

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $ID = $row['propId'];
                                                        $dataCompleta = $row['propDataCriacao'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if (strpos($row['propStatusTC'], 'APROVADA')) {
                                                            $moodStatus = "bg-success text-white";
                                                            $colorText = "";
                                                        } else {
                                                            if (strpos($row['propStatusTC'], 'REPROVADA')) {
                                                                $moodStatus = "bg-danger text-white";
                                                            } else {
                                                                $moodStatus = "bg-warning text-black";
                                                            }
                                                        }

                                                        $linktcBD = null;
                                                        $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $ID . "' ;");
                                                        while ($rowFile = mysqli_fetch_array($retFile)) {
                                                            $linktcBD = $rowFile['fileCdnUrl'];
                                                        }
                                                        if ($linktcBD != null) {
                                                            $linktc = '<span class="badge badge-success"><i class="fas fa-folder"></i></span>';
                                                        } else {
                                                            $linktc = '<a href="adicionarlink?type=plan&id=' . $ID . '" target="_blank"><span class="badge badge-danger"><i class="far fa-folder-open"></i></span></a>';
                                                        }


                                                        $existeAnalise = existeAnalise($conn, $ID);
                                                        if (!$existeAnalise) {
                                                            $resultadoAnaliseRep = "Pendente";
                                                            $moodStatusRep = "bg-warning text-dark";
                                                        } else {
                                                            $resultadoAnaliseRep = $existeAnalise['aprovStatus'];

                                                            if ($resultadoAnaliseRep == "Aprovado") {
                                                                $moodStatusRep = "bg-success";
                                                                $colorText = "";
                                                            } else {
                                                                $moodStatusRep = "bg-danger";
                                                            }
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['propId']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>"><?php echo $row['propStatusTC']; ?></span></td>
                                                            <td><span class="badge <?php echo $moodStatusRep; ?>" style="color:#fff;"><?php echo $resultadoAnaliseRep; ?></span></td>
                                                            <td class="d-flex justify-content-center"><?php echo $linktc; ?></td>
                                                            <td><?php echo $row['propStatus']; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>


                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="update-plan?id=<?php echo $row['propId']; ?>">
                                                                    <button class="btn text-info"><i class="fas fa-edit"></i></button></a>
                                                            </td>
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
                $('#table1').DataTable({
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
                $('#table2').DataTable({
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
                $('#table3').DataTable({
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
                $('#table4').DataTable({
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