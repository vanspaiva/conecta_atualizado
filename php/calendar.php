<!-- jsCalendar -->
<link rel="stylesheet" type="text/css" href="../css/jsCalendar.css">
<script type="text/javascript" src="../js/jsCalendar.js"></script>

<style>
    

    .btn-agenda {
        margin: 10px;
        border-color: #F37A23;
        color: #F37A23;
        border-width: 2px;
        border-style: solid;
        border-radius: 5px;
        width: fit-content;
        height: 30px;
        background-color: white;
        cursor: pointer;
        transition: ease-in 0.3s;
    }

    .btn-agenda:hover {
        background-color: #F37A23;
        color: white;
    }

    .input--fieldset {
        width: fit-content;
        margin-left: 2vw;
    }

    .input--form,
    .fg-item,
    .input--formGroup {
        display: block;
        margin-bottom: 1.5vh;
    }

    .input--form {
        width: 25vw;
    }

    .input--formGroupMin {
        display: inline-block;
        margin-bottom: 1.5vh;
        margin-right: 1vw;
    }

    .dataGroup,
    .input--formGroup {
        margin: 2vh;
    }

    .jsCalendar.custom-conecta tbody td.jsCalendar-current {
        background-color: #F37A23;
    }

    .jsCalendar.custom-conecta ::selection {
        background: #F37A23;
    }

    .jsCalendar.custom-conecta ::-moz-selection {
        background: #F37A23;
    }

    .jsCalendar.material-theme.custom-conecta thead {
        background-color: #F37A23;
    }

    .jsCalendar.material-theme.custom-conecta thead .jsCalendar-nav-left:hover,
    .jsCalendar.material-theme.custom-conecta thead .jsCalendar-nav-right:hover {
        background-color: #ff7300;
    }

    .jsCalendar.classic-theme.custom-conecta thead {
        background-color: #F37A23;
    }

    .jsCalendar.classic-theme.custom-conecta thead .jsCalendar-nav-left:hover,
    .jsCalendar.classic-theme.custom-conecta thead .jsCalendar-nav-right:hover {
        background-color: #ff7300;
    }

    .input-lineGroup,
    .input-radio,
    .input-label {
        display: inline-block;
    }

    .input-label {
        margin-right: 1vh;
    }

    .input--resposta {
        background-color: #E9E9F0;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        padding: 20px;
        width: fit-content;
        height: fit-content;
        border-radius: 20px;
        box-shadow: rgba(61, 61, 61, 0.5);
    }


    .orange-text {
        color: #F37A23;
    }

    
</style>

<body>
    <div class="input--content">
        <div class="input-lineGroup">
            <!-- <form class="input--form" action=""> -->
            <div class="input--formGroup">
                <input class="input-radio" type="radio" id="primVideo" name="video" value="1" checked>
                <label class="input-label" for="primVideo">1ª Vídeo</label>
                <input class="input-radio" type="radio" id="remarcVideo" name="video" value="2">
                <label class="input-label" for="remarcVideo">Remarcar Vídeo</label>
            </div>

            <div class="input--formGroup">
                <label class="input--formGroup" for="projeto">Projeto</label>
                <input class="input--formGroup" id="projeto" required>
            </div>

            <div class="input--formGroup">
                <label class="input--formGroup" for="doutor">Doutor</label>
                <input class="input--formGroup" id="doutor" required>
            </div>

            <div class="input--formGroup">
                <label class="input--formGroup" for="produto">Produto</label>
                <select class="input--formGroup" name="produto" id="produto" required>
                    <option value="0" selected="selected">Escolha um produto</option>
                    <option value="customlife">Customlife/Implantize</option>
                    <option value="ortognatica">Ortognática</option>
                    <option value="atm">ATM</option>
                    <option value="recOssea">Reconstrução Óssea</option>
                    <option value="smartmold">Smartmold</option>
                    <option value="surgicalguide">Surgicalguide</option>
                    <option value="mesh4u">Mesh 4U</option>
                    <option value="dispositivoCirurgico">Dispositivo Cirurgico</option>
                    <option value="biomodeloVertebra">Biomodelo Vértebra</option>
                </select>
            </div>

            <div class="dataGroup">
                <label class="input--formGroup" for="dataEscolhida">Data</label>
                <input class="input--formGroup" id="dataEscolhida" required readonly>
            </div>

            <div class="input--formGroup">
                <label class="input--formGroup" for="horario">Horário</label>
                <select class="input--formGroup" name="horario" id="horario" required>
                    <option value="0" selected="selected">Escolha um horario</option>
                    <option value="h1">8:00 - 8:30</option>
                    <option value="h2">8:30 - 9:00</option>
                    <option value="h3">9:00 - 9:30</option>
                    <option value="h4">9:30 - 10:00</option>
                    <option value="h5">10:00 - 10:30</option>
                    <option value="h6">10:30 - 11:00</option>
                    <option value="h7">11:00 - 11:30</option>
                    <option value="h8">11:30 - 12:00</option>
                    <option value="h9">12:00 - 12:30</option>
                    <option value="h10">12:30 - 13:00</option>
                    <option value="h11">13:00 - 13:30</option>
                    <option value="h12">14:00 - 14:30</option>
                    <option value="h13">14:30 - 15:00</option>
                    <option value="h14">13:30 - 14:00</option>
                    <option value="h15">15:00 - 15:30</option>
                    <option value="h16">15:30 - 16:00</option>
                    <option value="h17">16:00 - 16:30</option>
                    <option value="h18">16:30 - 17:00</option>
                </select>
            </div>

            <div class="input--formGroup">
                <button class="btn-agenda" value="submit" id="agendar-button">Agendar</button>
            </div>
            <!-- </form> -->
        </div>
        <div class="input-lineGroup">
            <!-- My calendar element -->
            <!-- <p class="text">Agenda só estará disponível <b class="orange-text">60h</b> após recebimento da Tomografia e formulário</p> -->
            <div id="my-calendar" class="custom-conecta classic-theme"></div>
        </div>
        <div class="input-lineGroup">
            <div id="resposta-div" class="">
                <span id="resposta"></span>
            </div>
        </div>

    </div>




    <div class="input--footer">
        <button class="btn"><a href="teste-CNPJ.html">Teste Anterior</a></button>
        <button class="btn"><a href="#">Próximo Teste</a></button>

    </div>
