<?php
session_start();

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Financeiro'))) {
    include("php/head_tables.php");
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
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start">
                                <h2 class="text-conecta" style="font-weight: 400;">Aceites de <span style="font-weight: 700;">Propostas</span></h2>
                            </div>
                            <div class="col-sm d-none d-sm-block">
                                <div class="d-flex justify-content-end p-1">
                                    <a href="exportPropFin"><button class="btn btn-conecta"><i class="far fa-file-excel"></i> Exportar</button></a>
                                </div>
                            </div>
                        </div>
                        <hr style="border-color: #ee7624;">
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
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-todas-tab" data-toggle="pill" href="#pills-todas" role="tab" aria-controls="pills-todas" aria-selected="false"><i class="fas fa-file-alt fa-2x"></i></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-analisar" role="tabpanel" aria-labelledby="pills-analisar-tab">
                                        <h4 class="text-black py-2"><b>Analisar</b></h4>
                                        <div class="content-panel">
                                            <table id="tableAnalisar" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Nº Prop</th>
                                                        <th>Data Aceite</th>
                                                        <th>Status</th>
                                                        <th>Forma Pgto</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropStatus LIKE '%Em Análise%'");



                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['apropData'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['apropStatus'] == "Aprovado") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['apropStatus'] == "Reprovado") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }

                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['apropNumProp']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['apropStatus']; ?></span></td>
                                                            <td><?php echo $row['apropFormaPgto']; ?></td>

                                                            <td>

                                                                <a href="veraceiteproposta?id=<?php echo $row['apropId']; ?>">
                                                                    <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                                <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                                    <a href="manageaceiteprop?id=<?php echo $row['apropId']; ?>">
                                                                        <button class="btn text-danger btn-xs" onClick="return confirm('Você realmente deseja deletar esse aceite de proposta?');"><i class="far fa-trash-alt"></i></button></a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="pills-aprovadas" role="tabpanel" aria-labelledby="pills-aprovadas-tab">
                                        <h4 class="text-black py-2"><b>Aprovadas</b></h4>
                                        <div class="content-panel">
                                            <table id="tableAprov" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Nº Prop</th>
                                                        <th>Data Aceite</th>
                                                        <th>Status</th>
                                                        <th>Forma Pgto</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropStatus LIKE '%Aprovado%'");



                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['apropData'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['apropStatus'] == "Aprovado") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['apropStatus'] == "Reprovado") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }

                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['apropNumProp']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['apropStatus']; ?></span></td>
                                                            <td><?php echo $row['apropFormaPgto']; ?></td>

                                                            <td>

                                                                <a href="veraceiteproposta?id=<?php echo $row['apropId']; ?>">
                                                                    <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                                <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                                    <a href="manageaceiteprop?id=<?php echo $row['apropId']; ?>">
                                                                        <button class="btn text-danger btn-xs" onClick="return confirm('Você realmente deseja deletar esse aceite de proposta?');"><i class="far fa-trash-alt"></i></button></a>
                                                                <?php
                                                                }
                                                                ?>
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
                                            <table id="tableReprov" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Nº Prop</th>
                                                        <th>Data Aceite</th>
                                                        <th>Status</th>
                                                        <th>Forma Pgto</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropStatus LIKE '%Reprovado%'");


                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['apropData'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['apropStatus'] == "Aprovado") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['apropStatus'] == "Reprovado") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }

                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['apropNumProp']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['apropStatus']; ?></span></td>
                                                            <td><?php echo $row['apropFormaPgto']; ?></td>

                                                            <td>

                                                                <a href="veraceiteproposta?id=<?php echo $row['apropId']; ?>">
                                                                    <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                                <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                                    <a href="manageaceiteprop?id=<?php echo $row['apropId']; ?>">
                                                                        <button class="btn text-danger btn-xs" onClick="return confirm('Você realmente deseja deletar esse aceite de proposta?');"><i class="far fa-trash-alt"></i></button></a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-todas" role="tabpanel" aria-labelledby="pills-todas-tab">
                                        <h4 class="text-black py-2"><b>Todos Aceites</b></h4>
                                        <div class="content-panel">
                                            <table id="tableTodos" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Nº Prop</th>
                                                        <th>Data Aceite</th>
                                                        <th>Status</th>
                                                        <th>Forma Pgto</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta");



                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['apropData'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['apropStatus'] == "Aprovado") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['apropStatus'] == "Reprovado") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }

                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['apropNumProp']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['apropStatus']; ?></span></td>
                                                            <td><?php echo $row['apropFormaPgto']; ?></td>

                                                            <td>

                                                                <a href="veraceiteproposta?id=<?php echo $row['apropId']; ?>">
                                                                    <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                                <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                                    <a href="manageaceiteprop?id=<?php echo $row['apropId']; ?>">
                                                                        <button class="btn text-danger btn-xs" onClick="return confirm('Você realmente deseja deletar esse aceite de proposta?');"><i class="far fa-trash-alt"></i></button></a>
                                                                <?php
                                                                }
                                                                ?>
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
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#tableAnalisar').DataTable({
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
                $('#tableReprov').DataTable({
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
                $('#tableTodos').DataTable({
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