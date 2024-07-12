<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_tables.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
        $ret = mysqli_query($conn, "SELECT * FROM forum");
        $cnt = 1;
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Questão editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Questão foi deletada!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="d-flex">
                            <h2 class="text-conecta" style="font-weight: 400;">Gerenciamento <span style="font-weight: 700;">SAC Interno</span></h2>
                        </div>
                        <br>
                        <hr style="border: 1px solid #ee7624 !important;">
                        
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="content-panel table-responsive">
                                    <table id="usersTable" class="display table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Data Envio</th>
                                                <th>Status</th>
                                                <th>Título</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($ret)) {

                                                $timestamp = $row['faqDataCriacao'];
                                                $timestamp = explode(" ", $timestamp);
                                                $timestampData = $timestamp[0];
                                                $timestampHora = $timestamp[1];

                                                $timestampData = explode("-", $timestampData);
                                                $data = $timestampData[2] . '/' . $timestampData[1] . '/' . $timestampData[0];

                                                $timestampHora = explode(":", $timestampHora);
                                                $hora = $timestampHora[0] . ':' . $timestampHora[1];

                                                $tipo = $row['faqTipoTexto'];
                                            ?>

                                                <tr>
                                                    <td>
                                                        <?php if ($tipo == "Dúvida") { ?>
                                                            <span class="m-1 px-2 badge rounded-pill bg-warning text-dark"><?php echo $tipo; ?></span>
                                                        <?php } ?>
                                                        <?php if ($tipo == "Melhoria") { ?>
                                                            <span class="m-1 px-2 badge rounded-pill bg-info text-white"><?php echo $tipo; ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $data; ?></td>
                                                    <td <?php if (($row['faqStatus'] == "Respondido") || ($row['faqStatus'] == "Resolvido")) {
                                                            echo ' class="m-1 px-2 badge rounded-pill bg-success text-white"';
                                                        } ?>><?php echo $row['faqStatus']; ?></td>
                                                    <td><?php echo $row['faqAssuntoPrincipal']; ?></td>
                                                    <td>
                                                        <?php if ($tipo == "Dúvida") { ?>
                                                            <a href="manageForum?id=<?php echo $row['faqId']; ?>&action=respondido">
                                                                <button class="btn text-success btn-xs"><i class="fas fa-check"></i></button></a>
                                                        <?php } ?>

                                                        <?php if ($tipo == "Melhoria") { ?>
                                                            <a href="manageForum?id=<?php echo $row['faqId']; ?>&action=resolvido">
                                                                <button class="btn text-success btn-xs"><i class="fas fa-check"></i></button></a>
                                                            <a href="manageForum?id=<?php echo $row['faqId']; ?>&action=fazer">
                                                                <button class="btn text-primary btn-xs"><i class="fas fa-calendar-plus"></i></button></a>
                                                        <?php } ?>

                                                        <a href="manageForum?id=<?php echo $row['faqId']; ?>&action=delete">
                                                            <button class="btn text-danger btn-xs" onClick="return confirm('Você realmente deseja apagar essa questão?');"><i class="far fa-trash-alt"></i></button></a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer"></div>
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
                    },
                    "order": [
                        [1, "desc"]
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