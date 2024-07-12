<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Qualidade')) || ($_SESSION["userperm"] == 'Administrador')) {
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
                    if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Proposta editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Proposta foi deletada!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10 justify-content-start">
                        <h2 class="text-conecta" style="font-weight: 400;">Análise de Documentos <span style="font-weight: 700;"> da Anvisa</span></h2>
                        <hr style="border-color: #ee7624;">
                        <br>

                        <div class="card shadow">
                            <div class="card-body">
                                <!--Casos Abertos, Casos Pendentes, Casos Finalizados e Casos Arquivados-->
                                <!--Tabs for large devices-->
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link active text-tab" id="pills-xidr-tab" data-toggle="pill" href="#pills-xidr" role="tab" aria-controls="pills-xidr" aria-selected="true">Anexo I (Dr)</a>
                                    </li>
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link text-tab" id="pills-xipac-tab" data-toggle="pill" href="#pills-xipac" role="tab" aria-controls="pills-xipac" aria-selected="true">Anexo I (Pac)</a>
                                    </li>
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link text-tab" id="pills-xii-tab" data-toggle="pill" href="#pills-xii" role="tab" aria-controls="pills-xii" aria-selected="false">Anexo II</a>
                                    </li>
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link text-tab" id="pills-xiiidr-tab" data-toggle="pill" href="#pills-xiiidr" role="tab" aria-controls="pills-xiiidr" aria-selected="false">Anexo III (Dr)</a>
                                    </li>
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link text-tab" id="pills-xiiipac-tab" data-toggle="pill" href="#pills-xiiipac" role="tab" aria-controls="pills-xiiipac" aria-selected="false">Anexo III (Pac)</a>
                                    </li>
                                </ul>

                                <!-- Tabs for smaller devices -->
                                <ul class="nav nav-pills mb-3" id="pills-tab-small" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center active text-tab" id="pills-xidr-tab" data-toggle="pill" href="#pills-xidr" role="tab" aria-controls="pills-xidr" aria-selected="true">Dr I</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center text-tab" id="pills-xipac-tab" data-toggle="pill" href="#pills-xipac" role="tab" aria-controls="pills-xipac" aria-selected="true">Pac I</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center text-tab" id="pills-xii-tab" data-toggle="pill" href="#pills-xii" role="tab" aria-controls="pills-xii" aria-selected="false">II</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center text-tab" id="pills-xiiidr-tab" data-toggle="pill" href="#pills-xiiidr" role="tab" aria-controls="pills-xiiidr" aria-selected="false">Dr III</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center text-tab" id="pills-xiiipac-tab" data-toggle="pill" href="#pills-xiiipac" role="tab" aria-controls="pills-xiiipac" aria-selected="false">Pac III</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-xidr" role="tabpanel" aria-labelledby="pills-xidr-tab">

                                        <div class="content-panel">
                                            <table id="table1" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Proj</th>
                                                        <th>Data Chegada</th>
                                                        <th>Status</th>
                                                        <th>Dr(a).</th>
                                                        <th>Pac</th>
                                                        <th>Produto</th>


                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM qualianexoidr WHERE xidrStatusEnvio = 'ENVIADO'");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['xidrDataUpdate'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['xidrStatusQualidade'] == "APROVADO") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['xidrStatusQualidade'] == "REPROVADO") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['xidrIdProjeto']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['xidrStatusQualidade']; ?></span></td>
                                                            <td><?php echo $row['xidrNomeDr']; ?></td>
                                                            <td><?php echo $row['xidrNomePaciente']; ?></td>
                                                            <td><?php echo $row['xidrProduto']; ?></td>


                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="viewanexoidr?id=<?php echo $row['xidrIdProjeto']; ?>">
                                                                    <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>

                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>


                                    </div>

                                    <div class="tab-pane fade" id="pills-xipac" role="tabpanel" aria-labelledby="pills-xipac-tab">
                                        <div class="content-panel">
                                            <table id="table2" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Proj</th>
                                                        <th>Data Chegada</th>
                                                        <th>Status</th>
                                                        <th>Paciente</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM qualianexoipac WHERE xipacStatusEnvio = 'ENVIADO'");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['xipacDataUpdate'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['xipacStatusQualidade'] == "APROVADO") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['xipacStatusQualidade'] == "REPROVADO") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['xipacIdProjeto']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['xipacStatusQualidade']; ?></span></td>
                                                            <td><?php echo $row['xipacNomePac']; ?></td>

                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="viewanexoipac?id=<?php echo $row['xipacIdProjeto']; ?>">
                                                                    <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>

                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-xii" role="tabpanel" aria-labelledby="pills-xii-tab">
                                        <div class="content-panel">
                                            <table id="table3" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Proj</th>
                                                        <th>Data Chegada</th>
                                                        <th>Status</th>
                                                        <th>Dr(a).</th>
                                                        <th>Pac</th>
                                                        <th>Produto</th>


                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM qualianexoii WHERE xiiStatusEnvio = 'ENVIADO'");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['xiiDataUpdate'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['xiiStatusQualidade'] == "APROVADO") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['xiiStatusQualidade'] == "REPROVADO") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['xiiIdProjeto']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['xiiStatusQualidade']; ?></span></td>
                                                            <td><?php echo $row['xiiNomeDr']; ?></td>
                                                            <td><?php echo $row['xiiNomePac']; ?></td>
                                                            <td><?php echo $row['xiiImplanteCirurgia']; ?></td>


                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="viewanexoii?id=<?php echo $row['xiiIdProjeto']; ?>">
                                                                    <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>

                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-xiiidr" role="tabpanel" aria-labelledby="pills-xiiidr-tab">
                                        <div class="content-panel">
                                            <table id="table4" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Proj</th>
                                                        <th>Data Chegada</th>
                                                        <th>Status</th>
                                                        <th>Dr(a).</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM qualianexoiiidr WHERE xiiidrStatusEnvio='ENVIADO'");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['xiiidrDataUpdate'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['xiiidrStatusQualidade'] == "APROVADO") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['xiiidrStatusQualidade'] == "REPROVADO") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['xiiidrIdProjeto']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['xiiidrStatusQualidade']; ?></span></td>
                                                            <td><?php echo $row['xiiidrNomeDr']; ?></td>

                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="viewanexoiiidr?id=<?php echo $row['xiiidrIdProjeto']; ?>">
                                                                    <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>

                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-xiiipac" role="tabpanel" aria-labelledby="pills-xiiipac-tab">
                                        <div class="content-panel">
                                            <table id="table5" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>Proj</th>
                                                        <th>Data Chegada</th>
                                                        <th>Status</th>
                                                        <th>Pac</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM qualianexoiiipac WHERE xiiipacStatusEnvio='ENVIADO'");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $dataCompleta = $row['xiiipacDataUpdate'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        if ($row['xiiipacStatusQualidade'] == "APROVADO") {
                                                            $moodStatus = "bg-success";
                                                            $colorText = "";
                                                        } else {
                                                            if ($row['xiiipacStatusQualidade'] == "REPROVADO") {
                                                                $moodStatus = "bg-danger";
                                                            } else {
                                                                $moodStatus = "bg-secondary";
                                                            }
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['xiiipacIdProjeto']; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['xiiipacStatusQualidade']; ?></span></td>
                                                            <td><?php echo $row['xiiipacNomePac']; ?></td>

                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="viewanexoiiipac?id=<?php echo $row['xiiipacIdProjeto']; ?>">
                                                                    <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>

                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
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
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            //table1
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
                        "zeroRecords": "Nenhum documento encontrado"
                    }
                });
            });

            //table2
            $(document).ready(function() {
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
                        "zeroRecords": "Nenhum documento encontrado"
                    }
                });
            });

            //table3
            $(document).ready(function() {
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
                        "zeroRecords": "Nenhum documento encontrado"
                    }
                });
            });

            //table4
            $(document).ready(function() {
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
                        "zeroRecords": "Nenhum documento encontrado"
                    }
                });
            });

            //table5
            $(document).ready(function() {
                $('#table5').DataTable({
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
                        "zeroRecords": "Nenhum documento encontrado"
                    }
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