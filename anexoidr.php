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
    <style>
        #canvasDiv {
            position: relative;
            border: 2px dashed grey;
            height: 100px;
            width: 50%;
        }
    </style>

    <?php
    require_once 'includes/dbh.inc.php';

    // set the default timezone to use.
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $data_criacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    if (isset($_SESSION["useruid"])) {

        $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
        while ($row = mysqli_fetch_array($ret)) {

            $tpconta = $_SESSION["userperm"];
            $user = $_SESSION["useruid"];

            if ($tpconta == 'Doutor(a)') {
                $nome = $row["usersName"];
                $crm = $row["usersCrm"];
                $telefone = $row["usersFone"];
                $email = $row["usersEmail"];
            } else {
                $nome = "";
                $crm = "";
                $telefone = "";
                $email = "";
            }
        }

        //pesquisar anexoidr
        $retanexoidr = mysqli_query($conn, "SELECT * FROM qualianexoidr WHERE xidrIdProjeto='$pedID';");
        while ($rowanexoidr = mysqli_fetch_array($retanexoidr)) {
            $statusAnexoidr = $rowanexoidr['xidrStatusEnvio'];
            $statusQualidade = $rowanexoidr['xidrStatusQualidade'];

            switch ($statusAnexoidr) {
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
                    $comentarioReprov = $rowanexoidr['xidrComentariosQualidade'];
                    break;


                default:
                    $msgQualidade = 'erro';
                    $comentarioReprov = '';
                    break;
            }
        }

        if ($formType == 'abrir') {
    ?>

            <body class="bg-light-gray2" style="overflow-x: hidden;">

                <?php
                include_once 'php/navbar-dash.php';
                include_once 'php/lateral-nav.php';
                ?>

                <div class="conatiner">
                    <div class="row d-flex justify-content-center p-4">
                        <div class="col-md-8 py-4">
                            <h4 class="text-conecta text-center"><b>ANEXO I - TERMO DE RESPONSABILIDADE E ESCLARECIMENTO PARA A UTILIZAÇÃO EXCEPCIONAL DO DISPOSITIVO MÉDICO SOB MEDIDA DE FABRICAÇÃO NACIONAL</b></h4>
                            <p class="text-conecta text-center">Agência Nacional de Vigilância Sanitária - Anvisa </p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center p-4">
                        <div class="col-md-10">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="form">
                                        <form action="includes/sendanexoidr.inc.php" method="POST" enctype="multipart/form-data">
                                            <?php
                                            if ($msgQualidade == 'reprovado') {
                                                //mostrar FORM
                                            ?>
                                                <h4 class="text-center"><b>ANEXO I - TERMO DE RESPONSABILIDADE E ESCLARECIMENTO PARA A UTILIZAÇÃO EXCEPCIONAL DO DISPOSITIVO MÉDICO SOB MEDIDA DE FABRICAÇÃO NACIONAL</b></h4>
                                                <p class="text-center">Agência Nacional de Vigilância Sanitária - Anvisa </p>
                                                <div class="bg-light py-1">
                                                    <div class="card-body">
                                                        <p style="color: black; text-align: center;">Infelizmente seu documento foi reprovado! Leia atentamente as instruções e refaça o que for pedido!</p>
                                                        <span class="d-block p-2 border rounded">
                                                            obs: <?php echo $comentarioReprov; ?>
                                                        </span>
                                                    </div>
                                                </div>


                                            <?php
                                            }
                                            ?>
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
                                                <div class="my-3">
                                                    <h5 class="text-muted text-center"><b>A ser preenchido pelo profissional de saúde: </b></h5>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex d-block justify-content-around">
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="nome" class="form-label">Nome Dr(a).<b style="color: red;">*</b></label>
                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex d-block justify-content-around">
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="CRM" class="form-label">Nº Conselho <b style="color: red;">*</b></label>
                                                        <input type="text" class="form-control" id="CRM" name="CRM" value="<?php echo $crm; ?>">
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="tipocr" class="form-label">Conselho Profissional <b style="color: red;">*</b></label>
                                                        <select id="tipocr" name="tipocr" class="form-control">
                                                            <option value="0">Escolha uma opção</option>
                                                            <option value="de Medicina">de Medicina</option>
                                                            <option value="de Odontologia">de Odontologia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex d-block justify-content-around">
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="telefone" class="form-label">Telefone <b style="color: red;">*</b></label>
                                                        <input type="tel" class="form-control" id="telefone" name="telefone" value="<?php echo $telefone; ?>">
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="email" class="form-label">E-mail <b style="color: red;">*</b></label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex d-block justify-content-around">
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="nomepaciente" class="form-label">Nome Paciente <b style="color: red;">*</b></label>
                                                        <input type="text" class="form-control" id="nomepaciente" name="nomepaciente">
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="sexo" class="form-label">Sexo <b style="color: red;">*</b></label>
                                                        <select id="sexo" name="sexo" class="form-control">
                                                            <option value="0">Escolha uma opção</option>
                                                            <option value="Feminino">Feminino</option>
                                                            <option value="Masculino">Masculino</option>
                                                            <option value="Não Declarado">Não Declarado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex d-block justify-content-around">
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="idade" class="form-label">Idade <b style="color: red;">*</b></label>
                                                        <input type="number" class="form-control" id="idade" name="idade">
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="diagnostico" class="form-label">Diagnóstico <b style="color: red;">*</b></label>
                                                        <input type="text" class="form-control" id="diagnostico" name="diagnostico">
                                                    </div>
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="codigocid" class="form-label">Código CID <b style="color: red;">*</b></label>
                                                        <input type="text" class="form-control" id="codigocid" name="codigocid">
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="d-flex justify-content-center p-2 m-2">
                                                <div>
                                                    <label style="text-align: center;" class="form-label pl-5">Implantes para cirurgia <b style="color: red;">*</b></label>
                                                    <div class="form-group d-flex justify-content-center pl-5">
                                                        <div class="d-block">
                                                            <div class="form-group d-flex justify-content-between m-2">
                                                                <div class="form-check form-check-inline" style="width: 180px;">
                                                                    <input class="form-check-input" type="radio" name="radioImplante" id="ATM" value="ATM">
                                                                    <label class="form-check-label" for="ATM">ATM</label>
                                                                </div>
                                                                <div class="form-check form-check-inline" style="width: 180px;">
                                                                    <input class="form-check-input" type="radio" name="radioImplante" id="ATMBilateral" value="ATM Bilateral">
                                                                    <label class="form-check-label" for="ATMBilateral">ATM Bilateral</label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group d-flex justify-content-between m-2">
                                                                <div class="form-check form-check-inline" style="width: 180px;">
                                                                    <input class="form-check-input" type="radio" name="radioImplante" id="Reconstrucao" value="Reconstrução Facial">
                                                                    <label class="form-check-label" for="Reconstrucao">Reconstrução Facial</label>
                                                                </div>
                                                                <div class="form-check form-check-inline" style="width: 180px;">
                                                                    <input class="form-check-input" type="radio" name="radioImplante" id="Ortognatica" value="Ortognática">
                                                                    <label class="form-check-label" for="Ortognatica">Ortognática</label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group d-flex justify-content-between m-2">
                                                                <div class="form-check form-check-inline" style="width: 180px;">
                                                                    <input class="form-check-input" type="radio" name="radioImplante" id="Cranioplastia" value="Cranioplastia">
                                                                    <label class="form-check-label" for="Cranioplastia">Cranioplastia</label>
                                                                </div>
                                                                <div class="form-check form-check-inline" style="width: 180px;">
                                                                    <input class="form-check-input" type="radio" name="radioImplante" id="Coluna" value="Coluna">
                                                                    <label class="form-check-label" for="Coluna">Coluna</label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group d-flex justify-content-between m-2">
                                                                <div class="form-check form-check-inline" style="width: 180px;">
                                                                    <input class="form-check-input" type="radio" name="radioImplante" id="Ortopedia" value="Ortopedia">
                                                                    <label class="form-check-label" for="Ortopedia">Ortopedia</label>
                                                                </div>
                                                                <div class="form-check form-check-inline" style="width: 180px;">
                                                                    <input class="form-check-input" type="radio" name="radioImplante" id="CustomLIFE" value="CustomLIFE">
                                                                    <label class="form-check-label" for="CustomLIFE">CustomLIFE</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex d-block justify-content-around">
                                                    <div class="form-group d-inline-block flex-fill m-2">
                                                        <label for="cidade" class="form-label">Cidade <b style="color: red;">*</b></label>
                                                        <input type="text" class="form-control" id="cidade" name="cidade">
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

                                            <div class="form-group p-3">
                                                <div class="d-flex justify-content-start">
                                                    <div class="form-check form-check-inline p-2">
                                                        <input class="form-check-input" type="checkbox" name="termo" id="termo" value="termo" required>
                                                        <label class="form-check-label" for="termo">Declaro que li e concordo com os termos abaixo. <b style="color: red;">*</b></label>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p>Informei ao paciente/responsável legal que este produto não possui registro no Brasil, portanto não possui a sua segurança e eficácia avaliada pela Anvisa, podendo causar reações adversas inesperadas ao paciente.</p>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex justify-content-center">
                                                    <div id="canvasDiv"></div>

                                                </div>

                                                <div class="d-flex justify-content-center">
                                                    <button type="button" class="btn btn-link" id="reset-btn">limpar</button>
                                                </div>
                                                <!-- <input type="hidden" id="signature" name="signature">
                                                <input type="hidden" name="signaturesubmit" value="1"> -->
                                                <textarea id="signature64" name="signed" style="display: none"></textarea>
                                                <script>
                                                    var sig = $('#canvasDiv').signature({
                                                        syncField: '#signature64',
                                                        syncFormat: 'PNG'
                                                    });
                                                </script>
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
                        <p class="text-conecta small text-center">&copy; Conecta 2021</p>
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

                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
                <script>
                    $(document).ready(() => {
                        var canvasDiv = document.getElementById('canvasDiv');
                        var canvas = document.createElement('canvas');
                        canvas.setAttribute('id', 'canvas');
                        canvasDiv.appendChild(canvas);
                        $("#canvas").attr('height', $("#canvasDiv").outerHeight());
                        $("#canvas").attr('width', $("#canvasDiv").width());
                        if (typeof G_vmlCanvasManager != 'undefined') {
                            canvas = G_vmlCanvasManager.initElement(canvas);
                        }

                        context = canvas.getContext("2d");
                        $('#canvas').mousedown(function(e) {
                            var offset = $(this).offset()
                            var mouseX = e.pageX - this.offsetLeft;
                            var mouseY = e.pageY - this.offsetTop;

                            paint = true;
                            addClick(e.pageX - offset.left, e.pageY - offset.top);
                            redraw();
                        });

                        $('#canvas').mousemove(function(e) {
                            if (paint) {
                                var offset = $(this).offset()
                                //addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
                                addClick(e.pageX - offset.left, e.pageY - offset.top, true);
                                console.log(e.pageX, offset.left, e.pageY, offset.top);
                                redraw();
                            }
                        });

                        $('#canvas').mouseup(function(e) {
                            paint = false;
                        });

                        $('#canvas').mouseleave(function(e) {
                            paint = false;
                        });

                        var clickX = new Array();
                        var clickY = new Array();
                        var clickDrag = new Array();
                        var paint;

                        function addClick(x, y, dragging) {
                            clickX.push(x);
                            clickY.push(y);
                            clickDrag.push(dragging);
                        }

                        $("#reset-btn").click(function() {
                            context.clearRect(0, 0, window.innerWidth, window.innerWidth);
                            clickX = [];
                            clickY = [];
                            clickDrag = [];
                        });

                        $(document).on('click', '#btn-save', function() {
                            var mycanvas = document.getElementById('canvas');
                            var img = mycanvas.toDataURL("image/png");
                            anchor = $("#signature");
                            anchor.val(img);
                            $("#signatureform").submit();
                        });

                        var drawing = false;
                        var mousePos = {
                            x: 0,
                            y: 0
                        };
                        var lastPos = mousePos;

                        canvas.addEventListener("touchstart", function(e) {
                            mousePos = getTouchPos(canvas, e);
                            var touch = e.touches[0];
                            var mouseEvent = new MouseEvent("mousedown", {
                                clientX: touch.clientX,
                                clientY: touch.clientY
                            });
                            canvas.dispatchEvent(mouseEvent);
                        }, false);


                        canvas.addEventListener("touchend", function(e) {
                            var mouseEvent = new MouseEvent("mouseup", {});
                            canvas.dispatchEvent(mouseEvent);
                        }, false);


                        canvas.addEventListener("touchmove", function(e) {

                            var touch = e.touches[0];
                            var offset = $('#canvas').offset();
                            var mouseEvent = new MouseEvent("mousemove", {
                                clientX: touch.clientX,
                                clientY: touch.clientY
                            });
                            canvas.dispatchEvent(mouseEvent);
                        }, false);



                        // Get the position of a touch relative to the canvas
                        function getTouchPos(canvasDiv, touchEvent) {
                            var rect = canvasDiv.getBoundingClientRect();
                            return {
                                x: touchEvent.touches[0].clientX - rect.left,
                                y: touchEvent.touches[0].clientY - rect.top
                            };
                        }


                        var elem = document.getElementById("canvas");

                        var defaultPrevent = function(e) {
                            e.preventDefault();
                        }
                        elem.addEventListener("touchstart", defaultPrevent);
                        elem.addEventListener("touchmove", defaultPrevent);


                        function redraw() {
                            //
                            lastPos = mousePos;
                            for (var i = 0; i < clickX.length; i++) {
                                context.beginPath();
                                if (clickDrag[i] && i) {
                                    context.moveTo(clickX[i - 1], clickY[i - 1]);
                                } else {
                                    context.moveTo(clickX[i] - 1, clickY[i]);
                                }
                                context.lineTo(clickX[i], clickY[i]);
                                context.closePath();
                                context.stroke();
                            }
                        }
                    })
                </script>
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
                            <h4 class="text-conecta text-center"><b>ANEXO I - TERMO DE RESPONSABILIDADE E ESCLARECIMENTO PARA A UTILIZAÇÃO EXCEPCIONAL DO DISPOSITIVO MÉDICO SOB MEDIDA DE FABRICAÇÃO NACIONAL</b></h4>
                            <p class="text-conecta text-center">Agência Nacional de Vigilância Sanitária - Anvisa </p>
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
                                            <h4 class="text-center"><b>ANEXO I - TERMO DE RESPONSABILIDADE E ESCLARECIMENTO PARA A UTILIZAÇÃO EXCEPCIONAL DO DISPOSITIVO MÉDICO SOB MEDIDA DE FABRICAÇÃO NACIONAL</b></h4>
                                            <p class="text-center">Agência Nacional de Vigilância Sanitária - Anvisa </p>
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
                                            <h4 class="text-center"><b>ANEXO I - TERMO DE RESPONSABILIDADE E ESCLARECIMENTO PARA A UTILIZAÇÃO EXCEPCIONAL DO DISPOSITIVO MÉDICO SOB MEDIDA DE FABRICAÇÃO NACIONAL</b></h4>
                                            <p class="text-center">Agência Nacional de Vigilância Sanitária - Anvisa </p>
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
                                            <h4 class="text-center"><b>ANEXO I - TERMO DE RESPONSABILIDADE E ESCLARECIMENTO PARA A UTILIZAÇÃO EXCEPCIONAL DO DISPOSITIVO MÉDICO SOB MEDIDA DE FABRICAÇÃO NACIONAL</b></h4>
                                            <p class="text-center">Agência Nacional de Vigilância Sanitária - Anvisa </p>
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
                        <p class="text-conecta small text-center">&copy; Conecta 2021</p>
                        <p class="text-conecta small text-center"> Versão 1.0</p>
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

                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
                <script>
                    $(document).ready(() => {
                        var canvasDiv = document.getElementById('canvasDiv');
                        var canvas = document.createElement('canvas');
                        canvas.setAttribute('id', 'canvas');
                        canvasDiv.appendChild(canvas);
                        $("#canvas").attr('height', $("#canvasDiv").outerHeight());
                        $("#canvas").attr('width', $("#canvasDiv").width());
                        if (typeof G_vmlCanvasManager != 'undefined') {
                            canvas = G_vmlCanvasManager.initElement(canvas);
                        }

                        context = canvas.getContext("2d");
                        $('#canvas').mousedown(function(e) {
                            var offset = $(this).offset()
                            var mouseX = e.pageX - this.offsetLeft;
                            var mouseY = e.pageY - this.offsetTop;

                            paint = true;
                            addClick(e.pageX - offset.left, e.pageY - offset.top);
                            redraw();
                        });

                        $('#canvas').mousemove(function(e) {
                            if (paint) {
                                var offset = $(this).offset()
                                //addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
                                addClick(e.pageX - offset.left, e.pageY - offset.top, true);
                                console.log(e.pageX, offset.left, e.pageY, offset.top);
                                redraw();
                            }
                        });

                        $('#canvas').mouseup(function(e) {
                            paint = false;
                        });

                        $('#canvas').mouseleave(function(e) {
                            paint = false;
                        });

                        var clickX = new Array();
                        var clickY = new Array();
                        var clickDrag = new Array();
                        var paint;

                        function addClick(x, y, dragging) {
                            clickX.push(x);
                            clickY.push(y);
                            clickDrag.push(dragging);
                        }

                        $("#reset-btn").click(function() {
                            context.clearRect(0, 0, window.innerWidth, window.innerWidth);
                            clickX = [];
                            clickY = [];
                            clickDrag = [];
                        });

                        $(document).on('click', '#btn-save', function() {
                            var mycanvas = document.getElementById('canvas');
                            var img = mycanvas.toDataURL("image/png");
                            anchor = $("#signature");
                            anchor.val(img);
                            $("#signatureform").submit();
                        });

                        var drawing = false;
                        var mousePos = {
                            x: 0,
                            y: 0
                        };
                        var lastPos = mousePos;

                        canvas.addEventListener("touchstart", function(e) {
                            mousePos = getTouchPos(canvas, e);
                            var touch = e.touches[0];
                            var mouseEvent = new MouseEvent("mousedown", {
                                clientX: touch.clientX,
                                clientY: touch.clientY
                            });
                            canvas.dispatchEvent(mouseEvent);
                        }, false);


                        canvas.addEventListener("touchend", function(e) {
                            var mouseEvent = new MouseEvent("mouseup", {});
                            canvas.dispatchEvent(mouseEvent);
                        }, false);


                        canvas.addEventListener("touchmove", function(e) {

                            var touch = e.touches[0];
                            var offset = $('#canvas').offset();
                            var mouseEvent = new MouseEvent("mousemove", {
                                clientX: touch.clientX,
                                clientY: touch.clientY
                            });
                            canvas.dispatchEvent(mouseEvent);
                        }, false);



                        // Get the position of a touch relative to the canvas
                        function getTouchPos(canvasDiv, touchEvent) {
                            var rect = canvasDiv.getBoundingClientRect();
                            return {
                                x: touchEvent.touches[0].clientX - rect.left,
                                y: touchEvent.touches[0].clientY - rect.top
                            };
                        }


                        var elem = document.getElementById("canvas");

                        var defaultPrevent = function(e) {
                            e.preventDefault();
                        }
                        elem.addEventListener("touchstart", defaultPrevent);
                        elem.addEventListener("touchmove", defaultPrevent);


                        function redraw() {
                            //
                            lastPos = mousePos;
                            for (var i = 0; i < clickX.length; i++) {
                                context.beginPath();
                                if (clickDrag[i] && i) {
                                    context.moveTo(clickX[i - 1], clickY[i - 1]);
                                } else {
                                    context.moveTo(clickX[i] - 1, clickY[i]);
                                }
                                context.lineTo(clickX[i], clickY[i]);
                                context.closePath();
                                context.stroke();
                            }
                        }
                    })
                </script>
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