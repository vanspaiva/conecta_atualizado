<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Planej. Ortognática') || ($_SESSION["userperm"] == 'Representante')) {
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    $user = $_SESSION["useruid"];

    if(isset($_GET["type"])){
        $type = $_GET["type"];
    } else{
        $type = null;
    }

    if(isset($_GET["id"])){
        $id = $_GET["id"];
    } else{
        $id = null;
    }
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center py-4">

                    <div class="col-sm-8">
                        <h2 class="text-conecta" style="font-weight: 400;">Adicionar Link <span style="font-weight: 700;"> do Drive</span></h2>
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
                                                                                if ($_GET["error"] == "stmtfailed") {
                                                                                    echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                                                                                } else if ($_GET["error"] == "none") {
                                                                                    echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Link salvo com sucesso!</p></div>";
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <h5 style="color: #4A4A4A;" class="text-align-center text-conecta">Salvar Link de Referência</h5>
                                                                        <p class="text-align-center text-small p-0 m-0">Utilize os campos abaixo para salvar o link. </p>
                                                                        <p class="text-align-center text-small p-0 m-0">Ao finalizar o preenchimento certifique-se de salvar!</p>
                                                                        <br>
                                                                        <br>
                                                                        <form class="form p-4" name="form1" method="post" action="includes/updateLinkDrive.inc.php">
                                                                            <div class="form-row">
                                                                                <div class="form-group flex-fill d-flex justify-content-center ">
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="type" id="dono1" value="Qualidade" <?php echo ($type == "quali") ? "checked" : null; ?> required>
                                                                                        <label class="form-check-label" for="dono1">Qualidade</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="type" id="dono2" value="Planejamento" <?php echo ($type == "plan") ? "checked" : null; ?>>
                                                                                        <label class="form-check-label" for="dono2">Planejamento</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="form-group flex-fill">
                                                                                    <label class="form-label" style="color:black;">ID Proposta</label>
                                                                                    <input id="id" class="form-control" name="id" type="text" value="<?php echo $id;?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row">
                                                                                <div class="form-group flex-fill">
                                                                                    <label class="form-label" style="color:black;">Link</label>
                                                                                    <input id="link" class="form-control" name="link" type="text">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row justify-content-center mt-3">
                                                                                <input type="submit" name="newlink" value="Salvar" class="btn btn-conecta">
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