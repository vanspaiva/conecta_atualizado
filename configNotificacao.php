<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_index.php");
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
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
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-8">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class='col-sm-1 d-flex justify-content-end align-items-center' id='back'>
                                <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                            </div>
                            <div class="col-sm-11 d-flex justify-content-start align-items-center">
                                <h2 class="text-conecta" style="font-weight: 400;">Configurações de <span style="font-weight: 700;">Notificações</span></h2>
                            </div>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md ">
                                            <!-- Bancos de Dados -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Bancos de Dados</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addbanco"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retBD = mysqli_query($conn, "SELECT * FROM bancosdadosnotificacoes ORDER BY bdntfNome ASC");
                                                    while ($rowBD = mysqli_fetch_array($retBD)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowBD['bdntfNome']; ?> <a href="manageNotificacao?deletebd=<?php echo $rowBD['bdntfId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Bancos de Dados-->
                                            <div class="modal fade" id="addbanco" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Novo Bancos de Dados</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/novanotificacao.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novobanco" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Marcador -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Marcador</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addmarcador"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php

                                                    $arrayBanco = array();

                                                    $retBanco = mysqli_query($conn, "SELECT * FROM placeholdersnotificacao GROUP BY plntfBd");
                                                    while ($rowBanco = mysqli_fetch_array($retBanco)) {
                                                        array_push($arrayBanco, $rowBanco['plntfBd']);
                                                    }

                                                    foreach ($arrayBanco as &$ss) {
                                                    ?>
                                                        <!-- Aba -->
                                                        <div class="row w-100 p-1 bg-light rounded">
                                                            <div class="d-flex justify-content-between p-1 align-items-center">
                                                                <p class="px-3 text-muted"><i class="fas fa-sort-down"></i> <?php echo $ss; ?></p>
                                                            </div>
                                                            <div class="col">
                                                                <?php
                                                                $retSearchBanco = mysqli_query($conn, "SELECT * FROM placeholdersnotificacao WHERE plntfBd='$ss';");
                                                                while ($rowSearchBanco = mysqli_fetch_array($retSearchBanco)) {
                                                                ?>
                                                                    <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowSearchBanco['plntfNome']; ?> <a href="manageNotificacao?deletemarcador=<?php echo $rowSearchBanco['plntfId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                                <?php
                                                                }


                                                                ?>

                                                            </div>
                                                        </div>

                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Marcador-->
                                            <div class="modal fade" id="addmarcador" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Novo Marcador</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/novanotificacao.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="banco">Banco de Dados</label>
                                                                        <select name="banco" class="form-control" id="banco">
                                                                            <option>Selecione uma opção</option>
                                                                            <?php
                                                                            $retSlcBd = mysqli_query($conn, "SELECT * FROM bancosdadosnotificações ORDER BY bdntfNome ASC");
                                                                            while ($rowSlcBd = mysqli_fetch_array($retSlcBd)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowSlcBd['bdntfNome']; ?>"><?php echo $rowSlcBd['bdntfNome']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>

                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="variavel">Variável</label>
                                                                        <input type="text" class="form-control" id="variavel" name="variavel" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novomarcador" class="btn btn-primary">Adicionar</button>
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