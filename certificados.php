<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Marketing')) || ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_tables.php");
    require_once 'includes/dbh.inc.php';
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "listasalva") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Lista salva com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Item foi deletado!</p></div>";
                    } else if ($_GET["error"] == "deletedLista") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Lista Completa foi deletada!</p></div>";
                    } else if ($_GET["error"] == "sentall") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Todos os certificados foram enviados com sucesso!</p></div>";
                    }
                }
                ?>
            </div>

            <div class="container-fluid">

                <div class="row py-4 d-flex justify-content-center align-items-center">
                    <div class="col-10 d-flex justify-content-between">
                        <h2 class="text-center text-conecta" style="font-weight: 400;">Envio de <span style="font-weight: 700;"> Certificados</span></h2>
                        <span class="btn btn-conecta" data-toggle="modal" data-target="#importListAlunos"><i class="bi bi-journal-arrow-up"></i> Importar Lista Alunos</span>
                        <!--<a href="sendcertificado"><span class="btn btn-dark" id="submit" name="submit">Enviar Certificados</span></a>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                    <hr style="border-color: #ee7624;">
                    </div>
                </div>

                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="card">
                            <div class="card-head">
                                <div class="p-4">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col d-flex justify-content-start">
                                            <h4>Alunos</h4>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <a href="sendcertificado">
                                                <button class="btn btn-success" onClick="return confirm('Você realmente deseja enviar os certificados para toda a lista descrita abaixo?');"><i class="fas fa-paper-plane"></i> Enviar Certificados</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="myTable" class="display table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nome</th>
                                                <th>Telefone</th>
                                                <th>E-mail</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // $ret = mysqli_query($conn, "SELECT * FROM aluno");
                                            $ret = mysqli_query($conn, "SELECT * FROM aluno ORDER BY nome ASC;");
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $id = $row['id'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['id'];  ?></td>
                                                    <td><?php echo $row['nome'];  ?></td>
                                                    <td><?php echo $row['tel'];  ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td>
                                                        <a href="deleteItemTableAlunos?id=<?php echo $id; ?>">
                                                            <button class="btn text-danger" onClick="return confirm('Você realmente deseja apagar esse item da lista?');"><i class="fas fa-trash-alt"></i></button></a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="card">
                            <div class="card-body">
                                <div class="content-panel">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col d-flex justify-content-center">
                                                <a href="deleteTableAlunos">
                                                    <button class="btn btn-danger" onClick="return confirm('Você realmente deseja apagar toda a lista de alunos?');"><i class="fas fa-trash-alt"></i> Apagar Lista</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- Modal Adicionar Lista Alunos-->
            <div class="modal fade" id="importListAlunos" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col py-3">
                                        <h5 class="modal-title text-conecta">Importar Lista de Usuários</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p><b>Instruções:</b>
                                            <br>
                                            <span>
                                                <b>1.</b> Exporte a lista da planilha como arquivo.csv <br>
                                                <b>2.</b> Abra o arquivo no bloco de notas, copie e cole no campo abaixo <br>
                                                <b>3.</b> Caso precise editar algum contato faça-o antes de exportar a lista <br>
                                                <b>4.</b> Aperte em SALVAR
                                        </p>
                                    </div>
                                </div>
                            </div>


                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row d-flex">
                                    <div class="col-md">
                                        <form class="form-horizontal style-form" action="includes/addlistaalunos.inc.php" method="POST">
                                            <div class="form-row">
                                                <div class="form-group col-md">
                                                    <label class="form-label text-black" for="lista">Lista Alunos</label>
                                                    <textarea name="lista" id="lista" class="form-control" rows="2"></textarea>
                                                    <small class="text-muted">Exemplo: <br> Nome Teste 1, email1@teste.com, (xx) xxxxx-xxxx <br> Nome Teste 2, email2@teste.com, (xx) xxxxx-xxxx</small>
                                                </div>
                                            </div>
                                            <div class="form-row ">
                                                <div class="form-group col-md d-flex justify-content-end">
                                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">Salvar</button>
                                                </div>
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