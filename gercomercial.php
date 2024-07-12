<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Comercial')) {
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
                    <div class="col-sm-8 justify-content-start w-100" id="titulo-pag">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Configurações de <span style="font-weight: 700;">Propostas</span></h2>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md ">
                                            <!-- Status Comercial -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Status Comercial</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addstatuscomercial"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retComercial = mysqli_query($conn, "SELECT * FROM statuscomercial ORDER BY stcomIndiceFluxo ASC");
                                                    while ($rowComercial = mysqli_fetch_array($retComercial)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo '(' . $rowComercial['stcomIndiceFluxo'] . ') ' . $rowComercial['stcomNome']; ?> <a href="manageConfigComercial?deletestcom=<?php echo $rowComercial['stcomId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Status Comercial-->
                                            <div class="modal fade" id="addstatuscomercial" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Nova Especialidade</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcomercial.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="indexFluxo">Nº Fluxo</label>
                                                                        <input type="number" class="form-control" id="indexFluxo" name="indexFluxo" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novostcom" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Planejamento -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Status Planejamento</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addstatusplanejamento"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retPlanejamento = mysqli_query($conn, "SELECT * FROM statusplanejamento ORDER BY stplanIndiceFluxo ASC");
                                                    while ($rowPlanejamento = mysqli_fetch_array($retPlanejamento)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo '(' . $rowPlanejamento['stplanIndiceFluxo'] . ') ' . $rowPlanejamento['stplanNome']; ?> <a href="manageConfigComercial?deletestplan=<?php echo $rowPlanejamento['stplanId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Status Planejamento-->
                                            <div class="modal fade" id="addstatusplanejamento" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Nova Especialidade</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcomercial.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="indexFluxo">Nº Fluxo</label>
                                                                        <input type="number" class="form-control" id="indexFluxo" name="indexFluxo" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novostplan" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Representante -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Status Representante</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addstatusrepresentante"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retRepresentante = mysqli_query($conn, "SELECT * FROM statusrepresentante ORDER BY stplanIndiceFluxo ASC");
                                                    while ($rowRepresentante = mysqli_fetch_array($retRepresentante)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo '(' . $rowRepresentante['stplanIndiceFluxo'] . ') ' . $rowRepresentante['stplanNome']; ?> <a href="manageConfigComercial?deletestrep=<?php echo $rowRepresentante['stplanId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Status Representante-->
                                            <div class="modal fade" id="addstatusrepresentante" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Nova Especialidade</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcomercial.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="indexFluxo">Nº Fluxo</label>
                                                                        <input type="number" class="form-control" id="indexFluxo" name="indexFluxo" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novostrep" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Fluxo Pedido -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Status Fluxo Pedido</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addfluxoplanejamento"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retFlxPlanejamento = mysqli_query($conn, "SELECT * FROM fluxopedido ORDER BY flxId ASC");
                                                    while ($rowFlxPlanejamento = mysqli_fetch_array($retFlxPlanejamento)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowFlxPlanejamento['flxNome']; ?> <a href="manageConfigComercial?deletefluxo=<?php echo $rowFlxPlanejamento['flxId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Status Fluxo Pedido -->
                                            <div class="modal fade" id="addfluxoplanejamento" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Nova Fluxo Pedido</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcomercial.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novofluxo" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Tipos de Produtos -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Tipos de Produtos</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addprodutosproposta"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retTiposProdutos = mysqli_query($conn, "SELECT * FROM produtosproposta ORDER BY prodpropNome ASC");
                                                    while ($rowTiposProdutos = mysqli_fetch_array($retTiposProdutos)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowTiposProdutos['prodpropNome']; ?> <a href="manageConfigComercial?deleteprod=<?php echo $rowTiposProdutos['prodpropId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Status Tipos de Produtos-->
                                            <div class="modal fade" id="addprodutosproposta" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Novo Tipo de Produto</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcomercial.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novoproduto" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Adiantamento -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Adiantamento</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addstadiantamento"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retAdiantamento = mysqli_query($conn, "SELECT * FROM statusadiantamento ORDER BY stadiantNome ASC");
                                                    while ($rowAdiantamento = mysqli_fetch_array($retAdiantamento)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowAdiantamento['stadiantNome']; ?> <a href="manageConfigComercial?deleteadiant=<?php echo $rowAdiantamento['stadiantId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Status Adiantamento-->
                                            <div class="modal fade" id="addstadiantamento" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Novo Adiantamento</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcomercial.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novoadiant" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                        </div>



                                    </div>

                                    <script>
                                        function show(elem) {
                                            elem = elem.text;
                                            var tabAgenda = document.getElementById("v-pills-home");
                                            var tabConfig = document.getElementById("v-pills-settings");
                                            var linkAgenda = document.getElementById("v-pills-home-tab");
                                            var linkConfig = document.getElementById("v-pills-settings-tab");

                                            switch (elem) {
                                                case 'Agenda':
                                                    tabAgenda.classList.add('show', 'active');
                                                    tabConfig.classList.remove('show', 'active');
                                                    linkAgenda.classList.add('active');
                                                    linkConfig.classList.remove('active');
                                                    break;

                                                case 'Configurações':
                                                    tabAgenda.classList.remove('show', 'active');
                                                    tabConfig.classList.add('show', 'active');
                                                    linkAgenda.classList.remove('active');
                                                    linkConfig.classList.add('active');
                                                    break;

                                                default:
                                                    console.log('erro');
                                            }


                                        }
                                    </script>

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