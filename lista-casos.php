<?php 
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)'))) {
    include("php/head_tables.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
        $ret = mysqli_query($conn, "SELECT * FROM pedido");
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
                <div class="row row-3">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="d-flex justify-content-between">
                            <h2>Casos (Pedidos)</h2>
                        </div>
                        <br>
                        <div class="card">

                            <div class="card-body">
                                <div class="content-panel table-responsive">
                                    <table id="usersTable" class="display table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Ped ID</th>
                                                <th class="d-flex justify-content-center">Situação</th>
                                                <th>Numero Calisto</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>Especificação</th>
                                                <th>Fluxo</th>
                                                <th>Data Criação</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php


                                            while ($row = mysqli_fetch_array($ret)) {
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
                                            ?>

                                                <tr>
                                                    <td><?php echo $row['pedId'];; ?></td>
                                                    <td class="d-flex justify-content-center"><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>
                                                    <td><?php echo $row['pedNumPedido']; ?></td>
                                                    <td><?php echo $row['pedNomeDr']; ?></td>
                                                    <td><?php echo $row['pedNomePac']; ?></td>
                                                    <td><?php echo $row['pedTipoProduto']; ?></td>
                                                    <td><?php echo $row['pedStatus']; ?></td>
                                                    <td><?php echo $data; ?></td>
                                                    <td>

                                                        <a href="update-caso?id=<?php echo $row['pedId']; ?>">
                                                            <button class="btn btn-primary btn-xs"><i class="far fa-edit"></i></button></a>
                                                        <?php
                                                        if ($_SESSION["userperm"] == 'Administrador') {
                                                        ?>
                                                            <a href="manageCasos?id=<?php echo $row['pedId']; ?>">
                                                                <button class="btn btn-danger btn-xs" onClick="return confirm('Você realmente deseja apagar esse pedido?');"><i class="far fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                $cnt = $cnt + 1;
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>

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