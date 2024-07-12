<?php session_start();

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Qualidade'))) {
    include("php/head_index.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        require_once 'includes/dbh.inc.php';
        $ret = mysqli_query($conn, "SELECT * FROM produtos");
        $cnt = 1;
        ?>

        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <script src="https://cdn.tiny.cloud/1/zjf2h1vx7aqnqpv1gai59eeqiqb64jvhdg2tfv34o6i9i7lm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                plugin: 'a_tinymce_plugin',
                a_plugin_option: true,
                a_configuration_option: 400,
                content_style: "body { color: black; }"
            });
        </script>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                    } else if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto cadastrado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Produto foi deletado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row row-3">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Registro de <span style="font-weight: 700;">Produtos</span></h2>
                            <button class="btn btn-conecta" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Cadastrar Produto</button>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow">

                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="myTable" class="display table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th>Código</th>
                                                <th>Descrição</th>

                                                <th>Anvisa</th>
                                                <th>Preço</th>
                                                <th>Atividades</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php


                                            while ($row = mysqli_fetch_array($ret)) {

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['prodCategoria'];  ?></td>
                                                    <td><?php echo $row['prodCodCallisto'];  ?></td>
                                                    <td><?php echo $row['prodDescricao']; ?></td>

                                                    <td><?php echo $row['prodAnvisa']; ?></td>
                                                    <td><?php echo "R$ " . $row['prodPreco'];  ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="editProd?id=<?php echo $row['prodId']; ?>">
                                                                <button class="btn text-info m-1"><i class="far fa-edit"></i></button></a>
                                                            <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                                <a href="manageProd?id=<?php echo $row['prodId']; ?>">
                                                                    <button class="btn text-danger m-1" onClick="return confirm('Você realmente deseja apagar esse produto?');"><i class="far fa-trash-alt"></i></button></a>
                                                            <?php
                                                            }
                                                            ?>
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
                    <div class="col-sm-1"></div>

                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="prodForm" action="includes/produtos.inc.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="categoria">Categoria</label>
                                    <select class="form-control" id="categoria" name="categoria" required>
                                        <option>Selecione categoria</option>
                                        <option value="CMF">CMF</option>
                                        <option value="CRÂNIO">CRÂNIO</option>
                                        <option value="BIOMODELO">BIOMODELO</option>
                                        <option value="COLUNA">COLUNA</option>
                                        <option value="ATA">ATA</option>
                                        <option value="EXTRA">EXTRA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="cdg">Callisto</label>
                                    <input type="text" class="form-control" id="cdg" name="cdg" required>
                                    <small class="text-muted">Código cadastrado no callisto</small>
                                </div>
                                <div class="form-group col-md">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control" id="descricao" name="descricao" required>
                                </div>
                                <div class="form-group col-md">
                                    <label class="form-label text-black" for="descricaoAnvisa">Descrição Anvisa</label>
                                    <input type="text" class="form-control" id="descricaoAnvisa" name="descricaoAnvisa">
                                </div>
                            </div>
                            <div class="form-row">
                                <!--<div class="form-group col-md-6">
                                    <label for="parafusos">Parafusos</label>
                                    <input type="number" class="form-control" id="parafusos" name="parafusos">
                                </div>-->
                                <div class="form-group col-md">
                                    <label for="anvisa">Anvisa</label>
                                    <input type="text" class="form-control" id="anvisa" name="anvisa" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="preco">Preço</label>
                                    <input type="number" class="form-control" id="preco" name="preco" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="codPropPadrao">Código Prop</label>
                                    <input type="text" class="form-control" id="codPropPadrao" name="codPropPadrao">
                                    <small class="text-muted">Código da proposta padrão no callisto</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label>Tem Imposto?</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radioImposto" id="temimposto" value="sim" onclick="showImposto(this)">
                                        <label class="form-check-label" for="temimposto">sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radioImposto" id="ntemimposto" value="não" onclick="showImposto(this)">
                                        <label class="form-check-label" for="ntemimposto">não</label>
                                    </div>
                                </div>
                                <div class="form-group col-md" id="hiddenImposto" hidden>
                                    <label for="imposto">Imposto</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" id="imposto" name="imposto" aria-describedby="porc">
                                        <span class="input-group-text" id="porc">%</span>
                                    </div>
                                    <small>Valor em porcentagem</small>
                                </div>
                            </div>
                            <script>
                                function showImposto(elem) {
                                    elem = elem.value;

                                    if (elem == "sim") {
                                        document.getElementById("hiddenImposto").hidden = false;
                                    }

                                    if (elem == "não") {
                                        document.getElementById("hiddenImposto").hidden = true;
                                    }

                                }
                            </script>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="kitdr">Observação</label>
                                    <textarea class="form-control" name="kitdr" id="kitdr" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="txtOP">OP/Anvisa</label>
                                    <textarea class="form-control" name="txtOP" id="txtOP" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="txtAcompanha">Proposta Acompanha</label>
                                    <textarea class="form-control" name="txtAcompanha" id="txtAcompanha" rows="3"></textarea>
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
                    }
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