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
    <?php
    include_once 'includes/dbh.inc.php';

    $tipo = isset($_GET['tipo']) ?? $tipo = null;
    if ($tipo != null) {
        $tipo = $_GET['tipo'];
    }


    switch ($tipo) {
        case 'Doutor(a)':
            $tipoUser = 'doutor';
            break;

        case 'Distribuidor(a)':
            $tipoUser = 'distribuidor';
            break;

        case 'Paciente':
            $tipoUser = 'paciente';
            break;


        default:
            $tipoUser = 'paciente';
            break;
    }

    // $name = isset($name) ? $name : '';

    // $tipo = addslashes($_GET["tipo"]);
    // if(isset($_GET["tipo"])){
    //     $tipo = addslashes($_GET["tipo"]);
    // }else{
    //     $tipo = null;
    // }
    ?>
    <div class="container">
        <div class="row py-4">
            <div class="col">
                <h2 class="text-center text-conecta" style="font-weight: 400;">Crie aqui seu <span style="font-weight: 700;"> novo usuário</span></h2>
            </div>
        </div>
        <hr style="border-color: #ee7624;">
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

                <div class="card-pass m-auto">
                    <div class="card-head my-3">
                        <label class="row d-flex justify-content-center text-conecta">
                            <h5 style="color: #544b59;">
                                <span style="font-weight: 700;">
                                    Sou <?php if ($tipo == null) {
                                            echo '...';
                                        } else {
                                            echo $tipo;
                                        } ?>
                                </span>
                            </h5>

                        </label>
                    </div>

                    <div class="card-body">
                        <form action="includes/register.inc.php" method="post">
                            <div class='form-group mt-3' hidden>
                                <input class='form-control py-4 usuario' name='usuario' type='text' value="<?php echo $tipoUser; ?>" />
                            </div>
                            <div class='form-row'>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control text-conecta'>Nome Completo *</label>
                                        <input class='form-control py-4' name='name' type='text' style='text-transform: capitalize;' required />
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control text-conecta'>Usuário *</label>
                                        <input class='form-control py-4' name='username' id='username' type='text' required onkeyup="maskUid()" style="text-transform: lowercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control text-conecta'>E-mail *</label>
                                        <input class='form-control py-4' name='email' type='email' aria-describedby='emailHelp' required />
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control text-conecta'>Celular *</label>
                                        <input class='form-control py-4' name='celular' id='celular' type='text' placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required />
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control text-conecta'>Telefone *</label>
                                        <input class='form-control py-4' name='tel' id='tel' type='text' placeholder='(xx) xxxx-xxxx' maxlength='14' onkeyup='maskTel()' required />
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control text-conecta'>UF *</label>
                                        <select class='form-select form-select-xl w-100 ' name='uf' required>
                                            <option selected>Selecione uma UF</option>
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
                            </div>
                            <?php if ($tipo == 'Paciente') { ?>
                                <div class='form-row'>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>Nome Dr(a) Responsável *</label>
                                            <input class='form-control py-4' name='drResp' type='text' style='text-transform: capitalize;' required />
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>UF Dr(a) *</label>
                                            <select class='form-select form-select-xl w-100 ' name='ufdr' required>
                                                <option selected>Selecione uma UF</option>
                                                <?php
                                                $retUFCons = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                                while ($rowUFCons = mysqli_fetch_array($retUFCons)) {
                                                ?>
                                                    <option value="<?php echo $rowUFCons['ufAbreviacao']; ?>"><?php echo $rowUFCons['ufAbreviacao']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>CPF *</label>
                                            <input class='form-control py-4' name='cpf' id='cpf' type='text' placeholder='XXX.XXX.XXX-XX' maxlength='14' onkeyup='maskCPF()' required />
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($tipo == 'Distribuidor(a)') { ?>
                                <div class='form-row'>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>Empresa *</label>
                                            <input class='form-control py-4' name='empresa' type='text' style='text-transform: capitalize;' required />
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>CNPJ *</label>
                                            <input class='form-control py-4' name='cnpj' id='cnpj' type='text' maxlength='18' onkeyup='maskCNPJ()' required />
                                        </div>
                                    </div>
                                    <div class='col'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>E-mail Empresa *</label>
                                            <input class='form-control py-4' name='emailempresa' type='text' placeholder='para envio da proposta' required />
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($tipo == 'Doutor(a)') { ?>
                                <div class='form-row'>
                                    <div class='col-md'>
                                        <div class='form-group'>
                                            <label for="tipocr" class='ml-2 label-control text-conecta'>Conselho Profissional *</label>
                                            <select id="tipocr" name="tipocr" class='form-select form-select-xl w-100 ' required>
                                                <option value="0">Escolha uma opção</option>
                                                <?php
                                                $retCons = mysqli_query($conn, "SELECT * FROM conselhosprofissionais ORDER BY consNomeExtenso ASC");
                                                while ($rowCons = mysqli_fetch_array($retCons)) {
                                                ?>
                                                    <option value="<?php echo $rowCons['consAbreviacao']; ?>"><?php echo $rowCons['consNomeExtenso']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md'>
                                        <div class='form-group'>
                                            <label for="ufcr" class='ml-2 label-control text-conecta'>UF Conselho *</label>
                                            <select id="ufcr" name="ufcr" class='form-select form-select-xl w-100 ' required>
                                                <option selected>Selecione uma UF</option>
                                                <?php
                                                $retUFCons = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                                while ($rowUFCons = mysqli_fetch_array($retUFCons)) {
                                                ?>
                                                    <option value="<?php echo $rowUFCons['ufAbreviacao']; ?>"><?php echo $rowUFCons['ufAbreviacao']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='col-md'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>Nº do Conselho *</label>
                                            <input class='form-control py-4' name='crm' id='crm' type='number' maxlength='6' required />
                                        </div>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-md'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>CPF *</label>
                                            <input class='form-control py-4' name='cpf' id='cpf' type='text' placeholder='XXX.XXX.XXX-XX' maxlength='14' onkeyup='maskCPF()' required />
                                        </div>
                                    </div>
                                    <div class='col-md'>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>Especialidade *</label>
                                            <select class='form-select form-select-xl w-100 ' name='especialidade' onchange="verifyEspec(this)" required>
                                                <option selected>Especialidade</option>
                                                <?php
                                                $retEspec = mysqli_query($conn, "SELECT * FROM especialidades ORDER BY especNome ASC");
                                                while ($rowEspec = mysqli_fetch_array($retEspec)) {
                                                ?>
                                                    <option value="<?php echo $rowEspec['especNome']; ?>"><?php echo $rowEspec['especNome']; ?></option>
                                                <?php
                                                }
                                                ?>
                                                <option value='outros'>Outros</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md' id="outraespec" hidden>
                                        <div class='form-group'>
                                            <label class='ml-2 label-control text-conecta'>Outra Especialidade</label>
                                            <input class='form-control py-4' name='outraespec' id='outraespec' type='text' />
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class='form-row'>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control text-conecta'>Senha *</label>
                                        <input class='form-control py-4' name='password' type='password' required />
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control text-conecta'>Confirmar Senha*</label>
                                        <input class='form-control py-4' name='confirmpassword' type='password' required />
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='col-md'>
                                    <div class='form-check'>
                                        <input class='form-check-input check-required' type='checkbox' id='termsCheck' name='termsCheck'>
                                        <label class='form-check-label' for='flexCheckChecked' style='color:#ee7624;'>
                                            Ao informar meus dados, eu concordo com a <a href='https://www.cpmhdigital.com.br/politica-de-privacidade-app/' target='blank' style='text-decoration: underline; color:#ee7624'>Política de Privacidade </a>e em receber ofertas e comunicação personalizadas de acordo com meus interesses
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class='form-group mt-4 mb-0 btn btn-primary btn-block' type='submit' name='submit' id='submit'>Criar Conta</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card-footer text-center">
        <div class="">
            <a href="login" class="text-conecta">
                <div class="text-center text-conecta" style="text-decoration: underline; font-weight: 400;">Já tenho cadastro! Acessar</div>
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

        function verifyEspec(elem) {

            var elem = elem.value;

            if (elem == 'outros') {
                document.getElementById('outraespec').hidden = false;

            } else {
                document.getElementById('outraespec').hidden = true;
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