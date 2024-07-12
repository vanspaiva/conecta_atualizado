<!DOCTYPE html>
<html lang="pt-br">
<?php include("php/head_senha.php"); ?>
<style>
    .mt-100 {
        margin-top: 100px !important;
    }

    @media only screen and (max-width: 800px) {
        #text-helper {
            visibility: hidden;
            display: none;
        }
    }
</style>

<body class="bg-light-gray2 bg-login-item">
    <div class="container-fluid p-4">
        <div class="row d-flex justify-content-center pt-2 mt-3 ">
            <div class="py-2" id="nav-password">
                <h2 class="text-center text-conecta" style="font-weight: 400;">Recuperação de <span style="font-weight: 700;"> Senha</span></h2>
            </div>
        </div>
        <hr style="border-color: #ee7624;">
        <div>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<div class='my-3 alert alert-danger p-3 text-center'>Preencha um e-mail válido!</div>";
                } else  if ($_GET["error"] == "wrongemail") {
                    echo "<div class='my-3 alert alert-warning p-3 text-center'>Desculpe, não encontramos esse e-mail no sistema!</div>";
                } else if ($_GET["error"] == "none") {
                    echo "<div class='my-3 alert alert-success p-3 text-center'>Verifique seu e-mail!</div>";
                }
            }
            ?>
        </div>


        <div class="row py-2 d-flex justify-content-center align-items-center">
            <div class="col d-flex justify-content-center align-items-center">
                <h4 class="text-conecta p-4" style="font-weight: 400; font-size: 14pt;">
                    Não se preocupe que iremos te ajudar!<br>Digite abaixo o <b>e-mail</b> que você cadastrou <br> no nosso sistema para <b>recuperar sua senha.</b>
                </h4>
                <div class="d-flex justify-content-center p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="108.908" height="116.399" viewBox="0 0 108.908 116.399">
                        <g id="Grupo_829" data-name="Grupo 829" transform="translate(762.59 -2343.84)">
                            <g id="Grupo_827" data-name="Grupo 827" transform="translate(-762.59 2343.84)">
                                <path id="Caminho_2152" data-name="Caminho 2152" d="M-736.831,2394.255h60.452a2.931,2.931,0,0,0,2.931-2.931v-2.345a2.931,2.931,0,0,0-2.931-2.931h-6.829v-14.475c0-14.937-11.819-27.448-26.755-27.729a27.305,27.305,0,0,0-27.8,27.272v14.954a25.789,25.789,0,0,0-24.827,25.736v19.585a25.759,25.759,0,0,0,25.759,25.759H-689a2.931,2.931,0,0,0,2.931-2.931v-2.345a2.931,2.931,0,0,0-2.931-2.931h-47.83a17.552,17.552,0,0,1-17.552-17.552v-19.585A17.552,17.552,0,0,1-736.831,2394.255Zm7.275-23.138a19.09,19.09,0,0,1,18.736-19.067c10.67-.184,19.4,8.774,19.4,19.446v14.552h-38.14Z" transform="translate(762.59 -2343.84)" fill="#ee7624" />
                            </g>
                            <g id="Grupo_828" data-name="Grupo 828" transform="translate(-688.899 2401.996)">
                                <path id="Caminho_2153" data-name="Caminho 2153" d="M-609.667,2520.31a5.691,5.691,0,0,0-4.347,1.961,6.594,6.594,0,0,0-1.635,4.475,6.785,6.785,0,0,0,1.579,4.411,5.6,5.6,0,0,0,4.4,2.1,5.7,5.7,0,0,0,4.411-2.071,6.71,6.71,0,0,0,1.635-4.44,6.6,6.6,0,0,0-1.636-4.477A5.761,5.761,0,0,0-609.667,2520.31Z" transform="translate(628.099 -2475.015)" fill="#ee7624" />
                                <path id="Caminho_2154" data-name="Caminho 2154" d="M-606.593,2447.194c-3.161-2.753-7.368-4.15-12.5-4.15-6.9,0-12.463,2.289-16.527,6.8a4.886,4.886,0,0,0-1.253,3.588,4.895,4.895,0,0,0,1.676,3.418,4.9,4.9,0,0,0,6.8-.314,11.7,11.7,0,0,1,8.983-3.524,8.331,8.331,0,0,1,5.821,1.814,5.81,5.81,0,0,1,1.9,4.635,7.11,7.11,0,0,1-.922,3.786,28.213,28.213,0,0,1-3.72,4.492,48.082,48.082,0,0,0-3.542,3.949,17.486,17.486,0,0,0-2.548,4.648v0a15.806,15.806,0,0,0-.824,3.252,4.967,4.967,0,0,0,1.152,3.974,4.908,4.908,0,0,0,3.717,1.7h.187a4.941,4.941,0,0,0,4.871-4.249,7.112,7.112,0,0,1,.876-2.666,27.847,27.847,0,0,1,3.758-4.705,50.391,50.391,0,0,0,3.495-4.016,17.833,17.833,0,0,0,2.5-4.674,18.174,18.174,0,0,0,1.033-6.315A14.5,14.5,0,0,0-606.593,2447.194Z" transform="translate(636.887 -2443.044)" fill="#ee7624" />
                            </g>
                            <path id="Caminho_2155" data-name="Caminho 2155" d="M-674.138,2464.3a9.931,9.931,0,0,0-9.931-9.931A9.932,9.932,0,0,0-694,2464.3a9.928,9.928,0,0,0,5.241,8.754v5.315a4.69,4.69,0,0,0,4.69,4.69,4.69,4.69,0,0,0,4.69-4.69v-5.316A9.926,9.926,0,0,0-674.138,2464.3Z" transform="translate(-28.381 -45.734)" fill="#ee7624" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center py-2">
            <div class="col-6">
                <form action="includes/pass.inc.php" method="post">
                    <div class="form-group">
                        <input class="form-control py-4 input-login-txt" id="email" name="email" type="email" aria-describedby="emailHelp" placeholder="E-mail" />
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small text-conecta" href="login">Retornar ao Login</a>
                        <button class="btn btn-conecta" name="submit" type="submit">Recuperar Senha</button>
                    </div>
                </form>
                <div class="card-footer text-center py-5">
                    <div class="small"><a style="color: #544b59; font-weight: 700;" href="tipocadastro">Não tem conta? Cadastre-se já</a></div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/standart.js"></script>
</body>

</html>