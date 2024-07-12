<?php
session_start();
if ($_GET['id'] != null) {
    $pedID = $_GET['id'];
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Conecta 2.0 - Portal Drs</title>
        <!--Ícone da página-->
        <link rel="shortcut icon" href="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3aa8b67c896baaa57f51d102751de9ee.png" />
        <link href="css/reset.css" rel="stylesheet" />
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->
        <link href="css/system.css" rel="stylesheet" />
        <link href="css/jquery-ui.css" rel="stylesheet" />
        <!-- Bootstrap -->
        <link rel="stylesheet" href="src/css/bootstrap.min.css" />
        <link rel="stylesheet" href="src/js/bootstrap.min.js" />
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->

    </head>

    <?php
    require_once 'includes/dbh.inc.php';

    if (isset($_SESSION["useruid"])) {

        $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
        while ($row = mysqli_fetch_array($ret)) {

            $tpconta = $_SESSION["userperm"];
            $user = $_SESSION["useruid"];

            if ($tpconta == 'Paciente') {
                $nome = $row["usersName"];
            } else {
                $nome = "";
            }
        }

        //pesquisar anexoiiipac
        $retanexoiiipac = mysqli_query($conn, "SELECT * FROM qualianexoiiipac WHERE xiiipacIdProjeto='$pedID';");
        while ($rowanexoiiipac = mysqli_fetch_array($retanexoiiipac)) {
            $statusAnexoiiipac = $rowanexoiiipac['xiiipacStatusEnvio'];
            $statusQualidade = $rowanexoiiipac['xiiipacStatusQualidade'];

            switch ($statusAnexoiiipac) {
                case 'VAZIO':
                    $formType = 'abrir';
                    break;

                case 'ENVIADO':
                    $formType = 'verificar';
                    break;

                case 'EDITAR':
                    $formType = 'abrir';
                    break;

                case 'EDITADO':
                    $formType = 'verificar';
                    break;

                default:
                    $formType = 'verificar';
                    break;
            }

            switch ($statusQualidade) {
                case 'EM ANÁLISE':
                    $msgQualidade = 'analisando';
                    $comentarioReprov = '';
                    break;

                case 'APROVADO':
                    $msgQualidade = 'aprovado';
                    $comentarioReprov = '';
                    break;

                case 'REPROVADO':
                    $msgQualidade = 'reprovado';
                    $comentarioReprov = $rowanexoiiipac['xiiipacComentariosQualidade'];
                    break;


                default:
                    $msgQualidade = 'erro';
                    $comentarioReprov = '';
                    break;
            }
        }

        if ($formType == 'abrir') {
    ?>

            <body class="bg-conecta" style="overflow-x: hidden;">

                <?php
                include_once 'php/navbar-dash.php';
                include_once 'php/lateral-nav.php';
                ?>

                <div class="conatiner">
                    <div class="row d-flex justify-content-center p-4">
                        <div class="col-md-8 py-4">
                            <h4 class="text-white text-center"><b>ANEXO III - TERMO DE CONSENTIMENTO DE INFORMAÇÕES E IMAGENS PACIENTE</b></h4>
                            <p class="text-white text-center">Agência Nacional de Vigilância Sanitária - Anvisa </p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center p-4">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form">
                                        <form action="includes/sendanexoiiipac.inc.php" method="POST">
                                            <div hidden>
                                                <div class="d-flex d-block justify-content-around">
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label class="control-label" style="color:black;">Usuário</label>
                                                        <input class="form-control" name="nomecriador" type="text" value="<?php echo $user; ?>" readonly>
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label class="control-label" style="color:black;">Tipo de Conta</label>
                                                        <input class="form-control" name="tp_contacriador" type="text" value="<?php echo $tpconta; ?>" readonly />
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label class="control-label" style="color:black;">Data Criação</label>
                                                        <input class="form-control" name="dtcriacao" type="text" value="<?php echo $data_criacao; ?>" readonly>
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label class="control-label" style="color:black;">ID Pojeto</label>
                                                        <input class="form-control" name="docid" type="text" value="<?php echo $_GET['id']; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="my-3 py-4">
                                                    <h5 class="text-muted text-center pb-3"><b>Termo de consentimento a ser autorizado pelo médico(a) e paciente:</b></h5>
                                                    <p class="text-black">Por meio do presente termo, de livre e espontânea vontade, AUTORIZO a empresa fabricante CPMH do implante Sob Medida o uso de meus dados e qualquer outra informação que seja necessário para o processo junto a ANVISA, transitando os dados necessários e que os mesmos serão armazenados pela empresa e autorizo também o uso de minha imagem, mantendo o sigilo da minha identidade, livre de quaisquer ônus para a empresa fornecedora dos materiais cirúrgicos, CPMH – COMÉRCIO E INDÚSTRIA DE PRODUTOS MÉDICO–HOSPITALARES E ODONTOLÓGICOS LTDA, com o propósito de consulta profissional, pesquisas, literatura específica da área médica e mídias da empresa fabricante., sendo concedida à título gratuito. Sendo de minha vontade, declaro a autorização do uso acima descrito sem nenhuma reclamação de direitos, podendo o cirurgião responsável também fazer uso das imagens para o mesmo fim.</p>
                                                    <h5 class="text-muted text-center pb-3"><b>Termo aditivo exclusivo para Produtos/Implantes Personalizados:</b></h5>
                                                    <p class="text-black">Declaro ainda, ter ciência de que um técnico habilitado em saúde (enfermeiro/instrumentador) da equipe CPMH poderá acompanhar a cirurgia a fim de prestar instruções quanto ao uso do implante Sob Medida.</p>
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex d-block justify-content-around">
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="nomepac" class="form-label">Nome Paciente <b style="color: red;">*</b></label>
                                                        <input type="text" class="form-control" id="nomepac" name="nomepac" value="<?php echo $nome; ?>">
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="data" class="form-label">Data <b style="color: red;">*</b></label>
                                                        <input type="date" class="form-control" id="data" name="data">
                                                    </div>
                                                    <script>
                                                        $(document).ready(function() {
                                                            var now = new Date();
                                                            var month = (now.getMonth() + 1);
                                                            var day = now.getDate();
                                                            if (month < 10)
                                                                month = "0" + month;
                                                            if (day < 10)
                                                                day = "0" + day;
                                                            var today = now.getFullYear() + '-' + month + '-' + day;
                                                            $('#data').val(today);
                                                        });
                                                    </script>
                                                </div>
                                            </div>

                                            <div class="py-4 col d-flex justify-content-center">
                                                <button class="btn btn-conecta" type="submit" name="submit" id="submit">Enviar</button>
                                            </div>

                                    </div>


                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                </div>



                <!-- GetButton.io widget -->
                <script type="text/javascript">
                    (function() {
                        var options = {
                            whatsapp: "+55 61 99946-8880", // WhatsApp number
                            call_to_action: "Enviar uma mensagem", // Call to action
                            position: "right", // Position may be 'right' or 'left'
                            pre_filled_message: "Olá! Vim do Conecta 2.0, estou precisando de ajuda", // WhatsApp pre-filled message
                        };
                        var proto = document.location.protocol,
                            host = "getbutton.io",
                            url = proto + "//static." + host;
                        var s = document.createElement('script');
                        s.type = 'text/javascript';
                        s.async = true;
                        s.src = url + '/widget-send-button/js/init.js';
                        s.onload = function() {
                            WhWidgetSendButton.init(host, proto, options);
                        };
                        var x = document.getElementsByTagName('script')[0];
                        x.parentNode.insertBefore(s, x);
                    })();

                    // $(document).ready(function() {
                    //     document.getElementById("mySidenav").style.width = "200px";
                    // });
                </script>
                <!-- /GetButton.io widget -->

                <footer class="footer mt-5 py-3 bg-conecta">
                    <div class="container">
                        <p class="text-white small text-center">&copy; Conecta 2021</p>
                    </div>
                </footer>
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

        <?php
        } else if ($formType == 'verificar') {
        ?>

            <body class="bg-conecta" style="overflow-x: hidden;">

                <?php
                include_once 'php/navbar-dash.php';
                include_once 'php/lateral-nav.php';
                ?>

                <div class="conatiner">
                    <div class="row d-flex justify-content-center p-4">
                        <div class="col-md-8 py-4">
                            <h4 class="text-white text-center"><b>ANEXO III - TERMO DE CONSENTIMENTO DE INFORMAÇÕES E IMAGENS DR(A).</b></h4>
                            <p class="text-white text-center">Agência Nacional de Vigilância Sanitária - Anvisa </p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center p-4">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form">
                                        <?php
                                        if ($msgQualidade == 'analisando') {
                                        ?>

                                            <div class="bg-light py-1">
                                                <div class="card-body">
                                                    <p style="color: black; text-align: center;">Seu documento já foi enviado e agora está em processo de análise. Por favor aguarde notificação para dar continuidade ao seu processo.</p>
                                                </div>
                                                <span class="d-flex justify-content-center py-2" style="color: silver;"><i class="far fa-clock fa-5x"></i></span>
                                            </div>

                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if ($msgQualidade == 'aprovado') {
                                        ?>

                                            <div class="bg-light py-1">
                                                <div class="card-body">
                                                    <p style="color: black; text-align: center;">Parabéns! Seu documento foi aprovado. Aguarde notificação para dar continuidade ao seu processo.</p>
                                                    <span class="d-flex justify-content-center py-2" style="color: green;"><i class="fas fa-check-double fa-5x"></i></span>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if ($msgQualidade == 'erro') {
                                        ?>

                                            <div class="bg-light py-1">
                                                <div class="card-body">
                                                    <p style="color: black; text-align: center;">Desculpe! Algo deu errado. Aguarde o sistema voltar a normalidade ou entre em contato com o suporte.</p>
                                                    <span class="d-flex justify-content-center py-2" style="color: #ffc107;"><i class="fas fa-exclamation-triangle fa-5x"></i></span>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- GetButton.io widget -->
                <script type="text/javascript">
                    (function() {
                        var options = {
                            whatsapp: "+55 61 99946-8880", // WhatsApp number
                            call_to_action: "Enviar uma mensagem", // Call to action
                            position: "right", // Position may be 'right' or 'left'
                            pre_filled_message: "Olá! Vim do Conecta 2.0, estou precisando de ajuda", // WhatsApp pre-filled message
                        };
                        var proto = document.location.protocol,
                            host = "getbutton.io",
                            url = proto + "//static." + host;
                        var s = document.createElement('script');
                        s.type = 'text/javascript';
                        s.async = true;
                        s.src = url + '/widget-send-button/js/init.js';
                        s.onload = function() {
                            WhWidgetSendButton.init(host, proto, options);
                        };
                        var x = document.getElementsByTagName('script')[0];
                        x.parentNode.insertBefore(s, x);
                    })();

                    // $(document).ready(function() {
                    //     document.getElementById("mySidenav").style.width = "200px";
                    // });
                </script>
                <!-- /GetButton.io widget -->

                <footer class="footer mt-5 py-3 bg-conecta">
                    <div class="container">
                        <p class="text-white small text-center">&copy; Conecta 2021</p>
                        <p class="text-white small text-center"> Versão 1.0</p>
                    </div>
                </footer>

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
        <?php
        }
        ?>

    </html>


<?php

    } else {
        header("location: index");
        exit();
    }
} else {
    header("location: index");
    exit();
}



?>