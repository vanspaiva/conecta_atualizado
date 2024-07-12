<?php 
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
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
                <div class="row d-flex justify-content-center py-4">
                    
                    <div class="col-sm-10 justify-content-start">
                        <h2 class="text-conecta" style="font-weight: 400;">Log de <span style="font-weight: 700;">Atividades</span></h2>
                        <small class="text-muted">Log de Atividades de pedidos</small>
                        <br>
                        <hr style="border: 1px solid #ee7624">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="table" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Data/Hora</th>
                                                <th>Usuário</th>
                                                <th>N° Pedido</th>
                                                <th>Atividade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            require_once 'includes/functions.inc.php';
                                            $ret = mysqli_query($conn, "SELECT * FROM logatividadepedprop WHERE tipo = 'pedido' ORDER BY id DESC");

                                            while ($row = mysqli_fetch_array($ret)) {

                                                // //manipulação data e hora
                                                // $dthoraBD = $row['logDtHora'];
                                                // $dthoraBD = explode(" ", $dthoraBD);
                                                // $dtBD = $dthoraBD[0];
                                                // $horaBD = $dthoraBD[1];

                                                // $dt = explode("-", $dtBD);
                                                // $dt = $dt[2] . '/' . $dt[1] . '/' . $dt[0];
                                                // $hora = explode(":", $horaBD);
                                                // $hora = $hora[0] . ':' . $hora[1] . ':' . $hora[2];
                                                // $dthora = $dt . ' ' . $hora;
                                                $id = $row['id'];
                                                $tipo = $row['tipo'];
                                                $datahora = dateFormat3($row['dataAtual']) . " às " . hourFormat2($row['horaAtual']);
                                                $usuario = $row['usuario'];
                                                $numero = $row['numero'];
                                                $atividade = $row['atividade'];
                                                
                                                //grifar status alterados
                                                $palheiro = $atividade;
                                                $agulha   = 'Status Pedido Alterado para';
                                                
                                                $pos = strpos( $palheiro, $agulha );
                                                
                                                if ($pos !== false) {
                                                   $pieces = explode("para", $atividade);
                                                   $start = $pieces[0];
                                                   $end = "para <b>" . $pieces[1] . "</b>";
                                                   $atividade = $start . $end;
                                                }
                                            ?>

                                                <tr>
                                                    <td><?php echo $id; ?></td>
                                                    <td><?php echo $datahora; ?></td>
                                                    <td><span class="badge bg-primary text-white"><?php echo $usuario; ?></span></td>
                                                    <td><?php echo $numero; ?></td>
                                                    <td><?php echo $atividade; ?></td>
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