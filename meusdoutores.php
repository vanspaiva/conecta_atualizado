<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Distribuidor(a)')) {
    include("php/head_tables.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
        $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "'");
        while ($rowUser = mysqli_fetch_array($retUser)) {
            $cnpj = $rowUser['usersCnpj'];
        }

        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Usuário editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Usuário foi deletado!</p></div>";
                    } else if ($_GET["error"] == "created") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Usuário novo criado!</p></div>";
                    } else if ($_GET["error"] == "notexist") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Usuário não existe</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row row-3">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="text-conecta" style="font-weight: 400;">Meus <span style="font-weight: 700;">Doutores</span></h2>
                                <p class="text-muted">Doutores salvos pela sua empresa</p>
                            </div>
                            <button class="btn btn-conecta shadow" data-toggle="modal" data-target="#addDr"><i class="fas fa-plus"></i> Doutores</button>
                        </div>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="card">

                            <div class="card-body">
                                <div class="content-panel table-responsive">
                                    <table id="usersTable" class="display table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Usuário</th>
                                                <th>Nome</th>
                                                <th>E-mail</th>
                                                <th>Telefone</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $ret = mysqli_query($conn, "SELECT * FROM caddoutoresdistribuidores WHERE drUidDistribuidor='" .  $_SESSION["useruid"] . "';");
                                            while ($row = mysqli_fetch_array($ret)) {

                                                $uid = $row['drUidDr'];

                                                $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $uid . "';");
                                                while ($rowUser = mysqli_fetch_array($retUser)) {

                                            ?>


                                                    <tr>
                                                        <td><?php echo $rowUser['usersUid']; ?></td>
                                                        <td><?php echo $rowUser['usersName']; ?></td>
                                                        <td><?php echo $rowUser['usersEmail']; ?></td>
                                                        <td><?php echo $rowUser['usersFone']; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Modal Add UF-->
                            <div class="modal fade" id="addDr" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-black">Novo Cadastro</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="prodForm" action="includes/addDrCadDist.inc.php" method="post">
                                                <div class="form-row">
                                                    <div class="form-group col-md">
                                                        <label class="text-black" for="druid">Nome Usuário</label>

                                                        <input name="druid" class="form-control" id="druid" />
                                                    </div>

                                                    <div class="form-group col-md" hidden>
                                                        <label class="text-black" for="user">Usuário Distribuidor</label>
                                                        <input type="text" class="form-control" id="user" name="user" required readonly value="<?php echo $_SESSION["useruid"]; ?>">
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" name="add" class="btn btn-primary">Adicionar</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

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
                        "zeroRecords": "Nenhum usuário encontrado"
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