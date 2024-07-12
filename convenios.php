<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
    include("php/head_index.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        require_once 'includes/dbh.inc.php';
        $ret = mysqli_query($conn, "SELECT * FROM convenios ORDER BY convName asc");
        $cnt = 1;
        ?>

        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                    } else if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Convênio cadastrado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Convênio editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Convênio foi deletado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-10 justify-content-start">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Lista de <span style="font-weight: 700;">Convênios</span></h2>
                            <button class="btn btn-conecta" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Convênio</button>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="myTable" class="display table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nome</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php


                                            while ($row = mysqli_fetch_array($ret)) {

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['convId'];  ?></td>
                                                    <td><?php echo $row['convName'];  ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="editConv?id=<?php echo $row['convId']; ?>">
                                                                <button class="btn btn-info m-1"><i class="far fa-edit"></i></button></a>
                                                            <a href="manageConv?id=<?php echo $row['convId']; ?>">
                                                                <button class="btn btn-danger m-1" onClick="return confirm('Você realmente deseja apagar esse item?');"><i class="far fa-trash-alt"></i></button></a>
                                                        </div>
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Convênio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="prodForm" action="includes/convenio.inc.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" style="text-transform:uppercase" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" name="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script>
            function populateModal(element) {
                console.log(element);
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
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
                        "zeroRecords": "Nenhum item encontrado"
                    },
                    "order": [
                        [1, "asc"]
                    ]
                });
            });
        </script>
        <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>