<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Qualidade') || ($_SESSION["userperm"] == 'Comercial'))) {
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
                        <h2 class="text-conecta" style="font-weight: 400;">Histórico de <span style="font-weight: 700;">Aceites</span></h2>
                        <small class="text-muted">todos aceites de pedidos</small>
                        <br>
                        <hr style="border: 1px solid #ee7624">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="table" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>N° Pedido</th>
                                                <th>Data/Hora</th>
                                                <th>Doutor</th>
                                                <th>Usuário</th>
                                                <th>Atividade</th>
                                                <th>Descrição</th>
                                                <th>Projeto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            require_once 'includes/functions.inc.php';
                                            // $query = "SELECT z.*,
                                            // d.pedNumPedido AS numeroPedido,
                                            // d.pedNomeDr AS nomeDoutor,
                                            // z.przData AS data,
                                            // z.przHora AS hora,
                                            // z.przStatus AS status
                                            // FROM prazoproposta z
                                            // LEFT JOIN pedido d ON z.przNumProposta = d.pedNumPedido
                                            // WHERE przStatus = 'Projeto Aceito' 
                                            // ORDER BY przId DESC";

                                            $query = "SELECT z.*,
                                            z.przId AS id,
                                            d.pedNumPedido AS numeroPedido,
                                            d.pedNomeDr AS nomeDoutor,
                                            d.pedUserCriador AS userDoutor,
                                            l.atividade AS atividade,
                                            z.przData AS data,
                                            z.przHora AS hora,
                                            z.przStatus AS status,
                                            l.usuario AS usuario,
                                            l.*  -- Seleciona todas as colunas da tabela logatividadespedido
                                     FROM prazoproposta z
                                     LEFT JOIN pedido d ON z.przNumProposta = d.pedNumPedido
                                     LEFT JOIN logatividadepedprop l ON l.numero = z.przNumProposta
                                                                     AND l.dataAtual = z.przData
                                                                     AND l.horaAtual = z.przHora
                                                                     AND l.atividade IN ('Pedido atualizado', 'Status Pedido Alterado para <b>Projeto Aceito</b>')
                                     WHERE z.przStatus = 'Projeto Aceito' 
                                     ORDER BY z.przId DESC;";

                                            $ret = mysqli_query($conn, $query);

                                            while ($row = mysqli_fetch_array($ret)) {
                                                $idref = $row["id"];

                                                $numeroPedido = $row['numeroPedido'];
                                                $nomeDoutor = $row['nomeDoutor'];
                                                $status = $row['status'];
                                                $hora = $row['hora'];
                                                if ($hora == null) {
                                                    $hora = " (horario indefinido)";
                                                } else {
                                                    $hora = " às " . $hora;
                                                }
                                                $data = dateFormat3($row["data"]);

                                                $datahora = $data . $hora;
                                                $usuario = $row["usuario"];

                                                $dataUser = getAllDataFromRep($conn, $usuario);
                                                $perm = $dataUser["usersPerm"];
                                                if (($perm == '2PLJ') || ($perm == '1ADM')) {
                                                    $warning = true;
                                                } else {
                                                    $warning = false;
                                                }
                                                $userDoutor = $row["userDoutor"];
                                                $atividade = $row["atividade"];
                                                
                                                $urlPedido = getURLFromPedido($conn, $numeroPedido);

                                            ?>

                                                <tr>
                                                    <td><?php echo $idref; ?></td>
                                                    <td><?php echo $numeroPedido; ?></td>
                                                    <td><?php echo $datahora; ?></td>
                                                    <td><?php echo $nomeDoutor . " (" . $userDoutor . ") "; ?></td>
                                                    <td class="<?php if ($warning) {
                                                                    echo " text-danger ";
                                                                } ?>"><?php echo $usuario; ?></td>
                                                    <td><?php echo $status; ?></td>
                                                    <td><?php echo $atividade; ?></td>
                                                    <td><a href="<?php echo $urlPedido; ?>" target="_blank"><?php echo $urlPedido; ?></a></td>
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