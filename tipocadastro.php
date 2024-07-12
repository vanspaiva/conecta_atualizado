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

<body class="bg-light-gray2 bg-login-item">
    <div class="container-fluid">
        <div class="row pt-4">
            <div class="col">
                <h2 class="text-center text-conecta" style="font-weight: 400;">Selecione seu <span style="font-weight: 700;"> tipo de usuário</span></h2>
            </div>
        </div>
    </div>
    <hr style="border-color: #ee7624;">

    <div class="container-fluid">
        <div class="row">
            <div class="col">

                <div class="card-pass m-auto">
                    <div class="card-head my-3">
                        <label class="row d-flex justify-content-center text-white">
                            <h5 style="color: #544b59;"><span style="font-weight: 700;">Sou</span></h5>
                        </label>
                        <div class="row d-flex justify-content-center">
                            <div class="form-group col-md-4 d-flex justify-content-center">
                                <select name="tipo" class="input-login-txt" id="tipo" onchange="sendToPage(this)">
                                    <option>Escolha uma opção</option>
                                    <?php
                                    include_once 'includes/dbh.inc.php';

                                    $ret = mysqli_query($conn, "SELECT * FROM tipocadastroexterno ORDER BY tpcadexNome ASC");
                                    while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                        <option value="<?php echo $row['tpcadexNome']; ?>"><?php echo $row['tpcadexNome']; ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                    </div>

                    <script>
                        function sendToPage(elem) {
                            let tipo = elem.value;
                            window.location.href = `cadastro?tipo=${tipo}`;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <a href="login">
                    <div class="text-center text-conecta" style="text-decoration: underline; font-weight: 400;">Já tenho cadastro! Acessar</div>
                </a>
            </div>
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