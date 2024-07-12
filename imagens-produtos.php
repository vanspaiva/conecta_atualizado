<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
    include("php/head_index.php");
?>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmtfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                        } else if ($_GET["error"] == "none") {
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Imagem editada com sucesso!</p></div>";
                        } else if ($_GET["error"] == "deleted") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Imagem apagada com sucesso!</p></div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm-9 d-flex justify-content-start" id="titulo-pag">
                        <h2 class="text-conecta" style="font-weight: 400;">Banco de Imagens <span style="font-weight: 700;">dos Produtos</span></h2>
                    </div>
                    <div class="col-sm-3 d-flex justify-content-end">
                        <button class="btn btn-conecta" data-toggle="modal" data-target="#addImgModal"><i class="fas fa-plus"></i> Nova Imagem</button>
                    </div>
                </div>
                <hr style="border: 1px solid #ee7624">
                <div class="row py-3">
                    <div class="card w-100 shadow">
                        <div class="card-body">
                            <!--Casos Abertos, Casos Pendentes, Casos Finalizados e Casos Arquivados-->
                            <!--Tabs for large devices-->
                            <ul class="nav nav-pills mb-3 d-flex justify-content-center" role="tablist">
                                <li class="nav-item px-4 py-1" role="presentation">
                                    <a class="nav-link active text-tab" id="pills-lista-tab" data-toggle="pill" href="#pills-lista" role="tab" aria-controls="pills-lista" aria-selected="true"><i class="bi bi-list"></i> Lista</a>
                                </li>
                                <li class="nav-item px-4 py-1" role="presentation">
                                    <a class="nav-link text-tab" id="pills-grid-tab" data-toggle="pill" href="#pills-grid" role="tab" aria-controls="pills-grid" aria-selected="true"><i class="fas fa-th"></i> Grid</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-lista" role="tabpanel" aria-labelledby="pills-lista-tab">
                                    <!-- <h5 class="p-auto text-black">Lista</h5> -->
                                    <table id="tabelaFotos" class="display table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Categoria</th>
                                                <th>Codigo</th>
                                                <th>Nome</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $ret = mysqli_query($conn, "SELECT * FROM imagensprodutos");
                                            while ($row = mysqli_fetch_array($ret)) {

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['imgprodId'];  ?></td>
                                                    <td><?php echo $row['imgprodCategoria'];  ?></td>
                                                    <td><?php echo $row['imgprodCodCallisto']; ?></td>
                                                    <td><?php echo $row['imgprodNome']; ?></td>

                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="editImagem?id=<?php echo $row['imgprodId']; ?>">
                                                                <button class="btn text-info m-1"><i class="far fa-edit"></i></button></a>
                                                            <a href="manageImagem?id=<?php echo $row['imgprodId']; ?>">
                                                                <button class="btn text-danger m-1" onClick="return confirm('Você realmente deseja apagar essa imagem?');"><i class="far fa-trash-alt"></i></button></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>


                                    <script>
                                        $(document).ready(function() {
                                            $('#tabelaFotos').DataTable({
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
                                </div>

                                <div class="tab-pane fade" id="pills-grid" role="tabpanel" aria-labelledby="pills-grid-tab">

                                    <!-- <form class="form" action="" method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <div class="input-group d-flex">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="form1">Search</label>
                                                        <input type="search" id="form1" class="form-control" />
                                                    </div>
                                                    <button type="button" class="btn btn-primary">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form> -->
                                    <div class="container">
                                        <div class="row">
                                            <?php
                                            $retGrid = mysqli_query($conn, "SELECT * FROM imagensprodutos");
                                            while ($rowGrid = mysqli_fetch_array($retGrid)) {
                                                $dataBD = $rowGrid['imgprodDataEnvio'];
                                                $dataBD = explode(" ", $dataBD);
                                                $date = $dataBD[0];
                                                $hour = $dataBD[1];
                                                $date = explode("-", $date);
                                                $data = $date[2] . '/' . $date[1] . '/' . $date[0];
                                                $hour = explode(":", $hour);
                                                $hora = $hour[0] . ':' . $hour[1];
                                                $horario = $data . ' às ' . $hora;

                                            ?>
                                                <div class="col-md-4 p-2">
                                                    <div class="card shadow rounded border-secondary">
                                                        <div class="card-body d-flex justify-content-center align-items-center">
                                                            <img src="<?php echo $rowGrid['imgprodLink']; ?>" alt="<?php echo $rowGrid['imgprodNome']; ?>">
                                                        </div>

                                                        <div class="card-footer" style="text-align: center;">
                                                            <hr>
                                                            <p><b><?php echo $rowGrid['imgprodNome']; ?></b></p>
                                                            <p><b><?php echo $rowGrid['imgprodCodCallisto']; ?></b></p>
                                                            <small>Atualizado em <?php echo $horario; ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>






        <!-- Modal -->
        <div class="modal fade" id="addImgModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Imagem</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="prodForm" action="includes/addImagemProduto.inc.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="categoria">Categoria Produto</label>
                                    <select class="form-control" id="categoria" name="categoria" required>
                                        <option>Selecione categoria</option>
                                        <option value="CMF">CMF</option>
                                        <option value="CRÂNIO">CRÂNIO</option>
                                        <option value="BIOMODELO">BIOMODELO</option>
                                        <option value="COLUNA">COLUNA</option>
                                        <option value="ATA">ATA</option>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="nomeimg">Nome Imagem</label>
                                    <input type="text" class="form-control" id="nomeimg" name="nomeimg" required>
                                    <small class="text-muted">Nome que servirá de legenda</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="cdg">Callisto</label>
                                    <input type="text" class="form-control" id="cdg" name="cdg" required>
                                    <small class="text-muted">Código cadastrado no callisto</small>
                                </div>
                                <div class="form-group col-md">
                                    <label for="link">Link</label>
                                    <input type="text" class="form-control" id="link" name="link" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <img id="preview" src="" alt="">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="submit" class="btn btn-primary">Adicionar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        </div>
        <script>
            var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
            triggerTabList.forEach(function(triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)

                triggerEl.addEventListener('click', function(event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            });
        </script>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/standart.js"></script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script> -->
        </div>
    </body>

    </html>

<?php

} else {
    header("location: ../index");
    exit();
}

?>