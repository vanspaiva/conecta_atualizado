<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Distribuidor(a)')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';

    $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "'");
    while ($rowUser = mysqli_fetch_array($retUser)) {
        $cnpj = $rowUser['usersCnpj'];
        $uf = $rowUser['usersUf'];
        $empresa = $rowUser['usersEmpr'];
        $emailempresa = $rowUser['usersEmailEmpresa'];
    }
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
                <div class="row row-3">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6 justify-content-start" id="titulo-pag">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="col-sm-1">
                                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                    <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                </div>
                            </div>
                            <div class="col-sm-11 pt-2">
                                <div class="row px-3">
                                    <h2 class="text-conecta" style="font-weight: 400;">Novo Usuário <span style="font-weight: 700;">Comercial</span></h2>
                                </div>
                            </div>
                        </div>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="card">

                            <div class="card-body">

                                <section id="main-content">
                                    <section class="wrapper">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-panel">
                                                    <form class="form-horizontal style-form" name="form1" action="includes/newuserComercial.inc.php" method="post">
                                                        <div class="form-row">
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="nome">Nome Completo</label>
                                                                <input type="text" class="form-control" id="nome" name="nome" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="uf">UF</label>
                                                                <select name="uf" class="form-control" id="uf">
                                                                    <?php
                                                                    $retUf = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                                                    while ($rowUf = mysqli_fetch_array($retUf)) {
                                                                    ?>
                                                                        <option value="<?php echo $rowUf['ufAbreviacao']; ?>" <?php if ($rowUf['ufAbreviacao'] == $uf) echo ' selected="selected"'; ?>><?php echo $rowUf['ufAbreviacao']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="email">E-mail</label>
                                                                <input type="email" class="form-control" id="email" name="email" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="uid">Usuário</label>
                                                                <input type="text" class="form-control" id="uid" name="uid" required onkeyup="maskUid()" style="text-transform: lowercase;">
                                                            </div>
                                                            <script>
                                                                function maskUid() {
                                                                    var uid = document.getElementById("uid").value;
                                                                    uid.value = uid.toLowerCase();


                                                                    if (uid.search(/\s/g) != -1) {
                                                                        alert("Não é permitido espaços em branco\n");
                                                                        uid = uid.replace(/\s/g, "");
                                                                        $("#uid").val(uid.substring(0, uid.length - 1));
                                                                    }
                                                                    if (uid.search(/[^a-z0-9]/i) != -1) {
                                                                        alert("Não é permitido caracteres especiais");
                                                                        uid = uid.replace(/[^a-z0-9]/gi, "");
                                                                        $("#uid").val(uid.substring(0, uid.length - 1));
                                                                    }
                                                                    // console.log(uid.toLowerCase());
                                                                }
                                                            </script>
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="celular">Celular</label>
                                                                <input type="tel" class="form-control" id="celular" name="celular" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label class="form-label text-black" for="telefone">Telefone</label>
                                                                <input type="tel" class="form-control" id="telefone" name="telefone" required>
                                                            </div>
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="cnpj">CNPJ</label>
                                                                <input type="tel" class="form-control" id="cnpj" name="cnpj" value="<?php echo $cnpj; ?>" required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="empresa">Empresa</label>
                                                                <input type="tel" class="form-control" id="empresa" name="empresa" value="<?php echo $empresa; ?>" required readonly>
                                                            </div>
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="emailempresa">E-mail Empresa</label>
                                                                <input type="email" class="form-control" id="emailempresa" name="emailempresa" value="<?php echo $emailempresa; ?>" required readonly>
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

                                                        <div class="d-flex justify-content-end">
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
                    <div class="col-sm-3"></div>

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