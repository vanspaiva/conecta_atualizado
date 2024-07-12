<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador'))) {
    include("php/head_index.php");
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
                <div class="row row-3">
                    <div class="col-sm justify-content-start" id="titulo-pag">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Gerenciamento de <span style="font-weight: 700;">Técnicos</span></h2>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <!-- Responsáveis pela Video -->
                                    <div class="row w-100 p-3 bg-light rounded my-4">
                                        <div class="d-flex justify-content-between p-1 align-items-center">
                                            <h5 class="text-black">Técnicos Responsáveis</h5>
                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#addresponsavel"><i class="far fa-plus-square"></i> novo</button>
                                        </div>
                                        <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                        <div class="col p-1">
                                            <?php
                                            $retResponsavel = mysqli_query($conn, "SELECT * FROM responsavelagenda r INNER JOIN users u ON r.responsavelagendaNome = u.usersUid ORDER BY `u`.`usersName` ASC;");
                                            while ($rowResponsavel = mysqli_fetch_array($retResponsavel)) {
                                                $firstName = getPrimeiroNome($rowResponsavel['usersName']);

                                            ?>
                                                <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $firstName; ?> <a href="manageConfigAgenda?deleteresponsavel=<?php echo $rowResponsavel['responsavelagendaId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <!-- Modal Add Responsáveis pela Video-->
                                    <div class="modal fade" id="addresponsavel" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-black">Novo Responsável</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="prodForm" action="includes/configagenda.inc.php" method="post">
                                                        <div class="form-row">
                                                            <div class="form-group col-md">
                                                                <label class="text-black" for="nome">Uid do Técnico</label>
                                                                <input type="text" class="form-control" id="nome" name="nome" required>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" name="novoresponsavel" class="btn btn-primary">Adicionar</button>
                                                        </div>
                                                    </form>
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