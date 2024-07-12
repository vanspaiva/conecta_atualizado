<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Comercial')) || ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Representante')) {
    include("php/head_tables.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">

            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10" id="titulo-pag">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start">
                                <h2 class="text-conecta" style="font-weight: 400;">Pedidos de <span style="font-weight: 700;">Antecipação</span></h2>
                            </div>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="table" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Data Envio</th>
                                                <th>Solicitante</th>
                                                <th>Nº Pedido</th>
                                                <th>Produto</th>
                                                <th style="text-align: center;">Status</th>
                                            </tr>
                                        </thead>
                                        <?php

                                        ?>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            $ret = mysqli_query($conn, "SELECT * FROM adiantamentos");

                                            while ($row = mysqli_fetch_array($ret)) {

                                                $id = $row['adiantId'];

                                                $dataBD = $row['adiantDataSolicitacao'];
                                                $dataBD = explode(" ", $dataBD);
                                                $dataBD = $dataBD[0];
                                                $dataBD = explode("-", $dataBD);
                                                $data = $dataBD[2] . '/' . $dataBD[1] . '/' . $dataBD[0];

                                                //Status
                                                $status = $row['adiantStatus'];
                                                if (($status == 'Em Análise')) {
                                                    $btn = '<a href="changestatus?id=' . $id . '&st=aprov"> <button class="btn btn-warning btn-xs"><i class="fas fa-check"></i></button></a>';
                                                    $btn = $btn . '<a href="changestatus?id=' . $id . '&st=reprov"> <button class="btn btn-warning btn-xs"><i class="fas fa-times"></i></button></a>';
                                                } else if ($status == 'Aprovado') {
                                                    $btn = '<button class="btn text-success btn-xs"><i class="fas fa-check"></i></button>';
                                                } else if ($status == 'Reprovado') {
                                                    $btn = '<button class="btn text-danger btn-xs"><i class="fas fa-times"></i></button>';
                                                }
                                            ?>

                                                <tr>
                                                    <td><?php echo $data; ?></td>
                                                    <td><?php echo $row['adiantUser']; ?></td>
                                                    <td><?php echo $row['adiantNPed']; ?></td>
                                                    <td><?php echo $row['adiantProduto']; ?></td>
                                                    <td style="text-align: center;"><?php echo $btn; ?></td>

                                                </tr>
                                            <?php
                                            }
                                            ?>

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
                $('#table').DataTable({
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