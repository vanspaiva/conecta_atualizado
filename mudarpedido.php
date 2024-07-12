<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Comercial')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center py-4">

                    <div class="col-sm-8" id="titulo-pag">
                        <h2 class="text-conecta" style="font-weight: 400;">Alterar Número <span style="font-weight: 700;"> do Pedido</span></h2>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="container-fluiud">
                            <div class="row d-flex justify-content-center">
                                <div class="col-6">
                                    <div class="card shadow">

                                        <div class="card-body">

                                            <section id="main-content">
                                                <section class="wrapper">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="content-panel">
                                                                <div class="nav">
                                                                    <div class="col-sm justify-content-center p-4" id="coluna-senha">
                                                                        <div>
                                                                            <?php
                                                                            if (isset($_GET["error"])) {
                                                                                if ($_GET["error"] == "success") {
                                                                                    $old = $_GET["old"];
                                                                                    $new = $_GET["new"];
                                                                                    echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Pedido alterado do <b> Nº " . $old . "</b> para <b> Nº " . $new . "</b></p></div>";
                                                                                } else if ($_GET["error"] == "stmtfailed") {
                                                                                    echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                                                                                } else if ($_GET["error"] == "none") {
                                                                                    echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Senha alterada com sucesso!</p></div>";
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <h5 style="color: #ee7624;" class="text-align-center">Alterar Pedido</h5>
                                                                        <p class="text-align-center text-small p-0 m-0">Atenção! Tenha certeza da ação que está realizando para evitar transtornos. </p>
                                                                        <p class="text-align-center text-small p-0 m-0">Ao finalizar o preenchimento certifique-se de salvar!</p>
                                                                        <br>
                                                                        <br>
                                                                        <form class="form p-4" name="form1" method="post" action="includes/updateNumPed.inc.php">
                                                                            <div class="form-row">
                                                                                <div class="form-group flex-fill">
                                                                                    <label class="form-label" style="color:black;">Número <b>Antigo</b></label>
                                                                                    <input id="oldnumber" class="form-control" name="oldnumber" type="number">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row">
                                                                                <div class="form-group flex-fill">
                                                                                    <label class="form-label" style="color:black;">Número <b>Novo</b> </label>
                                                                                    <input id="newnumber" class="form-control" name="newnumber" type="number">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row justify-content-center mt-3">
                                                                                <input type="submit" name="edit" value="Salvar" class="btn btn-conecta" style="margin-left: 30px;">
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

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
            function showPass(tipo) {
                event.preventDefault();

                if (tipo == 'pwd') {
                    var passInput = document.getElementById('senha');
                    if (passInput.type == 'password') {
                        passInput.type = 'text';
                    } else {
                        passInput.type = 'password';
                    }
                } else {
                    var passInput = document.getElementById('confirmeSenha');
                    if (passInput.type == 'password') {
                        passInput.type = 'text';
                    } else {
                        passInput.type = 'password';
                    }
                }



            }

            // function maskCel() {
            //     var cel = document.getElementById("celular");

            //     //(61) 9xxxx-xxxx
            //     //'(' nas posições -> 0
            //     //')' nas posições -> 3
            //     //' ' nas posições -> 4
            //     //'-' nas posições -> 10

            //     if (cel.value.length == 1) {
            //         cel.value = '(' + cel.value;
            //     }

            //     if (cel.value.length == 3) {
            //         cel.value += ') ';
            //     } else if (cel.value.length == 10) {
            //         cel.value += '-';
            //     }

            // }

            function maskTelefone() {
                var tel = document.getElementById("telefone");

                //(61) xxxx-xxxx
                //'(' nas posições -> 0
                //')' nas posições -> 3
                //' ' nas posições -> 4
                //'-' nas posições -> 10

                if (tel.value.length == 1) {
                    tel.value = '(' + tel.value;
                }

                if (tel.value.length == 3) {
                    tel.value += ') ';
                } else if (tel.value.length == 9) {
                    tel.value += '-';
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