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


<div class="row bg-agendar">
    <?php

    $agendaIdProj = deshashItemNatural(addslashes($_GET['id']));

    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$agendaIdProj'");
    while ($row = mysqli_fetch_array($ret)) {
        $nomedr = $row['pedNomeDr'];
        $produto = $row['pedTipoProduto'];
        $especificacaoProduto = $row['pedProduto'];
        $nomepac = $row['pedNomePac'];
        $produto = $produto . ' - ' . $especificacaoProduto;
    }
    ?>

    <div class="col-sm" id="div-form-agendar">

        <div class="container-fluid">
            <form action="includes/agendar.inc.php" method="POST" class="form-agendar">
                <div class="row">
                    <div class="col">
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <div class="form-check form-check-inline d-flex align-items-center">
                                <input class="form-check-input" type="radio" id="prim-video" name="op-video" value="1" checked onclick="changeTipoVideo(this)">
                                <label class="form-check-label" for="prim-video">1ª Video</label>
                            </div>
                            <div class="form-check form-check-inline d-flex align-items-center">
                                <input class="form-check-input" type="radio" id="remarc-video" name="op-video" value="2" onclick="changeTipoVideo(this)">
                                <label class="form-check-label" for="remarc-video">Remarcar</label>
                            </div>
                        </div>

                        <div class="form-group" hidden>
                            <label class="label-control" for="user">Usuário</label>
                            <input class="form-control" type="text" id="user" name="user" value="<?php echo $_SESSION['useruid']; ?>" onchange="whatchValues()">
                        </div>

                        <div class="form-group">
                            <label class="label-control" for="projeto">Projeto</label>
                            <input class="form-control" type="text" id="projeto" name="projeto" value="<?php echo $agendaIdProj; ?>" onchange="whatchValues()">
                        </div>

                        <div class="form-group">
                            <label class="label-control" for="doutor">Doutor</label>
                            <input class="form-control" type="text" id="doutor" name="doutor" value="<?php echo $nomedr; ?>" onchange="whatchValues()">
                        </div>

                        <div class="form-group">
                            <label class="label-control" for="pac">Paciente</label>
                            <input class="form-control" type="text" id="pac" name="pac" value="<?php echo $nomepac; ?>" onchange="whatchValues()">
                        </div>

                        <div class="form-group">
                            <label class="label-control" for="produto">Produto</label>
                            <input class="form-control" type="text" id="produto" name="produto" value="<?php echo $produto; ?>" onchange="whatchValues()">
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
                        <!--<div class="d-flex justify-content-end">
                            <button type="submit" name="agendar" class="btn btn-primary">Agendar</button>
                        </div>-->
                    </div>
            </form>
            <!-- </form> -->
            <div class="col">
                <div class="d-flex justify-content-center pt-4">
                    <p style="color:#4A4A4A; font-weight: bold; font-size: 1rem; text-align: center;">
                        Agenda só estará disponível <a style="color:#F37A23; text-decoration:none;">60h</a>
                        após recebimento da Tomografia e formulário</p>
                </div>
                <div class="d-flex justify-content-center mb-2">
                    <div class="form-group flex-fill">
                        <!-- <form class="jotform-form" action="https://submit.jotform.com/submit/222764549437062/" method="POST" name="form_222764549437062" id="222764549437062" accept-charset="utf-8" autocomplete="on">
                            <input type="hidden" name="formID" value="222764549437062" />
                            <input type="hidden" id="JWTContainer" value="" />
                            <input type="hidden" id="cardinalOrderNumber" value="" />
                            <div role="main" class="form-all">
                                <style>
                                    .form-all:before {
                                        background: none;
                                    }
                                </style>
                                </style>
                                <ul class="form-section page-section">
                                    <li class="form-line form-line-column form-col-1 always-hidden" data-type="control_textbox" id="id_4">
                                        <label class="form-label form-label-top form-label-auto" id="label_4" for="input_4"> Tipo Vídeo </label>
                                        <div id="cid_4" class="form-input-wide always-hidden" data-layout="half">
                                            <input type="text" id="input_4" name="q4_tipoVideo" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_4" />
                                        </div>
                                    </li>
                                    <li class="form-line form-line-column form-col-2 always-hidden" data-type="control_textbox" id="id_5">
                                        <label class="form-label form-label-top form-label-auto" id="label_5" for="input_5"> Projeto </label>
                                        <div id="cid_5" class="form-input-wide always-hidden" data-layout="half">
                                            <input type="text" id="input_5" name="q5_projeto5" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="<?php echo $agendaIdProj; ?>" data-component="textbox" aria-labelledby="label_5" />
                                        </div>
                                    </li>
                                    <li class="form-line form-line-column form-col-3 always-hidden" data-type="control_textbox" id="id_6">
                                        <label class="form-label form-label-top form-label-auto" id="label_6" for="input_6"> Usuário </label>
                                        <div id="cid_6" class="form-input-wide always-hidden" data-layout="half">
                                            <input type="text" id="input_6" name="q6_usuario" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="<?php echo $_SESSION['useruid']; ?>" data-component="textbox" aria-labelledby="label_6" />
                                        </div>
                                    </li>
                                    <li class="form-line form-line-column form-col-4 always-hidden" data-type="control_textbox" id="id_7">
                                        <label class="form-label form-label-top form-label-auto" id="label_7" for="input_7"> Doutor </label>
                                        <div id="cid_7" class="form-input-wide always-hidden" data-layout="half">
                                            <input type="text" id="input_7" name="q7_doutor" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="<?php echo $nomedr; ?>" data-component="textbox" aria-labelledby="label_7" />
                                        </div>
                                    </li>
                                    <li class="form-line form-line-column form-col-5 always-hidden" data-type="control_textbox" id="id_8">
                                        <label class="form-label form-label-top form-label-auto" id="label_8" for="input_8"> Paciente </label>
                                        <div id="cid_8" class="form-input-wide always-hidden" data-layout="half">
                                            <input type="text" id="input_8" name="q8_paciente" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="<?php echo $nomepac; ?>" data-component="textbox" aria-labelledby="label_8" />
                                        </div>
                                    </li>
                                    <li class="form-line form-line-column form-col-6 always-hidden" data-type="control_textbox" id="id_9">
                                        <label class="form-label form-label-top form-label-auto" id="label_9" for="input_9"> Produto </label>
                                        <div id="cid_9" class="form-input-wide always-hidden" data-layout="half">
                                            <input type="text" id="input_9" name="q9_produto" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="<?php echo $produto; ?>" data-component="textbox" aria-labelledby="label_9" />
                                        </div>
                                    </li>
                                    <li class="form-line" data-type="control_appointment" id="id_3">
                                        <label class="form-label form-label-top txt-conecta-important" id="label_3" for="input_3"> Escolha uma data e horário </label>
                                        <div id="cid_3" class="form-input-wide" data-layout="full">
                                            <div id="input_3" class="appointmentFieldWrapper jfQuestion-fields">
                                                <input class="appointmentFieldInput " name="q3_agendamentoDe[date]" id="input_3_date" />
                                                <input class="appointmentFieldInput" name="q3_agendamentoDe[duration]" value="30" id="input_3_duration" />
                                                <input class="appointmentFieldInput" name="q3_agendamentoDe[timezone]" value="America/Sao_Paulo (GMT-03:00)" id="input_3_timezone" />
                                                <div class="appointmentField">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="form-line" data-type="control_button" id="id_2">
                                        <div id="cid_2" class="form-input-wide" data-layout="full">
                                            <div data-align="auto" class="form-buttons-wrapper form-buttons-auto   jsTest-button-wrapperField">
                                                <button id="input_2" type="submit" class="form-submit-button submit-button jf-form-buttons jsTest-submitField" data-component="button" data-content="">
                                                    Salvar
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li style="display:none">
                                        Should be Empty:
                                        <input type="text" name="website" value="" />
                                    </li>
                                </ul>
                            </div>
                            <script>
                                JotForm.showJotFormPowered = "0";
                            </script>
                            <script>
                                JotForm.poweredByText = "Criado com Jotform";
                            </script>
                            <input type="hidden" class="simple_spc" id="simple_spc" name="simple_spc" value="222764549437062" />
                        </form> -->
                        <?php include_once 'jotagenda3.php'; ?>
                        
                        
                        <script type="text/javascript">
                            playStart();
                            var all_spc = document.querySelectorAll("form[id='222764549437062'] .si" + "mple" + "_spc");
                            for (var i = 0; i < all_spc.length; i++) {
                                all_spc[i].value = "222764549437062-222764549437062";
                            }

                            function playStart() {
                                changeTipoVideo(document.getElementById('prim-video'));
                                whatchValues();
                            }


                            function changeTipoVideo(elem) {
                                let selected = elem.value;
                                console.log(selected);
                                document.getElementById("input_4").value = selected;
                            }

                            function whatchValues() {
                                var projetoValue = document.getElementById("projeto").value;
                                var usuarioValue = document.getElementById("user").value;
                                var doutorValue = document.getElementById("doutor").value;
                                var pacienteValue = document.getElementById("pac").value;
                                var produtoValue = document.getElementById("produto").value;

                                var projetoBox = document.getElementById("input_5");
                                var usuarioBox = document.getElementById("input_6");
                                var doutorBox = document.getElementById("input_7");
                                var pacienteBox = document.getElementById("input_8");
                                var produtoBox = document.getElementById("input_9");

                                projetoBox.value = projetoValue;
                                usuarioBox.value = usuarioValue;
                                doutorBox.value = doutorValue;
                                pacienteBox.value = pacienteValue;
                                produtoBox.value = produtoValue;

                            }
                        </script>
                    </div>
                </div>
                <!--<div class="d-flex justify-content-center mb-2">
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
                            // resultado horarios disponiveis 
                        </div>-->
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