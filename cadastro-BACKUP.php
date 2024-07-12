<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Conecta 2.0 - Cadastro</title>
    <!-- <link href="css/styles.css" rel="stylesheet" /> -->
    <link href="css/system.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-conecta bg-image-2">
    <div class="container">
        <div class="row py-4">
            <div class="col">
                <h3 class="text-center text-white fw-bold"><b>NOVO USUÁRIO</b></h3>
            </div>

        </div>
        <div>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Preencha todos os campos!</p></div>";
                } else if ($_GET["error"] == "invaliduid") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Nome de usuário inválido!</p></div>";
                } else if ($_GET["error"] == "invalidemail") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>E-mail inválido!</p></div>";
                } else if ($_GET["error"] == "passworddontmatch") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Senhas não correspondem</p></div>";
                } else if ($_GET["error"] == "usernametaken") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Esse nome de usuário já está em uso!</p></div>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                } else if ($_GET["error"] == "none") {
                    echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Usuário criado com sucesso!</p></div>";
                } else if ($_GET["error"] == "conecterror") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                } else if ($_GET["error"] == "termserror") {
                    echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Você precisa aceitar os termos e politicas de privacidade!</p></div>";
                }
            }
            ?>
        </div>

    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <hr style="border: 2px dashed #fff;" />
                <div class="card-pass m-auto">
                    <div class="card-head my-3">
                        <label class="row d-flex justify-content-center text-white">
                            <h5>
                                Sou...
                            </h5>
                        </label>
                        <div class="row d-flex justify-content-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipoUsuario" id="usuarioDoutor" value="doutor" onchange="handleRegisterForm(this)">
                                <label class="form-check-label text-white" for="usuarioDoutor">Doutor</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipoUsuario" id="usuarioDistribuidor" value="distribuidor" onchange="handleRegisterForm(this)">
                                <label class="form-check-label text-white" for="usuarioDistribuidor">Distribuidor</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipoUsuario" id="usuarioPaciente" value="paciente" onchange="handleRegisterForm(this)">
                                <label class="form-check-label text-white" for="usuarioPaciente">Paciente</label>
                            </div>
                            <div class="form-check form-check-inline" hidden>
                                <input class="form-check-input" type="radio" name="tipoUsuario" id="usuarioInternacional" value="internacional" onchange="handleRegisterForm(this)">
                                <label class="form-check-label text-white" for="usuarioInternacional">Internacional</label>
                            </div>
                        </div>
                    </div>
                    <hr style="border: 2px dashed #fff;" />
                    <div class="card-body">
                        <form action="includes/register.inc.php" method="post">
                            <div id="register-form"></div>
                            <div class='form-group mt-3' hidden>
                                <input class='form-control py-4 usuario' name='usuario' type='text' />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card-footer text-center">
        <div class="">
            <a href="login">
                <div class="alert alert-light">Já tenho cadastro! Acessar</div>
            </a>
        </div>
    </div>

    <?php

    ?>
    <script>
        function showPass() {

            event.preventDefault();
            var passInput = document.getElementById('login-input-2');
            if (passInput.type == 'password') {
                passInput.type = 'text';
                console.log('mostrou');
            } else {
                passInput.type = 'password';
                console.log('escondeu');
            }
        }
    </script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/standart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>