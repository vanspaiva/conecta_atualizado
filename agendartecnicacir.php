<?php
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
?>
    <style>
        hr.solid {
            border-top: 3px solid #6c757d;
        }

        .offset-row-2 {
            margin-top: -20px;
            width: max-content;
            background-color: #fff;
            padding: 0px 15px;
            z-index: 1;
        }

        .line-heading {
            margin-top: 10vh;
            margin-bottom: 5vh;
        }
    </style>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <!--<iframe src="https://docs.google.com/viewer?embedded=true&url=https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/02/portfolio-cpmh-resumido.pdf" style="width: 100%; height: 100vh; border: none;"></iframe>-->
        <div id="main" class="font-montserrat">

            <div class="container-fluid">

                <div class="row mb-2">
                    <div class="col">
                        <h2 class="text-conecta" style="font-weight: 400;">Agendar Vídeo <span style="font-weight: 700;">Técnica Cirúrgica</span></h2>
                        <hr style="border-color: #ee7624;">
                    </div>
                </div>

                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                        } else if ($_GET["error"] == "none") {
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Video Agendada com sucesso! Aguarde o e-mail com mais informações.</p></div>";
                        }
                    }
                    ?>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col p-3">
                        <div class="card p-4 d-flex justify-content-center">
                            <!-- jsCalendar -->
                            <link rel="stylesheet" type="text/css" href="css/jsCalendar.css">
                            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

                            <style>
                                .datehover:hover {
                                    cursor: pointer;
                                    transform: scale(0.9);
                                }
                            </style>

                            <h4 class="text-conecta" style="font-weight: 400;">Dados do <span style="font-weight: 700;">Agendamento</span></h4>


                            <span class="py-3"> </span>
                            <div class="col-sm" id="div-form-agendar">

                                <div class="container-fluid">
                                    <form action="includes/agendartecnica.inc.php" method="POST" class="form-agendar">
                                        <div class="row">
                                            <div class="col">


                                                <div class="form-group" hidden>
                                                    <label class="label-control" for="tipo">Tipo de Vídeo</label>
                                                    <input class="form-control" type="text" id="tipo" name="tipo" value="Técnica Cirúrgica">
                                                </div>

                                                <div class="form-group" hidden>
                                                    <label class="label-control" for="user">Usuário</label>
                                                    <input class="form-control" type="text" id="user" name="user" value="<?php echo $_SESSION['useruid']; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="label-control" for="email">E-mail (enviaremos notificação com data e link da sala)</label>
                                                    <input class="form-control" type="mail" id="email" name="email">
                                                    <small>Importante o representante adiconar seu e-mail p/ receber notificação</small>
                                                </div>

                                                <div class="form-group">
                                                    <label class="label-control" for="doutor">Doutor</label>
                                                    <input class="form-control" type="text" id="doutor" name="doutor">
                                                </div>

                                                <div class="form-group">
                                                    <label class="label-control" for="pac">Paciente</label>
                                                    <input class="form-control" type="text" id="pac" name="pac">
                                                </div>

                                                <div class="form-group">
                                                    <label class="label-control" for="produto">Produto</label>
                                                    <select name="produto" class="form-control" id="produto">
                                                        <option>Escolha uma opção</option>
                                                        <?php
                                                        $retProduto = mysqli_query($conn, "SELECT * FROM produtoagenda ORDER BY produtoagendaNome ASC");
                                                        while ($rowProduto = mysqli_fetch_array($retProduto)) {
                                                        ?>
                                                            <option value="<?php echo $rowProduto['produtoagendaNome']; ?>"><?php echo $rowProduto['produtoagendaNome']; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label class="label-control" for="truedate">Data Real</label>
                                                    <input class="form-control" type="text" id="truedate" name="truedate" required readonly>
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label class="label-control" for="truetime">Horário Real</label>
                                                    <input class="form-control" type="text" id="truetime" name="truetime" required readonly>
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label class="label-control" for="timecode">Codigo Hora</label>
                                                    <input class="form-control" type="text" id="timecode" name="timecode" required readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label class="label-control" for="data">Data e Horário</label>
                                                    <input class="form-control" type="text" id="data" name="data" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-control" for="obs">Observações</label>
                                                    <textarea class="form-control" id="obs" name="obs" rows='3' required> </textarea>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" name="agendar" class="btn btn-primary">Agendar</button>
                                                </div>
                                            </div>
                                            <!-- </form> -->
                                            <div class="col">
                                                <div class="d-flex justify-content-center py-4">
                                                    <p style="color:#4A4A4A; font-weight: bold; font-size: 1rem; text-align: center;">
                                                        Agenda só estará disponível com <a style="color:#F37A23; text-decoration:none;">60h</a>
                                                        de antecedência</p>
                                                </div>
                                                <div class="d-flex justify-content-center mb-2">
                                                    <div class="form-group flex-fill">
                                                        <label class="label-control" for="selectorData">Escolha um dia</label>
                                                        <input class="form-control" type="date" name="selectorData" id="selectorData" onchange="checkDate(this)">
                                                        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
                                                        <script>
                                                            //var today = new Date().toISOString().split('T')[0];
                                                            //document.getElementsByName("selectorData")[0].setAttribute('min', today);

                                                            //Display Only Date till today //

                                                            var dtToday = new Date();
                                                            var month = dtToday.getMonth() + 1; // getMonth() is zero-based
                                                            var day = dtToday.getDate() + 3;
                                                            var year = dtToday.getFullYear();
                                                            if (month < 10)
                                                                month = '0' + month.toString();
                                                            if (day < 10)
                                                                day = '0' + day.toString();

                                                            var minData = year + '-' + month + '-' + day;
                                                            $('#selectorData').attr('min', minData);

                                                            const picker = document.getElementById('selectorData');
                                                            picker.addEventListener('input', function(e) {
                                                                var day = new Date(this.value).getUTCDay();
                                                                if ([6, 0].includes(day)) {
                                                                    e.preventDefault();
                                                                    this.value = '';
                                                                    alert('Desculpe! Esse dia não esta disponível.');
                                                                }
                                                            });

                                                            function checkDate(elem) {
                                                                //Recuperar o valor do campo
                                                                var pesquisa = elem.value;

                                                                //Verificar se há algo digitado
                                                                if (pesquisa != '') {
                                                                    var dados = {
                                                                        data: pesquisa
                                                                    }
                                                                    $.post('proc_pesq_date.php', dados, function(retorna) {
                                                                        //Mostra dentro da ul os resultado obtidos 
                                                                        $(".resultado").html(retorna);
                                                                    });
                                                                }

                                                                document.getElementById("truedate").value = date;
                                                            }
                                                        </script>
                                                    </div>
                                                </div>

                                                <label class="label-control">Escolha um horário</label>
                                                <div class="row d-flex justify-content-center resultado">
                                                    <!-- resultado horarios disponiveis -->
                                                </div>
                                                <script>
                                                    function selectDate(elem) {
                                                        var horario = elem.textContent;
                                                        var code = elem.getAttribute("key");

                                                        console.log(code);
                                                        var date = document.getElementById('selectorData').value;


                                                        var selecionado = `${date} às ${horario}`;
                                                        document.getElementById("data").value = selecionado;
                                                        document.getElementById("truedate").value = date;
                                                        document.getElementById("truetime").value = horario;
                                                        document.getElementById("timecode").value = code;
                                                    }
                                                </script>
                                            </div>
                                    </form>


                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>




        </div>
        </div>



        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: login");
    exit();
}

    ?>