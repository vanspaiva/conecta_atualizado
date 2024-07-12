<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Comercial')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';

?>
    <!-- <link href="css/styles.css" rel="stylesheet" /> -->

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
                    if ($_GET["error"] == "stmfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center py-4">
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="col-sm-1">
                                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                    <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                </div>
                            </div>
                            <div class="col-sm pt-2">
                                <div class="row px-3">
                                    <div>
                                        <h2 class="text-conecta" style="font-weight: 400;">Novo <span style="font-weight: 700;">Usuário</span></h2>
                                        <p class="text-muted">Adicione as informações para criação do novo usuário</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <section id="main-content">
                                    <section class="wrapper">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-panel">
                                                    <form class="form-horizontal style-form" name="form1" action="includes/newuser.inc.php" method="post">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="nome">Nome Completo</label>
                                                                <input type="text" class="form-control" id="nome" name="nome" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="uf">UF</label>
                                                                <select name="uf" class="form-control" id="uf">
                                                                    <?php
                                                                    $retUf = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                                                    while ($rowUf = mysqli_fetch_array($retUf)) {
                                                                    ?>
                                                                        <option value="<?php echo $rowUf['ufAbreviacao']; ?>"><?php echo $rowUf['ufAbreviacao']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="email">E-mail</label>
                                                                <input type="email" class="form-control" id="email" name="email" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="uid">Usuário</label>
                                                                <input type="text" class="form-control" id="uid" name="uid" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="celular">Celular</label>
                                                                <input type="tel" class="form-control" id="celular" name="celular" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="telefone">Telefone</label>
                                                                <input type="tel" class="form-control" id="telefone" name="telefone" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="aprov">Aprovação</label>
                                                                <select name="aprov" class="form-control" id="aprov">
                                                                    <option value="APROV">Aprovado</option>
                                                                    <option value="AGRDD">Aguardando</option>
                                                                    <option value="BLOQD">Bloqueado</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="perm">Permissão</label>
                                                                <select name="perm" class="form-control" id="perm">
                                                                    <?php
                                                                    $retPermIn = mysqli_query($conn, "SELECT * FROM tipocadastrointerno ORDER BY tpcadinNome ASC");
                                                                    while ($rowPermIn = mysqli_fetch_array($retPermIn)) {
                                                                    ?>
                                                                        <option value="<?php echo $rowPermIn['tpcadinCodCadastro']; ?>"><?php echo $rowPermIn['tpcadinNome']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    $retPermEx = mysqli_query($conn, "SELECT * FROM tipocadastroexterno ORDER BY tpcadexNome ASC");
                                                                    while ($rowPermEx = mysqli_fetch_array($retPermEx)) {
                                                                    ?>
                                                                        <option value="<?php echo $rowPermEx['tpcadexCodCadastro']; ?>"><?php echo $rowPermEx['tpcadexNome']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="pwd">Senha</label>
                                                                <div class="input-group mb-3">
                                                                    <input id="pwd" class="form-control py-4" name="pwd" type="password" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                                    <div class="input-group-append">
                                                                        <button onclick="showPass()" class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="d-flex justify-content-center">
                                                            <button type="submit" name="new" class="btn btn-primary">Criar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            function showPass() {

                event.preventDefault();
                var passInput = document.getElementById('pwd');
                if (passInput.type == 'password') {
                    passInput.type = 'text';

                } else {
                    passInput.type = 'password';

                }
            }
        </script>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}


    ?>