</body>

<script>
    //tipo de usuário global
    let typeUser;

    //define o tipo de usuário que está utilizando o sistema
    function setUser(tipo) {
        var user = tipo;

        if (user == "adm") {
            typeUser = "ADM";
            document.getElementById("input--section").style.display = 'block';
        } else {
            typeUser = "CMN";
            document.getElementById("input--section").style.display = 'none';
        }
    }

    // Create the calendar
    var calendar = jsCalendar.new("#my-calendar");

    // Get the inputs
    var print_date = document.getElementById("dataEscolhida");
    var projeto = document.getElementById("projeto").value;
    var doutor = document.getElementById("doutor").value;
    var produto = document.getElementById("produto").value;
    var tipoAgenda;
    var data;

    // When the user clicks on a date
    calendar.onDateClick(function(event, date) {
        print_date.value = jsCalendar.tools.dateToString(date, 'DAY, DD MONTH YYYY', 'en');
    });


    // Get the buttons
    var select_button = document.getElementById("agendar-button");

    // Add events
    select_button.addEventListener("click", function() {
        data = print_date.value;
        projeto = document.getElementById("projeto").value;
        doutor = document.getElementById("doutor").value;
        produto = document.getElementById("produto").value;

        var radioButton = document.getElementsByName('video');
        var radioValue;

        for (i = 0; i < radioButton.length; i++) {
            if (radioButton[i].checked)
                radioValue = radioButton[i].value;
        }

        if (radioValue == 1) {
            tipoAgenda = "1ª Vídeo";
        } else {
            tipoAgenda = "Vídeo Remarcada";
        }

        writeResposta(projeto, doutor, produto, data, tipoAgenda);

    }, false);

    function createAgendamento(texto) {
        var resposta = document.getElementById("resposta");
        var RespostaDiv = document.getElementById("resposta-div");
        RespostaDiv.classList.add("input--resposta");
        var resp = texto;
        resposta.appendChild(resp);
    }

    function writeResposta(projeto, doutor, produto, data, tipoAgenda) {
        var resposta = document.getElementById("resposta");
        var RespostaDiv = document.getElementById("resposta-div");
        RespostaDiv.classList.add("input--resposta");
        var texto = "";

        texto = texto + "<h2><b>" + tipoAgenda + " </b></h2>";
        texto = texto + "<b>Projeto: </b>" + projeto + " / ";
        texto = texto + "<b>Doutor: </b>" + doutor + "<br>";
        texto = texto + "<b>Produto: </b>" + produto + " / ";
        texto = texto + "<b>Data: </b>" + data + "<br>";


        // createAgendamento(texto);
        resposta.innerHTML = texto;
    }
</script>

</html>