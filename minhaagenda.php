<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)'))) {
    include("php/head_index.php");
    require_once 'dashboard/counterHelpers/counterTecnicos.php';
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';
        $ret = mysqli_query($conn, "SELECT * FROM agenda");
        $cnt = 1;
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Caso editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Caso foi deletado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="container-fluid justify-content-start">
                        <div class="row d-flex justify-content-between">
                            <?php
                            if ($_SESSION["userperm"] == 'Planejador(a)') {
                            ?>
                                <h2 class="text-conecta" style="font-weight: 400;">Casos de <span style="font-weight: 700;"><?php echo $_SESSION["userfirstname"] ?></span></h2>
                            <?php
                            } else {
                            ?>
                                <h2 class="text-conecta" style="font-weight: 400;">Todos os <span style="font-weight: 700;">Casos</span></h2>
                            <?php
                            }
                            ?>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <div class="row card-body d-flex p-4 m-4">
                            <?php
                            if ($_SESSION["userperm"] == 'Planejador(a)') {
                                $tecnico = $_SESSION['useruid'];
                                $qtdarquivados = getAllArquivadosFromTecnico($conn, $tecnico);
                                $qtdconcluidos = getAllConcluidosFromTecnico($conn, $tecnico);
                                $qtdplanejando = getAllPlanejandoFromTecnico($conn, $tecnico);
                                $qtdpendente = getAllPendentesFromTecnico($conn, $tecnico);
                                $qtdafazer = getAllAfazerFromTecnico($conn, $tecnico);
                                $qtdprojProximo = getAllProjetistaProximoFromTecnico($conn, $tecnico);
                                $qtdPCP = getAllPCPFromTecnico($conn, $tecnico);
                            } else {
                                $qtdarquivados = getAllArquivados($conn);
                                $qtdconcluidos = getAllConcluidos($conn);
                                $qtdplanejando = getAllPlanejando($conn);
                                $qtdpendente = getAllPendentes($conn);
                                $qtdafazer = getAllAfazer($conn);
                                $qtdprojProximo = getAllProjetistaProximo($conn);
                                $qtdPCP = getAllPCP($conn);
                            }
                            ?>
                            <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-dark">
                                <div class="container-fluid card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <h5 class="text-white br-2">PCP</h5>
                                            <h3 class="text-white"><b><?php echo $qtdPCP; ?></b></h3>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-warning">
                                <div class="container-fluid card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <h5 style="color: #4b535a;" class="br-2">A Fazer</h5>
                                            <h3 style="color: #4b535a;"><b><?php echo $qtdafazer; ?></b></h3>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-info">
                                <div class="container-fluid card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <h5 class="text-white br-2">Planejando</h5>
                                            <h3 class="text-white"><b><?php echo $qtdplanejando; ?></b></h3>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-purple">
                                <div class="container-fluid card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <h5 class="text-white br-2">Pendente</h5>
                                            <h3 class="text-white"><b><?php echo $qtdpendente; ?></b></h3>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-success">
                                <div class="container-fluid card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <h5 class="text-white br-2">Concluídos</h5>
                                            <h3 class="text-white"><b><?php echo $qtdconcluidos; ?></b></h3>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-danger">
                                <div class="container-fluid card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <h5 class="text-white br-2">Arquivados</h5>
                                            <h3 class="text-white"><b><?php echo $qtdarquivados; ?></b></h3>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <br>
                        <div class="row">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-sm py-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="content-panel">
                                                    <div class="font-weight-bold text-warning text-uppercase mb-4 pb-4 d-flex justify-content-center">
                                                        A Fazer
                                                    </div>
                                                    <div class="container-fluid">
                                                        <?php
                                                        $status = "'CRIADO', 'Solicitação de Alteração', 'Projeto Aceito'";
                                                        if ($_SESSION["userperm"] == 'Planejador(a)') {
                                                            $casos = listarCasosFromTecnico($conn, $status, $tecnico);
                                                        } else {
                                                            $casos = listarCasos($conn, $status);
                                                        }
                                                        foreach ($casos as &$id) {
                                                            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido ='" . $id . "';");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                $numPedido = $row['pedNumPedido'];
                                                                $nomeStatus = getFullNomeFluxoPed($conn, $row['pedStatus']);
                                                                $dr = $row['pedNomeDr'];
                                                                $pac = $row['pedNomePac'];
                                                                $id = $row['pedId'];
                                                                $tipoProduto = $row['pedTipoProduto'];
                                                                $tecnico = $row['pedTecnico'];

                                                        ?>
                                                                <div class="row p-2">
                                                                    <div class="card" style="border-top: #ee7624 5px solid;">
                                                                        <div class="card-body">
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <h4 style="text-align: start; color: #6e6d6d;"><b><?php echo $tipoProduto; ?></b></h4>
                                                                                <span class="badge badge-warning"><?php echo $nomeStatus; ?></span>
                                                                            </div>

                                                                            <h5 class="text-conecta"><b>Proj. <?php echo $numPedido; ?></b></h5>
                                                                            <div class="d-flex justify-content-start align-items-center">
                                                                                <p style="line-height: 1.5rem;">
                                                                                    <?php
                                                                                    if ($_SESSION["userperm"] != 'Planejador(a)') {
                                                                                    ?>
                                                                                        <b>Técnico: <?php echo $tecnico; ?></b>
                                                                                    <?php
                                                                                    } ?>
                                                                                    <br>
                                                                                    Dr: <?php echo $dr; ?>
                                                                                    <br>
                                                                                    Pac: <?php echo $pac; ?>
                                                                                </p>

                                                                            </div>


                                                                        </div>
                                                                        <hr>
                                                                        <div class="card-footer d-flex justify-content-center">
                                                                            <a class="text-info" href="update-caso?id=<?php echo $id; ?>" target="_blank">
                                                                                editar
                                                                            </a>
                                                                        </div>

                                                                    </div>


                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm py-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="content-panel">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1 d-flex justify-content-center">
                                                        PLANEJANDO
                                                    </div>
                                                    <div class="container-fluid">
                                                        <?php
                                                        $status = "'PLAN', 'PDF', 'PROJ', 'Pausado', 'Pré Planejamento', 'Segmentação'";
                                                        if ($_SESSION["userperm"] == 'Planejador(a)') {
                                                            $casos = listarCasosFromTecnico($conn, $status, $tecnico);
                                                        } else {
                                                            $casos = listarCasos($conn, $status);
                                                        }
                                                        foreach ($casos as &$id) {
                                                            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido ='" . $id . "';");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                $numPedido = $row['pedNumPedido'];
                                                                $nomeStatus = getFullNomeFluxoPed($conn, $row['pedStatus']);
                                                                $dr = $row['pedNomeDr'];
                                                                $pac = $row['pedNomePac'];
                                                                $id = $row['pedId'];
                                                                $tipoProduto = $row['pedTipoProduto'];
                                                                $tecnico = $row['pedTecnico'];

                                                        ?>
                                                                <div class="row p-2">
                                                                    <div class="card" style="border-top: #ee7624 5px solid;">
                                                                        <div class="card-body">
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <h4 style="text-align: start; color: #6e6d6d;"><b><?php echo $tipoProduto; ?></b></h4>
                                                                                <span class="badge badge-info"><?php echo $nomeStatus; ?></span>
                                                                            </div>

                                                                            <h5 class="text-conecta"><b>Proj. <?php echo $numPedido; ?></b></h5>
                                                                            <div class="d-flex justify-content-start align-items-center">
                                                                                <p style="line-height: 1.5rem;">
                                                                                    <?php
                                                                                    if ($_SESSION["userperm"] != 'Planejador(a)') {
                                                                                    ?>
                                                                                        <b>Técnico: <?php echo $tecnico; ?></b>
                                                                                    <?php
                                                                                    } ?>
                                                                                    <br>
                                                                                    Dr: <?php echo $dr; ?>
                                                                                    <br>
                                                                                    Pac: <?php echo $pac; ?>
                                                                                </p>

                                                                            </div>


                                                                        </div>
                                                                        <hr>
                                                                        <div class="card-footer d-flex justify-content-center">
                                                                            <a class="text-info" href="update-caso?id=<?php echo $id; ?>" target="_blank">
                                                                                editar
                                                                            </a>
                                                                        </div>

                                                                    </div>


                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm py-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="content-panel">
                                                    <div class="text-xs font-weight-bold text-purple text-uppercase mb-1 d-flex justify-content-center">
                                                        Pendente
                                                    </div>
                                                    <div class="container-fluid">
                                                        <?php
                                                        $status = "'Vídeo Agendada', 'VIDEO', 'ACEITE', 'Aguardando info/Docs', 'Avaliar Projeto'";
                                                        if ($_SESSION["userperm"] == 'Planejador(a)') {
                                                            $casos = listarCasosFromTecnico($conn, $status, $tecnico);
                                                        } else {
                                                            $casos = listarCasos($conn, $status);
                                                        }
                                                        foreach ($casos as &$id) {
                                                            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido ='" . $id . "';");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                $numPedido = $row['pedNumPedido'];
                                                                $nomeStatus = getFullNomeFluxoPed($conn, $row['pedStatus']);
                                                                $dr = $row['pedNomeDr'];
                                                                $pac = $row['pedNomePac'];
                                                                $id = $row['pedId'];
                                                                $tipoProduto = $row['pedTipoProduto'];
                                                                $tecnico = $row['pedTecnico'];

                                                        ?>
                                                                <div class="row p-2">
                                                                    <div class="card" style="border-top: #ee7624 5px solid;">
                                                                        <div class="card-body">
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <h4 style="text-align: start; color: #6e6d6d;"><b><?php echo $tipoProduto; ?></b></h4>
                                                                                <span class="badge badge-purple"><?php echo $nomeStatus; ?></span>
                                                                            </div>

                                                                            <h5 class="text-conecta"><b>Proj. <?php echo $numPedido; ?></b></h5>
                                                                            <div class="d-flex justify-content-start align-items-center">
                                                                                <p style="line-height: 1.5rem;">
                                                                                    <?php
                                                                                    if ($_SESSION["userperm"] != 'Planejador(a)') {
                                                                                    ?>
                                                                                        <b>Técnico: <?php echo $tecnico; ?></b>
                                                                                    <?php
                                                                                    } ?>
                                                                                    <br>
                                                                                    Dr: <?php echo $dr; ?>
                                                                                    <br>
                                                                                    Pac: <?php echo $pac; ?>
                                                                                </p>

                                                                            </div>


                                                                        </div>
                                                                        <hr>
                                                                        <div class="card-footer d-flex justify-content-center">
                                                                            <a class="text-info" href="update-caso?id=<?php echo $id; ?>" target="_blank">
                                                                                editar
                                                                            </a>
                                                                        </div>

                                                                    </div>


                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

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
                $('#usersTable').DataTable({
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
                        "zeroRecords": "Nenhum caso encontrado"
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