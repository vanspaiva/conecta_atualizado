<?php
session_start();
if (isset($_SESSION["useruid"])) {
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

        $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersCnpj='" . $cnpj . "' AND usersUid <>'" . $_SESSION["useruid"] . "' AND usersCnpj <>'';");
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Sua solicitação foi enviada e será analisada em breve!</p></div>";
                    } else if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Algo está errado! Tente novamente ou solicite suporte.</p></div>";
                    } else if ($_GET["error"] == "created") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Usuário novo criado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4">
                    <div class="col d-flex justify-content-center">
                        <div class="">

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-conecta" style="font-weight: 400;">Solicitação de <span style="font-weight: 700;">Antecipação de Pedido</span></h2>
                                    <p class="text-muted"><b>Atenção!</b> Solicitação de antecipação do pedido está sujeita a análise. </p>
                                </div>
                                <div>
                                    <button class="btn btn-conecta shadow" data-toggle="modal" data-target="#novasolicitacao"><i class="fas fa-plus"></i> Nova Solicitação</button>
                                </div>

                            </div>
                            <hr style="border-color: #ee7624;">

                            <div class="pt-2 pb-4">

                                <?php

                                $userAtual = $_SESSION["useruid"];

                                $retUser = mysqli_query($conn, "SELECT * FROM adiantamentos WHERE adiantUser='$userAtual';");

                                if (($retUser) && ($retUser->num_rows != 0)) { ?>
                                    <span class="btn btn-primary">
                                        <a href='minhasantecipacoes' style="color: #fff;"> Verificar Minhas Solicitações de Antecipação <i class='fas fa-arrow-right'></i></a>
                                    </span>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="d-flex justify-content-center">
                                <img width="70%" class="rounded shadow" src="https://www.cpmhdigital.com.br/wp-content/uploads/2023/07/Prancheta-1@3x.png" alt="Taxa de Antecipação">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="novasolicitacao" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Solicitação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="prodForm" action="includes/antecipacao.inc.php" method="post">

                            <div class="form-row" hidden>
                                <div class="form-group col-md">
                                    <label for="user">Usuário</label>
                                    <input type="text" class="form-control" id="user" name="user" value="<?php echo $_SESSION["useruid"]; ?>" required readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nped">Nº Pedido</label>
                                    <input type="text" class="form-control" id="nped" name="nped" required>
                                </div>
                                <div class='form-group col-md'>
                                    <label class='form-label text-black'>Produto</label>
                                    <select name='produto' class='form-control' id='produto'>
                                        <option>Selecione um produto</option>
                                        <?php
                                        $retProduto = mysqli_query($conn, "SELECT * FROM produtosproposta ORDER BY prodpropNome ASC");
                                        while ($rowProduto = mysqli_fetch_array($retProduto)) {
                                        ?>
                                            <option value="<?php echo $rowProduto['prodpropNome']; ?>"><?php echo $rowProduto['prodpropNome']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>
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