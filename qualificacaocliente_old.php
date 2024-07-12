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
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Algo deu errado, por favor tente novamente!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <h2 class="text-conecta" style="font-weight: 400;">Qualificação de <span style="font-weight: 700;"> Clientes</span></h2>
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
                                            <a class="nav-link text-tab" id="pills-enviados-tab" data-toggle="pill" href="#pills-enviados" role="tab" aria-controls="pills-enviados" aria-selected="true">Enviado ao Cliente</a>
                                        </li>
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link text-tab" id="pills-concluidos-tab" data-toggle="pill" href="#pills-concluidos" role="tab" aria-controls="pills-concluidos" aria-selected="true">Concluídos</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Tabs for smaller devices -->
                                <div class="d-flex justify-content-center">
                                    <ul class="nav nav-pills mb-3" id="pills-tab-small" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center active text-tab" id="pills-analisar-tab" data-toggle="pill" href="#pills-analisar" role="tab" aria-controls="pills-analisar" aria-selected="true"><i class="fas fa-clock fa-2x"></i></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-enviados-tab" data-toggle="pill" href="#pills-enviados" role="tab" aria-controls="pills-enviados" aria-selected="true"><i class="fas fa-plane fa-2x"></i></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-concluidos-tab" data-toggle="pill" href="#pills-concluidos" role="tab" aria-controls="pills-concluidos" aria-selected="true"><i class="fas fa-check fa-2x"></i></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-analisar" role="tabpanel" aria-labelledby="pills-analisar-tab">
                                        <h4 class="text-black py-2"><b>Formulários respondido pelos clientes</b></h4>
                                        <div class="content-panel">
                                            <table id="table1" class="table table-striped table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Dt</th>
                                                        <th>Usuário</th>
                                                        <th>Empresa</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    require_once 'includes/functions.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiStatus='Analisar';");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $id = $row["qualiId"];
                                                        $data = $row["qualiDtChegada"];
                                                        $usuario = $row["qualiUsuario"];
                                                        $empresa = getNomeEmpresa($conn, $usuario);

                                                    ?>
                                                        <tr>
                                                            <td><?php echo $id; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo $usuario; ?></td>
                                                            <td><?php echo $empresa; ?></td>
                                                            <td>
                                                                <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                <a href="verificaqualificacao?id=<?php echo $id; ?>">
                                                                    <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                            </td>
                                                        </tr>
                                                    <?php

                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-enviados" role="tabpanel" aria-labelledby="pills-enviados-tab">
                                        <h4 class="text-black py-2"><b>Formulário enviado ao cliente</b></h4>
                                        <table id="table2" class="table table-striped table-advance table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Dt</th>
                                                    <th>Usuário</th>
                                                    <th>Empresa</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require_once 'includes/dbh.inc.php';
                                                require_once 'includes/functions.inc.php';
                                                $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiStatus='Enviado';");

                                                while ($row = mysqli_fetch_array($ret)) {
                                                    $id = $row["qualiId"];
                                                    $data = $row["qualiDtChegada"];
                                                    $usuario = $row["qualiUsuario"];
                                                    $empresa = getNomeEmpresa($conn, $usuario);

                                                ?>
                                                    <tr>
                                                        <td><?php echo $id; ?></td>
                                                        <td><?php echo $data; ?></td>
                                                        <td><?php echo $usuario; ?></td>
                                                        <td><?php echo $empresa; ?></td>
                                                        <td>
                                                            <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                            <a href="verificaqualificacao?id=<?php echo $id; ?>">
                                                                <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                        </td>
                                                    </tr>
                                                <?php

                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="pills-concluidos" role="tabpanel" aria-labelledby="pills-concluidos-tab">
                                        <!--INICIO TABS INSIDE CONCLUIDO-->
                                        <!--Tabs for large devices-->
                                        <div class="d-flex justify-content-center">
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                <li class="nav-item px-3" role="presentation">
                                                    <a class="nav-link active text-tab" id="pills-qualificado-tab" data-toggle="pill" href="#pills-qualificado" role="tab" aria-controls="pills-qualificado" aria-selected="true">Qualificado</a>
                                                </li>
                                                <li class="nav-item px-3" role="presentation">
                                                    <a class="nav-link text-tab" id="pills-recusado-tab" data-toggle="pill" href="#pills-recusado" role="tab" aria-controls="pills-recusado" aria-selected="true">Recusado</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Tabs for smaller devices -->
                                        <div class="d-flex justify-content-center">
                                            <ul class="nav nav-pills mb-3" id="pills-tab-small" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link d-flex justify-content-center active text-tab" id="pills-qualificado-tab" data-toggle="pill" href="#pills-qualificado" role="tab" aria-controls="pills-qualificado" aria-selected="true"><i class="fas fa-check fa-2x"></i></a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link d-flex justify-content-center text-tab" id="pills-recusado-tab" data-toggle="pill" href="#pills-recusado" role="tab" aria-controls="pills-recusado" aria-selected="true"><i class="fas fa-times fa-2x"></i></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-qualificado" role="tabpanel" aria-labelledby="pills-qualificado-tab">
                                                <h4 class="text-black py-2"><b>Clientes Qualificados</b></h4>
                                                <table id="table3" class="table table-striped table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Dt</th>
                                                            <th>Usuário</th>
                                                            <th>Empresa</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once 'includes/dbh.inc.php';
                                                        require_once 'includes/functions.inc.php';
                                                        $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiStatus='Qualificado';");

                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            $id = $row["qualiId"];
                                                            $data = $row["qualiDtChegada"];
                                                            $usuario = $row["qualiUsuario"];
                                                            $empresa = getNomeEmpresa($conn, $usuario);

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $id; ?></td>
                                                                <td><?php echo $data; ?></td>
                                                                <td><?php echo $usuario; ?></td>
                                                                <td><?php echo $empresa; ?></td>
                                                                <td>
                                                                    <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                    <a href="verificaqualificacao?id=<?php echo $id; ?>">
                                                                        <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                                </td>
                                                            </tr>
                                                        <?php

                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="pills-recusado" role="tabpanel" aria-labelledby="pills-recusado-tab">
                                                <h4 class="text-black py-2"><b>Clientes Não Qualificados</b></h4>
                                                <table id="table4" class="table table-striped table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Dt</th>
                                                            <th>Usuário</th>
                                                            <th>Empresa</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once 'includes/dbh.inc.php';
                                                        require_once 'includes/functions.inc.php';
                                                        $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiStatus='Recusado';");

                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            $id = $row["qualiId"];
                                                            $data = $row["qualiDtChegada"];
                                                            $usuario = $row["qualiUsuario"];
                                                            $empresa = getNomeEmpresa($conn, $usuario);

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $id; ?></td>
                                                                <td><?php echo $data; ?></td>
                                                                <td><?php echo $usuario; ?></td>
                                                                <td><?php echo $empresa; ?></td>
                                                                <td>
                                                                    <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                    <a href="verificaqualificacao?id=<?php echo $id; ?>">
                                                                        <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                                </td>
                                                            </tr>
                                                        <?php

                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--FIM TABS INSIDE CONCLUIDO-->
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
                        "zeroRecords": "Nenhum documento encontrado"
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
                        "zeroRecords": "Nenhum documento encontrado"
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
                        "zeroRecords": "Nenhum documento encontrado"
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