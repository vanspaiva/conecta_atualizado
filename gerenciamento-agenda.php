<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)'))) {
    include("php/head_index.php");
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
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
                            <h2 class="text-conecta" style="font-weight: 400;">Gerenciamento de <span style="font-weight: 700;">Agenda</span></h2>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="d-flex justify-content-between">
                                        <div class="nav flex-column nav-pills ml-1 mr-2 p-2" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="max-width: 200px;">
                                            <a class="nav-link-agenda active pb-2 mb-3" style="font-size: 1.0rem; font-weight: bold; text-decoration: none;" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true" onclick="show(this)">Agenda</a>
                                            <a class="nav-link-agenda pb-2 mb-3" style="font-size: 1.0rem; font-weight: bold; text-decoration: none;" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false" onclick="show(this)">Configurações</a>
                                        </div>


                                        <div class="tab-content p-2 w-100" id="v-pills-tabContent" style="border-left: 2px solid silver;">
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                <h3 class="px-3 pb-2" style="color: silver;">Agenda</h3>
                                                <div class="container-fluid">
                                                    <div class="row w-100">
                                                        <?php
                                                        $retAgenda = mysqli_query($conn, "SELECT * FROM agenda WHERE NOT agdStatus='VAZIO' ");
                                                        while ($rowAgenda = mysqli_fetch_array($retAgenda)) {
                                                            $dataBD = $rowAgenda['agdData'];
                                                            $dataBD = explode("-", $dataBD);
                                                            $dataEscolhida = $dataBD[2] . '/' . $dataBD[1] . '/' . $dataBD[0];
                                                        ?>
                                                            <div class="col-4  col-sm-4 p-2 bg-light rounded my-4 mx-1 flex-fill">
                                                                <h4 class="text-black"><?php echo $rowAgenda['agdTipo']; ?> <?php if ($rowAgenda['agdNumPedRef'] != null) {
                                                                                                                                echo ' - ' . $rowAgenda['agdNumPedRef'];
                                                                                                                            } ?></h4>
                                                                <hr style="border-bottom:1px solid #a1a1a1;">
                                                                <p>
                                                                    <span class="text-black"><i class="far fa-calendar-alt"></i> <b> Data:</b> <?php echo $dataEscolhida; ?></span>
                                                                </p>
                                                                <p>
                                                                    <span class="text-black"><i class="far fa-clock"></i> <b> Hora:</b> <?php echo $rowAgenda['agdHora']; ?></span>
                                                                </p>

                                                                <p>Dr: <?php echo $rowAgenda['agdNomeDr']; ?></p>
                                                                <p>Pac: <?php echo $rowAgenda['agdNomPac']; ?></p>
                                                                <p>Produto: <?php echo $rowAgenda['agdProd']; ?></p>

                                                                <?php if ($rowAgenda['agdResponsavel'] != null) { ?>
                                                                    <div class="d-flex justify-content-start align-items-center">
                                                                        <p style="font-weight: bold; font-size: 1rem;">Responsável:</p>
                                                                        <p class="mx-2"><?php echo $rowAgenda['agdResponsavel']; ?></p>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php if ($rowAgenda['agdStatusVideo'] != null) { ?>
                                                                    <div class="d-flex justify-content-start align-items-center">
                                                                        <span class="mx-2 badge bg-primary my-1" style="font-size: 1rem;"> <?php echo $rowAgenda['agdStatusVideo']; ?></span>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>

                                                                <hr style="border-bottom:1px solid #a1a1a1;">
                                                                <a href="updateagenda?id=<?php echo $rowAgenda['agdId']; ?>" class="d-flex justify-content-center"><i class="far fa-edit"></i>Editar</a>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                <h3 class="pb-2" style="color: silver;">Configurações</h3>
                                                <div class="container">
                                                    <!-- Status -->
                                                    <div class="row w-100 p-3 bg-light rounded my-4">
                                                        <div class="d-flex justify-content-between p-1 align-items-center">
                                                            <h5 class="text-black">Status da Vídeo</h5>
                                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#addstatus"><i class="far fa-plus-square"></i> novo</button>
                                                        </div>
                                                        <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                        <div class="col p-1">
                                                            <?php
                                                            $retStatus = mysqli_query($conn, "SELECT * FROM statusagenda ORDER BY statusagendaNome ASC");
                                                            while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                            ?>
                                                                <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowStatus['statusagendaNome']; ?> <a href="manageConfigAgenda?deletestatus=<?php echo $rowStatus['statusagendaId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>

                                                    <!-- Modal Add Status-->
                                                    <div class="modal fade" id="addstatus" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-black">Novo Status</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="prodForm" action="includes/configagenda.inc.php" method="post">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md">
                                                                                <label class="text-black" for="nome">Nome</label>
                                                                                <input type="text" class="form-control" id="nome" name="nome" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" name="novostatus" class="btn btn-primary">Adicionar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Feedbacks Pós Video -->
                                                    <div class="row w-100 p-3 bg-light rounded my-4">
                                                        <div class="d-flex justify-content-between p-1 align-items-center">
                                                            <h5 class="text-black">Feedbacks Pós Video</h5>
                                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#addfeedback"><i class="far fa-plus-square"></i> novo</button>
                                                        </div>
                                                        <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                        <div class="col p-1">
                                                            <?php
                                                            $retFeedback = mysqli_query($conn, "SELECT * FROM feedbackagenda ORDER BY feedbackagendaNome ASC");
                                                            while ($rowFeedback = mysqli_fetch_array($retFeedback)) {
                                                            ?>
                                                                <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowFeedback['feedbackagendaNome']; ?> <a href="manageConfigAgenda?deletefeedback=<?php echo $rowFeedback['feedbackagendaId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>

                                                    <!-- Modal Add Feedbacks Pós Video-->
                                                    <div class="modal fade" id="addfeedback" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-black">Novo Feedbacks</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="prodForm" action="includes/configagenda.inc.php" method="post">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md">
                                                                                <label class="text-black" for="nome">Nome</label>
                                                                                <input type="text" class="form-control" id="nome" name="nome" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" name="novofeedback" class="btn btn-primary">Adicionar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Responsáveis pela Video -->
                                                    <div class="row w-100 p-3 bg-light rounded my-4">
                                                        <div class="d-flex justify-content-between p-1 align-items-center">
                                                            <h5 class="text-black">Responsáveis pela Video</h5>
                                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#addresponsavel"><i class="far fa-plus-square"></i> novo</button>
                                                        </div>
                                                        <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                        <div class="col p-1">
                                                            <?php
                                                            $retResponsavel = mysqli_query($conn, "SELECT * FROM responsavelagenda ORDER BY responsavelagendaNome ASC");
                                                            while ($rowResponsavel = mysqli_fetch_array($retResponsavel)) {
                                                            ?>
                                                                <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowResponsavel['responsavelagendaNome']; ?> <a href="manageConfigAgenda?deleteresponsavel=<?php echo $rowResponsavel['responsavelagendaId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
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
                                                                                <label class="text-black" for="nome">Nome</label>
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

                                                    <!-- Produtos -->
                                                    <div class="row w-100 p-3 bg-light rounded my-4">
                                                        <div class="d-flex justify-content-between p-1 align-items-center">
                                                            <h5 class="text-black">Produtos</h5>
                                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#addproduto"><i class="far fa-plus-square"></i> novo</button>
                                                        </div>
                                                        <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                        <div class="col p-1">
                                                            <?php
                                                            $retProduto = mysqli_query($conn, "SELECT * FROM produtoagenda ORDER BY produtoagendaNome ASC");
                                                            while ($rowProduto = mysqli_fetch_array($retProduto)) {
                                                            ?>
                                                                <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowProduto['produtoagendaNome']; ?> <a href="manageConfigAgenda?deleteproduto=<?php echo $rowProduto['produtoagendaId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>

                                                    <!-- Modal Add Produtos-->
                                                    <div class="modal fade" id="addproduto" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-black">Novo Produto</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="prodForm" action="includes/configagenda.inc.php" method="post">
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

                                                    <!-- Horários Disponíveis -->
                                                    <div class="row w-100 p-3 bg-light rounded my-4">
                                                        <div class="d-flex justify-content-between p-1 align-items-center">
                                                            <h5 class="text-black">Horários Disponíveis</h5>
                                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#addhorario"><i class="far fa-plus-square"></i> novo</button>
                                                        </div>
                                                        <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                        <div class="col p-1">
                                                            <?php
                                                            $retHorario = mysqli_query($conn, "SELECT * FROM horasdisponiveisagenda ORDER BY hrCodigo ASC");
                                                            while ($rowHorario = mysqli_fetch_array($retHorario)) {
                                                            ?>
                                                                <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo '(' . $rowHorario['hrCodigo'] . ') ' . $rowHorario['hrHorario']; ?> <a href="manageConfigAgenda?deletehorario=<?php echo $rowHorario['hrId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>



                                                    <!-- Modal Add Horários Disponíveis-->
                                                    <div class="modal fade" id="addhorario" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-black">Novo Horário</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="prodForm" action="includes/configagenda.inc.php" method="post">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md">
                                                                                <label class="text-black" for="cdg">Código</label>
                                                                                <input type="text" class="form-control" id="cdg" name="cdg" required>
                                                                            </div>
                                                                            <div class="form-group col-md">
                                                                                <label class="text-black" for="horario">Horário</label>
                                                                                <input type="text" class="form-control" id="horario" name="horario" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" name="novohorario" class="btn btn-primary">Adicionar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

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