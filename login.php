<!DOCTYPE html>
<html lang="pt-br">
<?php include("php/head_login.php"); ?>


<body style="overflow: hidden;" class="bg-light-gray2 font-montserrat">
    <main class="container-fluid p-0 font-montserrat">
        <div class="row">
            <div class="col-sm col bg-login-foto1 d-none d-md-block d-sm-none">
                <div class="row p-5 my-4">

                </div>
                <div class="row p-4 d-flex justify-content-start align-items-center">
                    <div class="col p-4">
                        <div class="d-flex justify-content-center align-items-center">
                            <h5 style="font-weight: 700;" class="font-montserrat ">
                                <span class="text-white">Tudo <br> conectado <br> pra a sua </span>
                                <br>
                                <span style="color: #544b59;"> segurança</span>
                                <span class="text-white">.</span>
                            </h5>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <a class="py-4" style="text-decoration: underline; color: white !important; font-size: small;" href="tipocadastro">É novo por aqui? Cadastre-se!</a>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="login-outline-btn p-2 px-4" style="font-size: small;" onclick="location.href='tipocadastro';">Criar a minha conta</button>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-sm col bg-login-foto2">
                <div class="row pb-5 mb-1 d-flex justify-content-center align-items-center">
                    <img src="assets/img/login/cranios.png" alt="Renders 3D Cranios CPMH" width="50%">
                </div>
                <div class="row pb-2 mb-2 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="d-flex justify-content-center py-2">
                            <img src="assets/img/login/c.png" alt="Logo Conecta CPMH" width="50px">
                        </div>
                        <h5 style="font-weight: 800; color: #544b59;" class="text-left font-montserrat">Faça seu <br>login.</h5>
                    </div>
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo "<div class='mb-3 alert alert-danger p-2 text-center'>Preencha <b> todos </b> os campos!</div>";
                        } else if ($_GET["error"] == "wronglogin") {
                            echo "<div class='mb-3 alert alert-danger p-2 text-center'><b>Usuário/E-mail ou senha errados</b>, tente novamente!</div>";
                        }
                    }
                    ?>
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    <form action="includes/login.inc.php" method="post">
                        <div class="form-group">
                            <input id="login-input-1" class="form-control py-4 input-login-txt font-montserrat" name="uid" type="text" placeholder="E-mail/Usuário" style="font-size: small;"/>
                        </div>

                        <div class="input-group mb-3 input-login-txt shadow-none" style="border-radius: 50px; outline: none;">
                            <input id="login-input-2" class="form-control py-4 border-0 font-montserrat" style="border-radius: 50px; outline: none; font-weight: bold; font-size: small;" name="pwd" type="password" placeholder="Senha" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append border-0">
                                <button onclick="showPass()" class="input-group-text border-0 bg-transparent" style="border-radius: 50px; outline: none;" id="basic-addon2"><i class="far fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="senha" class="px-3 text-small" style="color: #544b59; text-decoration: underline;">Esqueceu sua senha?</a>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn login-btn-new w-100" type="submit" name="submit" id="login" style="font-size: small;">Entrar <i class="fas fa-arrow-right"></i></button>
                        </div>
                        <div class="d-block d-sm-none">
                            <a class="py-4 px-3 d-flex justify-content-center align-items-center" href="tipocadastro"><span style="text-decoration: underline; color: #544b59 !important; font-size: small;"> É novo por aqui? Cadastre-se!</span></a>
                        </div>
                    </form>
                    <script>
                        $('#login-input-2').keyup(function(e) {
                            if (e.keyCode == 13) {
                                $('#basic-addon2').click();
                                $('#login').click();
                            }
                        });
                    </script>


                </div>

            </div>
        </div>
    </main>
    <script>
        function showPass() {

            event.preventDefault();
            var passInput = document.getElementById('login-input-2');
            if (passInput.type == 'password') {
                passInput.type = 'text';

            } else {
                passInput.type = 'password';

            }
        }
    </script>
    <script>
        $(document).ready(function() {

            const queryString = window.location.search;
            // console.log(queryString);
            const urlParams = new URLSearchParams(queryString);
            const errorVar = urlParams.get('error');
            // console.log(errorVar);

            if (errorVar == "waitaprov") {
                $("#waitaprov").modal()
            } else if (errorVar == "bloquser") {
                $("#bloquser").modal()

            }
        });
    </script>

    <!-- Modal Wait Aprov-->
    <div class="modal fade" id="waitaprov" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title text-conecta' id='exampleModalLabel' style="font-weight: 400; font-size: 16pt;">Cadastro <span style="font-weight: 700;"> Pendente</span></h5>

                </div>
                <div class='modal-body'>
                    <p style="font-size: 12pt; text-align: center;">Cadastro em processo de validação, enviaremos no seu número cadastrado o <b> link para seu 1º acesso.</b></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal User Bloq-->
    <div class="modal fade" id="bloquser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title text-conecta' id='exampleModalLabel' style="font-weight: 400; font-size: 16pt;">Usuário <span style="font-weight: 700;"> Bloqueado</span></h5>

                </div>
                <div class='modal-body'>
                    <p style="font-size: 12pt; text-align: center;">Detectamos algumas atividades suspeitas e <b> sua conta foi bloqueada</b>. Caso ache que tenha havido algum engano entre em contato conosco.</p>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

</body>

</html>