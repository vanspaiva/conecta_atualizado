<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Marketing'))) {
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
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Item foi deletado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row row-3">
                    <div class="col-sm justify-content-start" id="titulo-pag">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Cadastro de <span style="font-weight: 700;">Mídias</span></h2>
                        </div>
                        <br>
                        <hr style="border-color: #ee7624;">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="d-flex justify-content-between">
                                        <div class="nav flex-column nav-pills ml-1 mr-2 p-2" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="max-width: 200px; ">
                                            <a class="nav-link-agenda active pb-2 mb-3" style="font-size: 1.0rem; font-weight: bold; text-decoration: none; color: silver;" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true" onclick="show(this)">Lista</a>
                                            <a class="nav-link-agenda pb-2 mb-3" style="font-size: 1.0rem; font-weight: bold; text-decoration: none; color: silver;" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false" onclick="show(this)">Configurações</a>
                                        </div>


                                        <div class="tab-content p-2 w-100" id="v-pills-tabContent" style="border-left: 2px solid silver;">
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-sm justify-content-center" id="titulo-pag">
                                                            <div class="d-flex justify-content-between">
                                                                <h3 class="px-3 pb-2" style="color: silver;">Lista de Mídias</h3>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#novamidia"><i class="fas fa-plus"></i> Nova Mídia</button>
                                                            </div>
                                                            <br>

                                                            <div class="content-panel">
                                                                <table id="tableMaterial" class="display table table-striped table-advance table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ABA</th>
                                                                            <th>Sessão</th>
                                                                            <th>Título</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $ret = mysqli_query($conn, "SELECT * FROM materiaismidias");
                                                                        while ($row = mysqli_fetch_array($ret)) {

                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $row['mtmAba'];  ?></td>
                                                                                <td><?php echo $row['mtmSessao'];  ?></td>
                                                                                <td><?php echo $row['mtmTitulo']; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <button class="btn btn-info m-1" data-toggle="modal" data-target="#updatemidia" onclick="populate(<?php echo $row['mtmId']; ?>)"><i class="far fa-edit"></i></button>
                                                                                        <a href="manageConfigMkt?deletematerial=<?php echo $row['mtmId']; ?>">
                                                                                            <button class="btn btn-danger m-1" onClick="return confirm('Você realmente deseja apagar esse conteúdo?');"><i class="far fa-trash-alt"></i></button></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php

                                                                        }

                                                                        ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- Modal Add Material Midia -->
                                                            <div class="modal fade" id="novamidia" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title text-black">Nova Mídia</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="prodForm" action="includes/novomaterial.inc.php" method="post">
                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md">
                                                                                        <label class="form-label text-black" for="abaMaterial">ABA</label>
                                                                                        <select name="abaMaterial" class="form-control" id="abaMaterial" onchange="checkAba(this)">
                                                                                            <option>Selecione uma opção</option>
                                                                                            <?php
                                                                                            $retSlcAba = mysqli_query($conn, "SELECT * FROM abasmidias ORDER BY abmNome ASC");
                                                                                            while ($rowSlcAba = mysqli_fetch_array($retSlcAba)) {
                                                                                            ?>
                                                                                                <option value="<?php echo $rowSlcAba['abmNome']; ?>"><?php echo $rowSlcAba['abmNome']; ?></option>
                                                                                            <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div class="form-group col-md">
                                                                                        <label class="form-label text-black" for="sessaoMaterial">Sessão</label>
                                                                                        <select name="sessaoMaterial" class="form-control" id="sessaoMaterial" disabled>
                                                                                            <option>Selecione uma opção</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md">
                                                                                        <label class="text-black" for="titulo">Título</label>
                                                                                        <input type="text" class="form-control" id="titulo" name="titulo" maxlength="100" required>
                                                                                    </div>

                                                                                    <div class="form-group col-md">
                                                                                        <label class="text-black" for="descricao">Descrição</label>
                                                                                        <input type="text" class="form-control" id="descricao" name="descricao" maxlength="100" required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md">
                                                                                        <label class="text-black" for="link">Link</label>
                                                                                        <input type="text" class="form-control" id="link" name="link" required>
                                                                                    </div>

                                                                                    <div class="form-group col-md">
                                                                                        <label class="text-black" for="relevancia">Relevância</label>
                                                                                        <input type="range" class="form-range" id="relevancia" name="relevancia" min="1" max="5" required>
                                                                                        <small class="text-muted">(de 1 à 5)</small>
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

                                                            <!-- Modal Update Material Midia -->
                                                            <div class="modal fade" id="updatemidia" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title text-black">Atualizar Mídia</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="prodForm" action="includes/novomaterial.inc.php" method="post">

                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md">
                                                                                        <label class="form-label text-black" for="idMaterial">ID</label>
                                                                                        <input type="number" class="form-control" id="idMaterial" name="idMaterial" required readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md">
                                                                                        <label class="form-label text-black" for="abaMaterialUpd">ABA</label>
                                                                                        <input type="text" class="form-control" id="abaMaterialUpd" name="abaMaterialUpd" required readonly>
                                                                                    </div>

                                                                                    <div class="form-group col-md">
                                                                                        <label class="form-label text-black" for="sessaoMaterialUpd">Sessão</label>
                                                                                        <input type="text" class="form-control" id="sessaoMaterialUpd" name="sessaoMaterialUpd" required readonly>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md">
                                                                                        <label class="text-black" for="tituloUpd">Título</label>
                                                                                        <input type="text" class="form-control" id="tituloUpd" name="tituloUpd" maxlength="100" required>
                                                                                    </div>

                                                                                    <div class="form-group col-md">
                                                                                        <label class="text-black" for="descricaoUpd">Descrição</label>
                                                                                        <input type="text" class="form-control" id="descricaoUpd" name="descricaoUpd" maxlength="100" required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md">
                                                                                        <label class="text-black" for="linkUpd">Link</label>
                                                                                        <input type="text" class="form-control" id="linkUpd" name="linkUpd" required>
                                                                                    </div>

                                                                                    <div class="form-group col-md">
                                                                                        <label class="text-black" for="relevanciaUpd">Relevância</label>
                                                                                        <input type="range" class="form-range" id="relevanciaUpd" name="relevanciaUpd" min="1" max="5" required>
                                                                                        <small class="text-muted">(de 1 à 5)</small>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="d-flex justify-content-end">
                                                                                    <button type="update" name="update" class="btn btn-primary">Atualizar</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
                                                            <script>
                                                                function checkAba(elem) {
                                                                    cleanSelect();

                                                                    //Recuperar o valor do campo
                                                                    var pesquisa = elem.value;

                                                                    //Verificar se há algo digitado
                                                                    if (pesquisa != '') {
                                                                        var dados = {
                                                                            nome: pesquisa
                                                                        }
                                                                        $.post('proc_pesq_abamidia.php', dados, function(retorna) {
                                                                            //Mostra dentro da ul os resultado obtidos 
                                                                            var array = retorna.split(',');

                                                                            var selectList = document.getElementById("sessaoMaterial");

                                                                            var simpleOpt = document.createElement("option");
                                                                            simpleOpt.text = 'Selecione uma opção';
                                                                            selectList.appendChild(simpleOpt);

                                                                            for (var i = 0; i < array.length; i++) {
                                                                                var option = document.createElement("option");
                                                                                option.value = array[i];
                                                                                option.text = array[i];
                                                                                selectList.appendChild(option);
                                                                            }

                                                                            document.getElementById("sessaoMaterial").disabled = false;
                                                                        });
                                                                    }
                                                                }

                                                                function cleanSelect() {
                                                                    var selectList = document.getElementById("sessaoMaterial");
                                                                    var i, L = selectList.options.length - 1;
                                                                    for (i = L; i >= 0; i--) {
                                                                        selectList.remove(i);
                                                                    }

                                                                }

                                                                function populate(id) {
                                                                    //Recuperar o valor do campo
                                                                    var pesquisa = id;

                                                                    //Verificar se há algo digitado
                                                                    if (pesquisa != '') {
                                                                        var dados = {
                                                                            id: pesquisa
                                                                        }
                                                                        $.post('proc_pesq_idmidia.php', dados, function(retorna) {
                                                                            //Mostra dentro da ul os resultado obtidos 
                                                                            var array = retorna.split(',');

                                                                            var id = array[0];
                                                                            var aba = array[1];
                                                                            var sessao = array[2];
                                                                            var titulo = array[3];
                                                                            var descricao = array[4];
                                                                            var link = array[5];
                                                                            var relevancia = array[6];


                                                                            document.getElementById('idMaterial').value = id;
                                                                            document.getElementById('abaMaterialUpd').value = aba;
                                                                            document.getElementById('sessaoMaterialUpd').value = sessao;
                                                                            document.getElementById('tituloUpd').value = titulo;
                                                                            document.getElementById('descricaoUpd').value = descricao;
                                                                            document.getElementById('linkUpd').value = link;
                                                                            document.getElementById('relevanciaUpd').value = relevancia;

                                                                            console.log(retorna);
                                                                        });
                                                                    }
                                                                }
                                                            </script>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                <h3 class="pb-2" style="color: silver;">Configurações</h3>
                                                <div class="container">
                                                    <!-- Abas Mídias -->
                                                    <div class="row w-100 p-3 bg-light rounded my-4">
                                                        <div class="d-flex justify-content-between p-1 align-items-center">
                                                            <h5 class="text-black">Abas Mídias</h5>
                                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#addaba"><i class="far fa-plus-square"></i> novo</button>
                                                        </div>
                                                        <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                        <div class="col p-1">
                                                            <?php
                                                            $retAba = mysqli_query($conn, "SELECT * FROM abasmidias ORDER BY abmNome ASC");
                                                            while ($rowAba = mysqli_fetch_array($retAba)) {
                                                            ?>
                                                                <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowAba['abmNome']; ?> <a href="manageConfigMkt?deleteaba=<?php echo $rowAba['abmId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Add Abas Mídias-->
                                                    <div class="modal fade" id="addaba" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-black">Nova Abas Mídias</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="prodForm" action="includes/configmidiamkt.inc.php" method="post">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md">
                                                                                <label class="text-black" for="nome">Nome</label>
                                                                                <input type="text" class="form-control" id="nome" name="nome" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" name="novaaba" class="btn btn-primary">Adicionar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Sessão Mídias -->
                                                    <div class="row w-100 p-3 bg-light rounded my-4">
                                                        <div class="d-flex justify-content-between p-1 align-items-center">
                                                            <h5 class="text-black">Sessão Mídias</h5>
                                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#addsessao"><i class="far fa-plus-square"></i> novo</button>
                                                        </div>
                                                        <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                        <div class="col p-1">
                                                            <?php

                                                            $arraySessao = array();

                                                            $retSessao = mysqli_query($conn, "SELECT * FROM sessaomidias GROUP BY ssmAba");
                                                            while ($rowSessao = mysqli_fetch_array($retSessao)) {
                                                                array_push($arraySessao, $rowSessao['ssmAba']);
                                                            }

                                                            foreach ($arraySessao as &$ss) {
                                                            ?>
                                                                <!-- Aba -->
                                                                <div class="row w-100 p-1 bg-light rounded">
                                                                    <div class="d-flex justify-content-between p-1 align-items-center">
                                                                        <p class="px-3 text-muted"><i class="fas fa-sort-down"></i> <?php echo $ss; ?></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <?php
                                                                        $retSearchSessao = mysqli_query($conn, "SELECT * FROM sessaomidias WHERE ssmAba='$ss';");
                                                                        while ($rowSearchSessao = mysqli_fetch_array($retSearchSessao)) {
                                                                        ?>
                                                                            <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <i class="<?php echo $rowSearchSessao['ssmIcon']; ?>"></i> <?php echo $rowSearchSessao['ssmNome']; ?> <a href="manageConfigMkt?deletesessao=<?php echo $rowSearchSessao['ssmId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
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

                                                    <!-- Modal Add Sessão Mídias-->
                                                    <div class="modal fade" id="addsessao" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-black">Nova Sessão Mídias</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="prodForm" action="includes/configmidiamkt.inc.php" method="post">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="aba">ABA</label>
                                                                                <select name="aba" class="form-control" id="aba">
                                                                                    <option>Selecione uma opção</option>
                                                                                    <?php
                                                                                    $retSlcAba = mysqli_query($conn, "SELECT * FROM abasmidias ORDER BY abmNome ASC");
                                                                                    while ($rowSlcAba = mysqli_fetch_array($retSlcAba)) {
                                                                                    ?>
                                                                                        <option value="<?php echo $rowSlcAba['abmNome']; ?>"><?php echo $rowSlcAba['abmNome']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group col-md">
                                                                                <label class="text-black" for="nome">Nome</label>
                                                                                <input type="text" class="form-control" id="nome" name="nome" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md">
                                                                                <label class="text-black" for="icon">Icon</label>
                                                                                <input type="text" class="form-control" id="icon" name="icon" required>
                                                                                <small class="text-muted">ex: bi bi-file-slides ou bi bi-camera-video</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" name="novasessao" class="btn btn-primary">Adicionar</button>
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
        </div>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js" defer></script>
        <script>
            function show(elem) {
                elem = elem.text;
                var tabAgenda = document.getElementById("v-pills-home");
                var tabConfig = document.getElementById("v-pills-settings");
                var linkAgenda = document.getElementById("v-pills-home-tab");
                var linkConfig = document.getElementById("v-pills-settings-tab");

                switch (elem) {
                    case 'Lista':
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

            $(document).ready(function() {
                $('#tableMaterial').DataTable({
                    "lengthMenu": [
                        [10, 20, 40, 80, -1],
                        [10, 20, 40, 80, "Todos"],
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