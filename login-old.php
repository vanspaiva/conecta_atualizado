<!DOCTYPE html>
<html lang="pt-br">
<?php include("php/head_login.php"); ?>

<body class="bg-conecta">
    <style>
        .btn-conecta {
            color: #fff;
            background-color: var(--orange);
            border-color: var(--orange);
        }

        .btn-conecta:hover {
            color: #fff;
            background-color: orangered;
            border-color: orangered;
        }

        .btn-conecta:focus,
        .btn-conecta.focus {
            color: #fff;
            background-color: orangered;
            border-color: orangered;
            box-shadow: 0 0 0 0.2rem rgba(76, 76, 77, 0.5);
        }

        .btn-conecta.disabled,
        .btn-conecta:disabled {
            color: #fff;
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .btn-conecta:not(:disabled):not(.disabled):active,
        .btn-conecta:not(:disabled):not(.disabled).active,
        .show>.btn-conecta.dropdown-toggle {
            color: #fff;
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .btn-conecta:not(:disabled):not(.disabled):active:focus,
        .btn-conecta:not(:disabled):not(.disabled).active:focus,
        .show>.btn-conecta.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(37, 42, 48, 0.5);
        }


        .text-conecta {
            color: var(--orange) !important;
        }

        a.text-conecta:hover,
        a.text-conecta:focus {
            color: orangered !important;
        }

        .text-white {
            color: #fff !important;
        }

        a.text-white:hover,
        a.text-white:focus {
            color: #000 !important;
        }
    </style>

    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm col col-lg-5 top-15">
                    <div class="">
                        <div class="row justify-content-center mb-6 mt-auto p-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="290.219" height="163.142" viewBox="0 0 290.219 163.142">
                                <g id="Logo_-_conecta" data-name="Logo - conecta" transform="translate(0)">
                                    <path id="Caminho_2083" data-name="Caminho 2083" d="M2089.392,2040.708c1.907,0,3.813-.013,5.718,0,2.317.019,3.226.885,3.237,3.125.018,3.953-.065,7.908.032,11.86.052,2.1-1.041,3.083-2.868,3.136-4.092.117-8.187.043-12.281.026a2.707,2.707,0,0,1-2.98-3.029c-.032-4.023-.109-8.05.026-12.067.076-2.252,1.135-3.039,3.4-3.051C2085.58,2040.7,2087.486,2040.707,2089.392,2040.708Z" transform="translate(-2028.578 -2025.317)" fill="#fff" />
                                    <path id="Caminho_2084" data-name="Caminho 2084" d="M2051.418,2136.335c-1.131,0-2.269-.08-3.392.018-2.1.185-2.746-.868-2.678-2.78.07-1.977.026-3.958.01-5.937a5.109,5.109,0,0,0-5.481-5.467c-.636,0-1.276-.039-1.908.007-1.984.145-2.785-.71-2.77-2.735.037-4.818-.022-4.7,4.872-4.864,2.207-.075,3.05.548,2.722,2.764a6,6,0,0,0,2.147,6.022,5.327,5.327,0,0,0,3.619,1.426c2.189-.078,4.383.021,6.573-.026,1.592-.035,2.343.666,2.331,2.253-.015,2.333-.025,4.666.007,7,.021,1.692-.743,2.439-2.447,2.336C2053.825,2136.275,2052.619,2136.334,2051.418,2136.335Z" transform="translate(-2027.709 -2026.744)" fill="#fff" />
                                    <path id="Caminho_2085" data-name="Caminho 2085" d="M2063.383,2069.171c5.372,0,5.4,0,5.365,5.278-.045,6.875.73,5.686-5.872,5.786-5.467.084-5.275.307-5.224-5.3C2057.712,2068.387,2056.881,2069.237,2063.383,2069.171Z" transform="translate(-2028.142 -2025.867)" fill="#fff" />
                                    <path id="Caminho_2086" data-name="Caminho 2086" d="M2035.79,2078.953c-.635,0-1.272-.037-1.9.006-1.317.088-1.911-.542-2.054-1.816-.628-5.556,1.143-7.172,6.672-6.076a1.431,1.431,0,0,1,1.324,1.391c.055.772.03,1.551.03,2.326C2039.862,2078.955,2039.861,2078.955,2035.79,2078.953Z" transform="translate(-2027.641 -2025.897)" fill="#fff" />
                                    <path id="Caminho_2087" data-name="Caminho 2087" d="M2107.658,2030.628c-.025,4.364.543,4.15-4.038,4.143-3.612,0-3.65,0-3.6-3.771.054-4.222-.9-4.145,3.987-4.141C2107.657,2026.861,2107.657,2026.86,2107.658,2030.628Z" transform="translate(-2028.961 -2025.049)" fill="#fff" />
                                    <path id="Caminho_2088" data-name="Caminho 2088" d="M2042.757,2145.473c0,.7-.025,1.407,0,2.107.056,1.336-.6,1.941-1.9,1.924-6.921-.092-5.656.964-5.877-5.481-.068-1.965.67-2.711,2.544-2.546.417.036.843,0,1.264,0C2042.758,2141.482,2042.758,2141.482,2042.757,2145.473Z" transform="translate(-2027.704 -2027.263)" fill="#fff" />
                                    <path id="Caminho_2089" data-name="Caminho 2089" d="M2034.481,2053.341c0,2.973,0,2.973-2.955,2.972-3.281,0-3.281,0-3.275-3.174.006-2.922.006-2.922,3.37-2.922C2034.481,2050.217,2034.481,2050.217,2034.481,2053.341Z" transform="translate(-2027.574 -2025.5)" fill="#fff" />
                                    <path id="Caminho_2090" data-name="Caminho 2090" d="M2147.959,2046.468c0,3.1,0,3.1-2.876,3.1-2.942,0-2.965-.024-2.962-3.167,0-2.95.041-2.99,2.92-2.987C2147.96,2043.418,2147.96,2043.418,2147.959,2046.468Z" transform="translate(-2029.775 -2025.369)" fill="#fff" />
                                    <path id="Caminho_2091" data-name="Caminho 2091" d="M2067.481,2028.077c.1-3.417-.576-3.023,3.71-3.062,2.406-.021,2.406.008,2.387,3.383-.014,2.719-.014,2.719-3.376,2.7C2067.467,2031.092,2067.467,2031.092,2067.481,2028.077Z" transform="translate(-2028.332 -2025.013)" fill="#fff" />
                                    <path id="Caminho_2092" data-name="Caminho 2092" d="M2129.743,2032.631c0,2.766,0,2.766-3.024,2.765-2.815,0-2.815,0-2.816-2.9,0-2.963,0-2.978,3.072-2.954C2130.37,2029.574,2129.667,2029.392,2129.743,2032.631Z" transform="translate(-2029.423 -2025.101)" fill="#fff" />
                                    <path id="Caminho_2093" data-name="Caminho 2093" d="M2030.292,2111.9c-2.17.559-2.685-.4-2.729-2.5-.047-2.275.857-2.548,2.824-2.6,2.144-.059,2.685.57,2.723,2.681C2033.153,2111.747,2032.338,2112.363,2030.292,2111.9Z" transform="translate(-2027.562 -2026.594)" fill="#fff" />
                                    <path id="Caminho_2098" data-name="Caminho 2098" d="M2165.156,2142.315a35.675,35.675,0,1,1-1.558-39.191h31.9a62.137,62.137,0,0,0-10.766-19.466,65.585,65.585,0,0,0-41.021-23.913c-3.44-.6-5.279-2.678-5.344-6.283-.034-1.822-.855-2.719-2.694-2.709-3.251.015-6.5-.033-9.754.021a4.465,4.465,0,0,1-2.925-.949c-2.613-1.978-4.7-4.175-4.144-7.845a19.564,19.564,0,0,0,.015-3.177,1.778,1.778,0,0,0-1.936-2q-3.075-.029-6.149,0c-1.217.011-1.763.633-1.727,1.874.049,1.695.006,3.392.008,5.089,0,3.159.006,3.233,3.167,3.14,3.27-.1,6.3-.157,8.663,2.919,2.115,2.754,2.48,9.574.244,12.254-2.092,2.506-4.925,3.115-7.906,3.172-5.3.1-10.6.029-15.9.029q-8.058,0-16.116,0a7.4,7.4,0,0,1-5.632-2.305q-5.734-5.936-11.672-11.672a7.318,7.318,0,0,1-2.338-5.806c.06-2.686.037-5.373,0-8.059-.033-2.432-.793-3.2-3.132-3.209-3.394-.016-6.787.027-10.18-.015-1.917-.024-2.877.743-2.847,2.754.055,3.532,0,7.066.02,10.6.013,2.407.691,3.053,3.181,3.085,2.968.039,5.939.142,8.9.05a6,6,0,0,1,4.606,2.026c3.3,3.264,6.682,6.447,9.9,9.788,1.985,2.061,4.393,3.9,4.157,7.354-.192,2.813-.062,5.653.008,8.478.073,2.986,1.371,4.213,4.309,4.225,1.626.007,3.252,0,4.878.006a2.331,2.331,0,0,1,2.563,2.47c.08,1.551.026,3.109.031,4.664.008,2.979.431,3.493,3.386,3.486,1.824,0,2.75.479,2.525,2.534-.253,2.3.939,5.359-.428,6.753-1.477,1.5-4.564.281-6.928.523-1.845.187-2.489-.549-2.537-2.353-.07-2.651-.349-2.833-3.017-2.838-6.432-.012-12.865.016-19.3-.019a6.315,6.315,0,0,1-6.6-6.543c-.011-1.979,0-3.958-.011-5.937-.009-1.579-.764-2.561-2.384-2.6-2.613-.056-5.23-.046-7.845,0a1.822,1.822,0,0,0-2.008,2.131c.061,2.756.043,5.513,0,8.269-.022,1.55.741,2.166,2.2,2.154,1.908-.015,3.817-.006,5.725,0,4.445.005,6.653,2.193,6.684,6.67.027,3.746-.006,7.493.014,11.239.016,3.109.657,3.762,3.688,3.769,5.725.012,11.45,0,17.176.014a8.717,8.717,0,0,1,5.583,1.982,10.952,10.952,0,0,1,2.777,11.9c-1.689,4-4.244,5.729-9.233,5.752-4.524.022-9.049-.04-13.572.034-2.9.048-4.381,1.615-4.389,4.448q-.025,8.162,0,16.327c.011,2.753,1.315,4.133,4.066,4.186,3.6.071,7.21-.011,10.814.042a14.435,14.435,0,0,1,11.472,5.2,54.57,54.57,0,0,0,12.666,11.032,62.652,62.652,0,0,0,35.246,10.463,65.638,65.638,0,0,0,16.923-2.013,71.285,71.285,0,0,0,14.146-5.685,64.039,64.039,0,0,0,31.336-38.314Zm-37.412-76.854c4.993.04,4.511-.822,4.54,4.46.023,4.3.006,4.3-4.312,4.3h-.212c-4.567,0-4.318.41-4.3-4.388C2123.447,2064.878,2123.251,2065.426,2127.744,2065.461Zm-34.646,80.4c0,1.269-.046,2.541.009,3.808.08,1.816-.815,2.536-2.548,2.516-2.54-.031-5.078-.023-7.617-.005-1.642.012-2.46-.711-2.431-2.412.044-2.609.067-5.221,0-7.828a2.053,2.053,0,0,1,2.232-2.423c2.679-.062,5.361-.057,8.04-.016a2.118,2.118,0,0,1,2.334,2.553C2093.044,2143.316,2093.1,2144.589,2093.1,2145.858Zm10.5-63.193c3.377,0,3.378,0,3.378,3.336,0,2.955,0,2.955-3.17,2.955-3.049,0-3.05,0-3.051-3.258C2100.752,2082.688,2100.776,2082.663,2103.6,2082.665Zm-9.709-1.836c-5.966.025-5.145.206-5.163-5.251-.018-4.922,0-4.922,4.99-4.922,5.2,0,5.2,0,5.2,5.1C2098.764,2081.1,2100.12,2080.8,2093.889,2080.829Z" transform="translate(-2027.856 -2025.191)" fill="#fff" />
                                    <g id="Grupo_819" data-name="Grupo 819" transform="translate(83.891 76.463)">
                                        <path id="Caminho_2099" data-name="Caminho 2099" d="M2113.106,2125.269c0-12.4,9.571-21.21,22.665-21.21s22.589,8.805,22.589,21.21-9.5,21.209-22.589,21.209S2113.106,2137.673,2113.106,2125.269Zm33.154,0c0-7.121-4.517-11.409-10.49-11.409s-10.566,4.288-10.566,11.409,4.594,11.408,10.566,11.408S2146.26,2132.39,2146.26,2125.269Z" transform="translate(-2113.106 -2103.003)" fill="#fff" />
                                        <path id="Caminho_2100" data-name="Caminho 2100" d="M2198.122,2121.77v16.476h-8.345v-15.193c0-4.653-2.139-6.793-5.831-6.793-4.011,0-6.9,2.46-6.9,7.756v14.23H2168.7v-28.779h7.97v3.369a12.6,12.6,0,0,1,9.522-3.8C2192.986,2109.038,2198.122,2113,2198.122,2121.77Z" transform="translate(-2114.18 -2103.1)" fill="#fff" />
                                        <path id="Caminho_2101" data-name="Caminho 2101" d="M2234.707,2126.209h-21.771c.8,3.584,3.851,5.778,8.238,5.778a9.754,9.754,0,0,0,7.221-2.782l4.44,4.815c-2.675,3.05-6.687,4.654-11.875,4.654-9.95,0-16.423-6.259-16.423-14.817,0-8.612,6.581-14.818,15.354-14.818,8.452,0,14.978,5.67,14.978,14.925C2234.867,2124.605,2234.76,2125.515,2234.707,2126.209Zm-21.878-4.868H2227a7.188,7.188,0,0,0-14.176,0Z" transform="translate(-2114.873 -2103.1)" fill="#fff" />
                                        <path id="Caminho_2102" data-name="Caminho 2102" d="M2238.954,2123.856c0-8.666,6.687-14.818,16.049-14.818,6.045,0,10.8,2.621,12.892,7.329l-6.474,3.477a7.176,7.176,0,0,0-6.472-3.959c-4.226,0-7.543,2.943-7.543,7.971s3.317,7.97,7.543,7.97a7.08,7.08,0,0,0,6.472-3.958l6.474,3.53c-2.087,4.6-6.847,7.275-12.892,7.275C2245.641,2138.673,2238.954,2132.521,2238.954,2123.856Z" transform="translate(-2115.538 -2103.1)" fill="#fff" />
                                        <path id="Caminho_2103" data-name="Caminho 2103" d="M2292.3,2136.738a11.926,11.926,0,0,1-6.794,1.818c-6.794,0-10.752-3.477-10.752-10.323V2116.41h-4.44v-6.419h4.44v-7.008h8.345v7.008h7.169v6.419H2283.1v11.716c0,2.46,1.338,3.8,3.585,3.8a5.626,5.626,0,0,0,3.37-1.07Z" transform="translate(-2116.144 -2102.983)" fill="#fff" />
                                        <path id="Caminho_2104" data-name="Caminho 2104" d="M2322.961,2121.823v16.423h-7.81v-3.584c-1.552,2.622-4.547,4.011-8.773,4.011-6.74,0-10.752-3.744-10.752-8.719,0-5.082,3.584-8.612,12.357-8.612h6.633c0-3.584-2.14-5.67-6.633-5.67a13.837,13.837,0,0,0-8.292,2.675l-3-5.831c3.156-2.247,7.81-3.478,12.41-3.478C2317.88,2109.038,2322.961,2113.1,2322.961,2121.823Zm-8.344,7.329v-2.942h-5.724c-3.905,0-5.135,1.445-5.135,3.37,0,2.086,1.765,3.477,4.706,3.477C2311.247,2133.057,2313.653,2131.773,2314.617,2129.152Z" transform="translate(-2116.634 -2103.1)" fill="#fff" />
                                    </g>
                                </g>
                            </svg>

                        </div>
                        <div class="card-body mt-5">
                            <form action="includes/login.inc.php" method="post">
                                <div class="form-group">
                                    <input id="login-input-1" class="form-control py-4" name="uid" type="text" placeholder="E-mail/Usuário" />
                                </div>

                                <div class="input-group mb-3">
                                    <input id="login-input-2" class="form-control py-4" name="pwd" type="password" placeholder="Senha" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button onclick="showPass()" class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>

                                <div class="form-group d-flex align-items-center justify-content-end mt-4 mb-0">
                                    <button class="btn btn-conecta" type="submit" name="submit" id="login">Login</button>
                                </div>
                            </form>
                            <script>
                                $('#login-input-2').keyup(function(e) {
                                    if (e.keyCode == 13) {
                                        $('#login').click();
                                    }
                                });
                            </script>

                            <div>
                                <?php
                                if (isset($_GET["error"])) {
                                    if ($_GET["error"] == "emptyinput") {
                                        echo "<div class='my-3 alert alert-danger p-3 text-center'>Preencha todos os campos!</div>";
                                    } else if ($_GET["error"] == "wronglogin") {
                                        echo "<div class='my-3 alert alert-danger p-3 text-center'>Usuário/E-mail ou senha errados, tente novamente!</div>";
                                    } else if ($_GET["error"] == "waitaprov") {
                                        //echo "<div id='red-warning'></div>";

                                        //Pop-up
                                        echo "
                                                            <div class='modal-dialog'  name='myModal' tabindex='-1' role='dialog'>
                                                                <div class='modal-content'>
                                                                    <div class='modal-header'>
                                                                        <h5 class='modal-title' id='exampleModalLabel'>Cadastro Pendente</h5>
                                                                        
                                                                        
                                                                        </button>
                                                                    </div>
                                                                    <div class='modal-body'>
                                                                        <p>Cadastro em processo de validação, enviaremos no seu número cadastrado o link para seu 1º acesso.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        ";
                                    } else if ($_GET["error"] == "bloquser") {
                                        //echo "<div id='red-warning'></div>";

                                        //Pop-up
                                        echo "
                                                            <div class='modal-dialog'  name='myModal' tabindex='-1' role='dialog'>
                                                                <div class='modal-content'>
                                                                    <div class='modal-header'>
                                                                        <h5 class='modal-title' id='exampleModalLabel'>Usuário Bloqueado</h5>
                                                                        
                                                                        
                                                                        </button>
                                                                    </div>
                                                                    <div class='modal-body'>
                                                                        <p>Detectamos algumas atividades suspeitas e sua conta foi bloqueada. Caso ache que tenha havido algum engano entre em contato conosco.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        ";
                                    }
                                }
                                ?>
                            </div>
                            <div class="d-flex justify-content-center py-2 my-4 text-white">
                                <div class=""><a href="tipocadastro" class="btn btn-outline-light text-white">Não tem uma conta? Cadastre-se</a></div>

                            </div>

                            <div class="text-center py-1">
                                <div class=""><a href="senha" class="text-conecta">Esqueceu sua senha? Recuperar</a></div>
                            </div>
                            <div class="py-3"></div>
                        </div>
                    </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>