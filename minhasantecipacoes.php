<?php 
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");
    $currentUser = $_SESSION["useruid"];
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">

            <div class="container-fluid">
                <div class="row d-flex justify-content-center py-4">

                    <div class="col-sm-10" id="titulo-pag">
                        <!--<h2>Minhas Solicitações</h2>-->

                        <div class="d-flex">
                            <div class="col-sm-1">
                                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                    <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                </div>
                            </div>
                            <div class="col-sm-11 pt-2 row-padding-2">
                                <div class="row px-3">
                                    <h2 style="color: #fff;">Minhas Solicitações de Antecipação</h2>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">

                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="table" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Data Envio</th>
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
                                                //cnpj da proposta deve ser igual ao cnpj do usuario
                                                if ($row['adiantUser'] == $currentUser) {
                                                    $dataBD = $row['adiantDataSolicitacao'];
                                                    $dataBD = explode(" ", $dataBD);
                                                    $dataBD = $dataBD[0];
                                                    $dataBD = explode("-", $dataBD);
                                                    $data = $dataBD[2] . '/' . $dataBD[1] . '/' . $dataBD[0];
                                            ?>

                                                    <tr>
                                                        <td><?php echo $data; ?></td>
                                                        <td><?php echo $row['adiantNPed']; ?></td>
                                                        <td><?php echo $row['adiantProduto']; ?></td>
                                                        <td style="text-align: center;"><?php
                                                            if ($row['adiantStatus'] == 'Aprovado') {
                                                                echo '<span class="badge bg-success text-white p-2" style="font-size: 1rem;">' . $row['adiantStatus'] . '</span>';
                                                            } else if ($row['adiantStatus'] == 'Reprovado') {
                                                                echo '<span class="badge bg-danger text-white p-2" style="font-size: 1rem;">' . $row['adiantStatus'] . '</span>';
                                                            } else {
                                                                echo '<span class="badge bg-secondary text-white p-2" style="font-size: 1rem;">' . $row['adiantStatus'] . '</span>';
                                                            }
                                                            ?></td>

                                                    </tr>
                                            <?php

                                                }
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