var screenSize;
$(document).ready(function () {
    screenSize = window.innerWidth;
    // console.log(screenSize);
});

window.addEventListener('resize', function (event) {
    screenSize = window.innerWidth;
    // console.log(screenSize);
}, true);

function resetOptions() {
    document.getElementById("cmf").checked = false;
    document.getElementById("cranio").checked = false;
    document.getElementById("ata").checked = false;
    document.getElementById("biomodelo").checked = false;

    //zerar dropdown
    document.getElementById('produtoSelect').hidden = true;
    document.getElementById('produtoSelect').value = "0";


    hideProductFields();

}

function hideProductFields() {
    //adicionar d-none pra todos os fields
    document.getElementById("ortognatica").classList.add("d-none");
    document.getElementById("atmBig").classList.add("d-none");
    document.getElementById("atmSmall").classList.add("d-none");
    document.getElementById("reconstrucao").classList.add("d-none");
    document.getElementById("smartmold").classList.add("d-none");
    document.getElementById("mesh").classList.add("d-none");
    document.getElementById("customlife").classList.add("d-none");
    document.getElementById("guiabuco").classList.add("d-none");
    document.getElementById("cranioPeek").classList.add("d-none");
    document.getElementById("cranioTitanio").classList.add("d-none");
    document.getElementById("fastmold").classList.add("d-none");
    document.getElementById("fastcmf").classList.add("d-none");
    document.getElementById("ataProd").classList.add("d-none");
    document.getElementById("biomodCranioField").classList.add("d-none");
    document.getElementById("biomodMandField").classList.add("d-none");
    document.getElementById("biomodMaxField").classList.add("d-none");
    document.getElementById("biomodVertebraField").classList.add("d-none");
    document.getElementById("biomodOmbroField").classList.add("d-none");
    document.getElementById("biomodOrtognaticaField").classList.add("d-none");
    document.getElementById("aluguelCx").classList.add("d-none");
}

//Define os tipos de campos que cada formulário mostrará
var extraForm1 = ""; var extraForm2 = ""; var extraForm3 = "";
var elementoExtra1 = document.getElementById("extraForm1");
var elementoExtra2 = document.getElementById("extraForm2");
var elementoExtra3 = document.getElementById("extraForm3");

//verifica quantos campos estão preenchidos
var qtdCampos = 0;
var listaProdutos = [];
let itemId;
var idProp = document.getElementById("idprop").value;

let ataOp;
//alterar formulário em diferentes tamanhos da tela

//ASSISTE TODOS OS CAMPOS DO FORMULÁRIO PARA SABER SE FORAM PREENCHIDOS E AUMENTAR O PERCENTUAL DE PREENCHIMENTO
$("#nomedr").on('focusout', function () {
    empty = verifyEmptyInput(this);
    countCampos(empty);
    // changeProgressBar(qtdCampos);
});

$("#crm").on('focusout', function () {
    empty = verifyEmptyInput(this);
    countCampos(empty);
    // changeProgressBar(qtdCampos);
});

$("#nomepaciente").on('focusout', function () {
    empty = verifyEmptyInput(this);
    countCampos(empty);
    // changeProgressBar(qtdCampos);
});

$("#emaildr").on('focusout', function () {
    empty = verifyEmptyInput(this);
    countCampos(empty);
    // changeProgressBar(qtdCampos);
});

$("#emailempresa").on('focusout', function () {
    empty = verifyEmptyInput(this);
    countCampos(empty);
    // changeProgressBar(qtdCampos);
});

$("#teldr").on('focusout', function () {
    empty = verifyEmptyInput(this);
    countCampos(empty);
    // changeProgressBar(qtdCampos);
});

function verifyInputFile(input) {
    var valor = input.value;

    if (valor == "") {
        alert("Você precisa anexar uma TC!");
    } else {
        qtdCampos = 10;
        // changeProgressBar(qtdCampos);
    }
}

//CONTA OS CAMPOS 
function countCampos(empty) {
    if (!empty) {
        qtdCampos++;
    } else {
        if (qtdCampos == 0) {
            qtdCampos = 0;
        } else {
            qtdCampos--;
        }
    }
}

// VERIFICAR SE O CAMPO EM QUESTÃO ESTÁ VAZIO
function verifyEmptyInput(input) {
    var valor = input.value;

    if (valor == "") {
        return true;
    } else {
        return false;
    }

}

//FUNÇÃO QUE AUMENTA A BARRA DE PROGRESSO DO FORM
// function changeProgressBar(qtd) {
//     var barra = document.getElementById("formCaseProgress");
//     var porcent;

//     porcent = qtd  10;
//     porcent = porcent + "%";
//     barra.style.width = porcent;

//     console.log(porcent);
//     console.log(qtdCampos);

// }

// INÍCIO TIPO DE PRODUTO
function handleProductTypeChange(produto) {
    var tipo = produto.value;

    setProductAvailable(tipo);
    document.getElementById('produtoSelect').hidden = false;
    document.getElementById('produtoSelect').value = "0";

    hideProductFields();

    // setNextAvailable(produto);
}
// FIM TIPO DE PRODUTO

//CRIA O RESTANTE DO FORMULÁRIO
function createForm(produto) {

    switch (produto) { //menu de tipo de formulário
        case "ortognática": //chama os campos necessários e concatena em uma variável
            hideProductFields();
            document.getElementById("ortognatica").classList.remove("d-none");
            document.getElementById("ortogSelect").value = "0";

            break;

        case "atm":
            hideProductFields();

            document.getElementById("aluguelCx").classList.remove("d-none");
            document.getElementById("selectAluguelCx").value = "0";

            if (screenSize >= 1236) {
                document.getElementById("atmBig").classList.remove("d-none");
                document.getElementById("atmSmall").classList.add("d-none");

                document.getElementById("atmStandartFieldBig").classList.add("d-none");
                document.getElementById("atmSobmedidaFieldBig").classList.add("d-none");

                document.getElementById("atmRegiao").value = "0";
                document.getElementById("atmTamanho").value = "0";

                document.getElementById("atmStandartBig").checked = false;
                document.getElementById("atmSobmedidaBig").checked = false;



                document.getElementById("Dppp").checked = false;
                document.getElementById("Dmmp").checked = false;
                document.getElementById("Dppm").checked = false;
                document.getElementById("Dmmm").checked = false;
                document.getElementById("Dppg").checked = false;
                document.getElementById("Dmmg").checked = false;
                document.getElementById("Eppp").checked = false;
                document.getElementById("Emmp").checked = false;
                document.getElementById("Eppm").checked = false;
                document.getElementById("Emmm").checked = false;
                document.getElementById("Eppg").checked = false;
                document.getElementById("Emmg").checked = false;

            } else {
                document.getElementById("atmSmall").classList.remove("d-none");
                document.getElementById("atmBig").classList.add("d-none");

                document.getElementById("atmSobmedidaFieldSmall").classList.add("d-none");
                document.getElementById("atmStandartFieldSmall").classList.add("d-none");

                document.getElementById("atmRegiaoSmall").value = "0";
                document.getElementById("atmTamanhoSmall").value = "0";

                document.getElementById("atmStandartSmall").checked = false;
                document.getElementById("atmSobmedidaSmall").checked = false;

                document.getElementById("escolhadireitoSmall").value = "0";
                document.getElementById("escolhaesquerdoSmall").value = "0";


            }


            break;

        case "atmpesquisa":
            hideProductFields();
            changeAtmPesquisa();

            break;

        case "reconstrução óssea":
            hideProductFields();
            document.getElementById("reconstrucao").classList.remove("d-none");

            document.getElementById("recObita").checked = false;
            document.getElementById("recMaxila").checked = false;
            document.getElementById("recMandibula").checked = false;
            document.getElementById("recZigoma").checked = false;
            document.getElementById("recInfraorbitario").checked = false;
            document.getElementById("recGlabela").checked = false;
            document.getElementById("recFrontal").checked = false;
            document.getElementById("recAngulo").checked = false;
            document.getElementById("recMento").checked = false;

            document.getElementById("recOrbitaField").classList.remove("d-none");
            document.getElementById("recMaxilaField").classList.remove("d-none");
            document.getElementById("recMandibulaField").classList.remove("d-none");
            document.getElementById("recZigomaField").classList.remove("d-none");
            document.getElementById("recInfraorbitarioField").classList.remove("d-none");
            document.getElementById("recGlabelaField").classList.remove("d-none");
            document.getElementById("recFrontalField").classList.remove("d-none");
            document.getElementById("recAnguloField").classList.remove("d-none");
            document.getElementById("recMentoField").classList.remove("d-none");

            document.getElementById("recOrbitaField").classList.add("d-none");
            document.getElementById("recMaxilaField").classList.add("d-none");
            document.getElementById("recMandibulaField").classList.add("d-none");
            document.getElementById("recZigomaField").classList.add("d-none");
            document.getElementById("recInfraorbitarioField").classList.add("d-none");
            document.getElementById("recGlabelaField").classList.add("d-none");
            document.getElementById("recFrontalField").classList.add("d-none");
            document.getElementById("recAnguloField").classList.add("d-none");
            document.getElementById("recMentoField").classList.add("d-none");

            document.getElementById("recMaterialOrbita").value = "0";
            document.getElementById("recTamanhoOrbita").value = "0";
            document.getElementById("recMaterialMaxila").value = "0";
            document.getElementById("recTamanhoMaxila").value = "0";
            document.getElementById("recMaterialMandibula").value = "0";
            document.getElementById("recTamanhoMandibula").value = "0";
            document.getElementById("recMaterialZigoma").value = "0";
            document.getElementById("recTamanhoZigoma").value = "0";
            document.getElementById("recMaterialInfraorbitario").value = "0";
            document.getElementById("recTamanhoInfraorbitario").value = "0";
            document.getElementById("recMaterialGlabela").value = "0";
            document.getElementById("recTamanhoGlabela").value = "0";
            document.getElementById("recMaterialFrontal").value = "0";
            document.getElementById("recTamanhoFrontal").value = "0";
            document.getElementById("recMaterialAngulo").value = "0";
            document.getElementById("recLadoAngulo").value = "0";
            document.getElementById("recMaterialMento").value = "0";
            document.getElementById("recTamanhoMento").value = "0";


            break;

        case "smartmold":
            hideProductFields();
            document.getElementById("smartmold").classList.remove("d-none");

            document.getElementById("smartmoldZigoma").checked = false;
            document.getElementById("smartmoldParanasal").checked = false;
            document.getElementById("smartmoldMento").checked = false;
            document.getElementById("smartmoldAngulo").checked = false;
            document.getElementById("smartmoldPremaxila").checked = false;

            document.getElementById("zigomaField").classList.remove("d-none");
            document.getElementById("paranasalField").classList.remove("d-none");
            document.getElementById("mentoField").classList.remove("d-none");
            document.getElementById("anguloField").classList.remove("d-none");
            document.getElementById("premaxilaField").classList.remove("d-none");

            document.getElementById("zigomaField").classList.add("d-none");
            document.getElementById("paranasalField").classList.add("d-none");
            document.getElementById("mentoField").classList.add("d-none");
            document.getElementById("anguloField").classList.add("d-none");
            document.getElementById("premaxilaField").classList.add("d-none");

            document.getElementById("ladoZigoma").value = "0";
            // document.getElementById("materialZigoma").value = "0";
            document.getElementById("ladoParanasal").value = "0";
            // document.getElementById("materialParanasal").value = "0";
            document.getElementById("tipoMento").value = "0";
            // document.getElementById("materialMento").value = "0";
            document.getElementById("tipoAngulo").value = "0";
            document.getElementById("ladoAngulo").value = "0";
            // document.getElementById("materialAngulo").value = "0";
            // document.getElementById("materialPremaxila").value = "0";


            break;

        case "mesh4u":
            hideProductFields();
            document.getElementById("mesh").classList.remove("d-none");

            document.getElementById("meshMaxila").checked = false;
            document.getElementById("meshMandibula").checked = false;

            document.getElementById("meshTamanhoMaxila").value = "0";
            document.getElementById("meshTamanhoMandibula").value = "0";

            document.getElementById("meshMaxilaField").classList.remove("d-none");
            document.getElementById("meshMandibulaField").classList.remove("d-none");

            document.getElementById("meshMaxilaField").classList.add("d-none");
            document.getElementById("meshMandibulaField").classList.add("d-none");


            break;

        case "customlife":
            hideProductFields();
            document.getElementById("customlife").classList.remove("d-none");

            document.getElementById("customRegiao").value = "0";
            document.getElementById("customTamanho").value = "0";


            break;

        case "guia de buco":
            hideProductFields();
            document.getElementById("guiabuco").classList.remove("d-none");

            document.querySelector('input[type=radio][name=op-Impressao]:checked').checked = false;
            document.querySelector('input[type=radio][name=op-Esteril]:checked').checked = false;

            document.getElementById("surgicalGuideIntermediario").checked = false;
            document.getElementById("surgicalGuideFinal").checked = false;
            document.getElementById("dispositivoMentoplastia").checked = false;
            document.getElementById("palatal").checked = false;


            break;

        case "crânio peek":
            hideProductFields();
            document.getElementById("cranioPeek").classList.remove("d-none");

            document.getElementById("tamanhoCranioPeek").value = "0";


            break;

        case "crânio titânio":
            hideProductFields();
            document.getElementById("cranioTitanio").classList.remove("d-none");

            document.getElementById("tamanhoCranioTitanio").value = "0";

            break;

        case "fastmold pmma":
            hideProductFields();
            document.getElementById("fastmold").classList.remove("d-none");

            document.getElementById("tamanhoFastmold").value = "0";

            break;

        case "fastcmf":
            hideProductFields();
            document.getElementById("fastcmf").classList.remove("d-none");

            document.getElementById("tamanhoFastcmf").value = "0";

            break;

        case "ata buco":
            hideProductFields();
            document.getElementById("ataProd").classList.remove("d-none");

            document.getElementById("ataTitle").innerHTML = "ATA BUCO";
            ataOp = "ATA BUCO";

            document.getElementById("tamanhoAta").value = "";
            break;

        case "ata coluna":
            hideProductFields();
            document.getElementById("ataProd").classList.remove("d-none");

            document.getElementById("ataTitle").innerHTML = "ATA COLUNA";
            ataOp = "ATA COLUNA";

            document.getElementById("tamanhoAta").value = "";
            break;

        case "ata hof":
            hideProductFields();
            document.getElementById("ataProd").classList.remove("d-none");

            document.getElementById("ataTitle").innerHTML = "ATA HOF";
            ataOp = "ATA HOF";

            document.getElementById("tamanhoAta").value = "";
            break;

        case "ata otorrino":
            hideProductFields();
            document.getElementById("ataProd").classList.remove("d-none");

            document.getElementById("ataTitle").innerHTML = "ATA OTORRINO";
            ataOp = "ATA OTORRINO";

            document.getElementById("tamanhoAta").value = "";
            break;

        case "biomodelo crânio":
            hideProductFields();
            document.getElementById("biomodCranioField").classList.remove("d-none");

            document.getElementById("tamanhoBiomodCranio").value = "0";
            // document.getElementById("qtdBiomodCranio").value = "";

            break;

        case "biomodelo mandíbula":
            hideProductFields();
            document.getElementById("biomodMandField").classList.remove("d-none");
            document.getElementById("tamanhoBiomodMand").value = "0";
            document.getElementById("tipoBiomodMand").value = "0";
            break;

        case "biomodelo maxila":
            hideProductFields();
            document.getElementById("biomodMaxField").classList.remove("d-none");
            document.getElementById("tamanhoBiomodMax").value = "0";
            document.getElementById("tipoBiomodMax").value = "0";
            break;

        case "biomodelo vértebra":
            hideProductFields();
            document.getElementById("biomodVertebraField").classList.remove("d-none");
            break;

        case "biomodelo ombro":
            hideProductFields();
            document.getElementById("biomodOmbroField").classList.remove("d-none");
            break;

        case "biomodelo ortognática":
            hideProductFields();
            document.getElementById("biomodOrtognaticaField").classList.remove("d-none");
            break;

        case "0":
            hideProductFields();
            break;
        default:
            console.log(`Erro interno. Opção "${valor}" não existe.`);
    }
}

//define os produtos disponíveis através do grupo maior: CMF, CRÂNIO, ATA E BIOMODELO
function setProductAvailable(tipo) {
    var selectCMF = document.getElementById('cmf-group');
    var selectCRANIO = document.getElementById('cranio-group');
    var selectATA = document.getElementById('ata-group');
    var selectBIOMOD = document.getElementById('biomodelo-group');

    var showThis;
    var hiddeThis1; var hiddeThis2; var hiddeThis3;

    if (tipo == "cmf") {
        showThis = selectCMF;
        hiddeThis1 = selectATA;
        hiddeThis2 = selectBIOMOD;
        hiddeThis3 = selectCRANIO;

    } else if (tipo == "cranio") {
        showThis = selectCRANIO;
        hiddeThis1 = selectCMF;
        hiddeThis2 = selectBIOMOD;
        hiddeThis3 = selectATA;

    } else if (tipo == "ata") {
        showThis = selectATA;
        hiddeThis1 = selectBIOMOD;
        hiddeThis2 = selectCMF;
        hiddeThis3 = selectCRANIO;

    } else if (tipo == "biomodelo") {
        showThis = selectBIOMOD;
        hiddeThis1 = selectCRANIO;
        hiddeThis2 = selectCMF;
        hiddeThis3 = selectATA;
    }

    showThis.hidden = false;
    hiddeThis1.hidden = true;
    hiddeThis2.hidden = true;
    hiddeThis3.hidden = true;


}


//define o tipo de produto
function setProdutoComplemento() {
    var produto = document.getElementById("produtoSelect").value;
    document.getElementById('tipoProd').value = produto.toUpperCase();
    createForm(produto);
}


//INÍCIO ORTOGNÁTICA

function selectOrtog() {
    var ortogSelect = document.getElementById("ortogSelect");
    var ortogSelectValue = document.getElementById("ortogSelect").value;
    var ortogImg = document.getElementById("ortogImg");

    switch (ortogSelectValue) {
        case "Maxila":
            ortogImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_9409caebf255b9812183c3cc3552364d.png");
            ortogImg.setAttribute("alt", "Ícone Maxila");

            break;

        case "Mandíbula":
            ortogImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_e859aa13903f395dc18a1e08f69b02c4.png");
            ortogImg.setAttribute("alt", "Ícone Mandíbula");

            break;

        case "COMPLETA (max / mand / mento)":
            ortogImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_5e1362f451af18fca9113c96e4d605ac.png");
            ortogImg.setAttribute("alt", "Ícone Ortognatica Completa");

            break;

        case "0":
            ortogImg.setAttribute("src", "");
            ortogImg.setAttribute("alt", "");

            break;

        default:
            console.log(`Erro interno. Opção "${ortogSelectValue}" não existe.`);
    }

    changeOrtognatica(ortogSelectValue);

}


//INÍCIO ATM
function handleTipoAtm(option) {
    option = option.value;
    switch (option) {
        case 'Standart':
            chooseAtmStandart();
            break;

        case 'Sobmedida':
            chooseAtmSobmedida();
            break;

        default:
            break;
    }

    reconstrucaoOp = option;
}


function chooseAtmStandart() {

    if ($('#atmStandartBig').is(":checked") == true) {
        document.getElementById('atmStandartFieldBig').classList.remove("d-none");
        document.getElementById('atmSobmedidaFieldBig').classList.add("d-none");
    } else {
        document.getElementById('atmStandartFieldBig').classList.add("d-none");
    }

    if ($('#atmStandartSmall').is(":checked") == true) {
        document.getElementById('atmStandartFieldSmall').classList.remove("d-none");
        document.getElementById('atmSobmedidaFieldSmall').classList.add("d-none");
    } else {
        document.getElementById('atmStandartFieldSmall').classList.add("d-none");
    }

}

function chooseAtmSobmedida() {

    if ($('#atmSobmedidaBig').is(":checked") == true) {
        document.getElementById('atmSobmedidaFieldBig').classList.remove("d-none");
        document.getElementById('atmStandartFieldBig').classList.add("d-none");
    } else {
        document.getElementById('atmSobmedidaFieldBig').classList.add("d-none");
    }

    if ($('#atmSobmedidaSmall').is(":checked") == true) {
        document.getElementById('atmSobmedidaFieldSmall').classList.remove("d-none");
        document.getElementById('atmStandartFieldSmall').classList.add("d-none");
    } else {
        document.getElementById('atmSobmedidaFieldSmall').classList.add("d-none");
    }

}

let atmOp;
function selectAtm() {
    var atmSelect = document.getElementById("atmRegiao");
    var atmTamanho = document.getElementById("atmTamanho");
    var atmSelectValue = document.getElementById("atmRegiao").value;
    var atmImg = document.getElementById("atmImg");

    switch (atmSelectValue) {
        case "Bilateral":
            atmImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_dd19f0bc97de99d6b2cf2b2199eafe8f.png");
            atmImg.setAttribute("alt", "Ícone ATM Bilateral");

            break;

        case "Esquerda":
            atmImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_c3a625eb41d74274c76eb737c65ec0a3.png");
            atmImg.setAttribute("alt", "Ícone ATM Esquerda");

            break;

        case "Direita":
            atmImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_c6134ca3498aea85a96612592fa82a08.png");
            atmImg.setAttribute("alt", "Ícone ATM Direita");

            break;

        case "0":
            atmImg.setAttribute("src", "");
            atmImg.setAttribute("alt", "");
            atmTamanho.value = "0";
            break;

        default:
            console.log(`Erro interno. Opção "${atmSelectValue}" não existe.`);
    }

    atmOp = atmSelectValue;

}

let customOp;
function selectCustomlife() {
    var customSelect = document.getElementById("customRegiao");
    var customTamanho = document.getElementById("customTamanho");
    var customSelectValue = document.getElementById("customRegiao").value;
    var customImg = document.getElementById("customImg");

    switch (customSelectValue) {
        case "Maxila":
            customImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_aaf6693fd0039a2ca55699e30b857bd8.png");
            customImg.setAttribute("alt", "Ícone Customlife Maxila");

            break;

        case "Mandíbula":
            customImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_6dda75535d89a44803acfa6915ee3dfe.png");
            customImg.setAttribute("alt", "Ícone Customlife Mandíbula");

            break;

        case "Maxila e Mandíbula":
            customImg.setAttribute("src", "https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_4d7d970dba439c1aa627564de14e738f.png");
            customImg.setAttribute("alt", "Ícone Customlife Maxila e Mandíbula");

            break;

        case "0":
            customImg.setAttribute("src", "");
            customImg.setAttribute("alt", "");
            customTamanho.value = "0";
            break;

        default:
            console.log(`Erro interno. Opção "${customSelectValue}" não existe.`);
    }

    customOp = customSelectValue;
}


function handleSmartmold(option) {
    option = option.value;
    switch (option) {
        case 'zigoma':
            chooseZigoma();
            break;

        case 'paranasal':
            chooseParanasal();
            break;
        case 'mento':
            chooseMento();
            break;

        case 'angulo':
            chooseAngulo();
            break;
        case 'premaxila':
            choosePremaxila();
            break;

        default:
            break;
    }
}

function chooseZigoma() {
    let actionZigoma;
    if ($('#smartmoldZigoma').is(":checked") == true) {
        actionZigoma = 'show';
    } else {
        actionZigoma = 'hide';
    }

    doZigoma(actionZigoma);
}

function chooseParanasal() {
    let actionParanasal;
    if ($('#smartmoldParanasal').is(":checked") == true) {
        actionParanasal = 'show';
    } else {
        actionParanasal = 'hide';
    }

    doParanasal(actionParanasal);
}

function chooseMento() {
    let actionMento;
    if ($('#smartmoldMento').is(":checked") == true) {
        actionMento = 'show';
    } else {
        actionMento = 'hide';
    }

    doMento(actionMento);
}

function chooseAngulo() {
    let actionAngulo;
    if ($('#smartmoldAngulo').is(":checked") == true) {
        actionAngulo = 'show';
    } else {
        actionAngulo = 'hide';
    }

    doAngulo(actionAngulo);
}

function choosePremaxila() {
    let actionPremaxila;
    if ($('#smartmoldPremaxila').is(":checked") == true) {
        actionPremaxila = 'show';
    } else {
        actionPremaxila = 'hide';
    }

    doAPremaxila(actionPremaxila);
}


function doZigoma(actionZigoma) {
    var elemento = document.getElementById('zigomaField');
    if (actionZigoma == 'show') {
        elemento.classList.remove("d-none");
    } else {
        elemento.classList.add("d-none");
    }
}

function doParanasal(actionParanasal) {
    var elemento = document.getElementById('paranasalField');
    if (actionParanasal == 'show') {
        elemento.classList.remove("d-none");
    } else {
        elemento.classList.add("d-none");
    }
}

function doMento(actionMento) {
    var elemento = document.getElementById('mentoField');
    if (actionMento == 'show') {
        elemento.classList.remove("d-none");
    } else {
        elemento.classList.add("d-none");
    }
}

function doAngulo(actionAngulo) {
    var elemento = document.getElementById('anguloField');
    if (actionAngulo == 'show') {
        elemento.classList.remove("d-none");
    } else {
        elemento.classList.add("d-none");
    }
}

function doAPremaxila(actionPremaxila) {
    var elemento = document.getElementById('premaxilaField');
    if (actionPremaxila == 'show') {
        elemento.classList.remove("d-none");
    } else {
        elemento.classList.add("d-none");
    }
}

function adicionarItemLista(item) {
    listaProdutos.push(item);
    // changeProgressBar(qtdCampos);
}
let tamListaTabela = 0;

//ORTOGNÁTICA ID
function changeOrtognatica(op) {

    let categoria = 'ORTOGNÁTICA';

    let item;
    switch (op) {

        case 'Maxila':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ORTOGNÁTICA",
                "nome": "ORTOGNÁTICA MAXILA",
                "cdg": "KITPC-6000",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "30"
                }
            break;

        case 'Mandíbula':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ORTOGNÁTICA",
                "nome": "ORTOGNÁTICA MANDÍBULA",
                "cdg": "KITPC-6001",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "30"
                }
            break;

        case 'COMPLETA (max / mand / mento)':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ORTOGNÁTICA",
                "nome": "ORTOGNÁTICA COMBINADA",
                "cdg": "KITPC-6002",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "70"
                }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    // adicionarItemLista(parafuso);
}

//ATM ID
function setTamanho(op) {
    let tamanho = op.value;
    changeAtm(tamanho, atmOp);
}

function changeAtm(tamanho, op) {

    let categoria = 'ATM';

    let item;
    switch (op) {

        case 'Bilateral':
            if (tamanho.includes('P')) {
                item1 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "ATM ESQUERDO P",
                    "cdg": "KITPC-505E",
                    "qtd": "1"
                },
                    item2 = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "ATM",
                        "nome": "ATM DIREITO P",
                        "cdg": "KITPC-505D",
                        "qtd": "1"
                    },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "24"
                    }
            } else if (tamanho.includes('M')) {
                item1 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "ATM ESQUERDO M",
                    "cdg": "KITPC-506E",
                    "qtd": "1"
                },
                    item2 = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "ATM",
                        "nome": "ATM DIREITO M",
                        "cdg": "KITPC-506D",
                        "qtd": "1"
                    },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "24"
                    }
            }
            adicionarItemLista(item1);
            adicionarItemLista(item2);
            break;

        case 'Esquerda':
            if (tamanho.includes('P')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "ATM ESQUERDO P",
                    "cdg": "KITPC-505E",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "24"
                    }
            } else if (tamanho.includes('M')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "ATM ESQUERDO M",
                    "cdg": "KITPC-506E",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "24"
                    }
            }
            adicionarItemLista(item);
            break;

        case 'Direita':
            if (tamanho.includes('P')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "ATM DIREITO P",
                    "cdg": "KITPC-505D",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "24"
                    }
            } else if (tamanho.includes('M')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "ATM DIREITO M",
                    "cdg": "KITPC-506D",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "48"
                    }
            }
            adicionarItemLista(item);
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    // adicionarItemLista(parafuso);
}

function changeAtmPesquisa() {
console.log("chamou");
    item = {
        "idProp": idProp,
        "tipo": "CMF",
        "produto": "ATM",
        "nome": "ATM PESQUISA CLÍNICA",
        "cdg": "ATMPESQUISA",
        "qtd": "1"
    };
    adicionarItemLista(item);

}

function selectCaixa(elem) {
    let categoria = 'ATM';
    elem = elem.value;

    switch (elem) {

        case 'super':
            caixa = {
                "idProp": idProp,
                "tipo": "EXTRA",
                "produto": "Caixa",
                "nome": "Caixa ATM Super Instrumental",
                "cdg": "T30.200",
                "qtd": "1"
            }
            break;

        case 'basica':
            caixa = {
                "idProp": idProp,
                "tipo": "EXTRA",
                "produto": "Caixa",
                "nome": "Caixa ATM Básica Parafusos",
                "cdg": "T30.101",
                "qtd": "1"
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(caixa);

}

function setTamanhoStandartDireito(op) {
    let tamanho = op.value;
    let lado = 'DIREITA';
    let final = 'D';
    changeAtmStandart(tamanho, lado, final);
}

function setTamanhoStandartEsquerdo(op) {
    let tamanho = op.value;
    let lado = 'ESQUERDA';
    let final = 'E';
    changeAtmStandart(tamanho, lado, final);
}

function changeAtmStandart(tamanho, lado, final) {
    let categoria = 'ATM';
    let item;
    switch (tamanho) {

        case 'ppp':

            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ATM",
                "nome": "Placa mandibular curta com cabeça condilar P – " + lado,
                "cdg": "P-5.10.01-" + final,
                "qtd": "1"
            },
                dispositivo1 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo mandibular P para corte e perfuração – " + lado,
                    "cdg": "P-5.10.DM-" + final,
                    "qtd": "1"
                },
                fossa = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Fossa articular pequena – " + lado,
                    "cdg": "P-5.00.01-" + final,
                    "qtd": "1"
                },
                dispositivo2 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo fossa de corte e perfuração para articulação pequena - " + lado,
                    "cdg": "P-5.DF.01-" + final,
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "3"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 05 Bloqueado",
                    "cdg": "PC-920.205",
                    "qtd": "6"
                },
                parafuso3 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,4 x 10 Bloqueado",
                    "cdg": "PC-924.210",
                    "qtd": "8"
                }

            break;

        case 'mmp':

            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ATM",
                "nome": "Placa mandibular curta com cabeça condilar P – " + lado,
                "cdg": "P-5.10.01-" + final,
                "qtd": "1"
            },
                dispositivo1 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo mandibular P para corte e perfuração – " + lado,
                    "cdg": "P-5.10.DM-" + final,
                    "qtd": "1"
                },
                fossa = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Fossa articular média – " + lado,
                    "cdg": "P-5.00.02-" + final,
                    "qtd": "1"
                },
                dispositivo2 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo fossa de corte e perfuração para articulação média - " + lado,
                    "cdg": "P-5.DF.02-" + final,
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "3"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 05 Bloqueado",
                    "cdg": "PC-920.205",
                    "qtd": "7"
                },
                parafuso3 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,4 x 10 Bloqueado",
                    "cdg": "PC-924.210",
                    "qtd": "8"
                }

            break;

        case 'ppm':

            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ATM",
                "nome": "Placa mandibular média com cabeça condilar P – " + lado,
                "cdg": "P-5.20.01-" + final,
                "qtd": "1"
            },
                dispositivo1 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo mandibular M para corte e perfuração – " + lado,
                    "cdg": "P-5.20.DM-" + final,
                    "qtd": "1"
                },
                fossa = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Fossa articular pequena – " + lado,
                    "cdg": "P-5.00.01-" + final,
                    "qtd": "1"
                },
                dispositivo2 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo fossa de corte e perfuração para articulação pequena - " + lado,
                    "cdg": "P-5.DF.01-" + final,
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "3"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 05 Bloqueado",
                    "cdg": "PC-920.205",
                    "qtd": "6"
                },
                parafuso3 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,4 x 10 Bloqueado",
                    "cdg": "PC-924.210",
                    "qtd": "11"
                }

            break;

        case 'mmm':

            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ATM",
                "nome": "Placa mandibular média com cabeça condilar M – " + lado,
                "cdg": "P-5.20.02-" + final,
                "qtd": "1"
            },
                dispositivo1 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo mandibular M para corte e perfuração – " + lado,
                    "cdg": "P-5.20.DM-" + final,
                    "qtd": "1"
                },
                fossa = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Fossa articular média – " + lado,
                    "cdg": "P-5.00.02-" + final,
                    "qtd": "1"
                },
                dispositivo2 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo fossa de corte e perfuração para articulação média - " + lado,
                    "cdg": "P-5.DF.02-" + final,
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "3"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 05 Bloqueado",
                    "cdg": "PC-920.205",
                    "qtd": "7"
                },
                parafuso3 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,4 x 10 Bloqueado",
                    "cdg": "PC-924.210",
                    "qtd": "11"
                }

            break;

        case 'ppg':

            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ATM",
                "nome": "Placa mandibular longa com cabeça condilar P – " + lado,
                "cdg": "P-5.30.01-" + final,
                "qtd": "1"
            },
                dispositivo1 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo mandibular G para corte e perfuração – " + lado,
                    "cdg": "P-5.30.DM-" + final,
                    "qtd": "1"
                },
                fossa = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Fossa articular pequena – " + lado,
                    "cdg": "P-5.00.01-" + final,
                    "qtd": "1"
                },
                dispositivo2 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo fossa de corte e perfuração para articulação pequena - " + lado,
                    "cdg": "P-5.DF.01-" + final,
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "3"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 05 Bloqueado",
                    "cdg": "PC-920.205",
                    "qtd": "6"
                },
                parafuso3 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,4 x 10 Bloqueado",
                    "cdg": "PC-924.210",
                    "qtd": "14"
                }

            break;

        case 'mmg':

            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "ATM",
                "nome": "Placa mandibular longa com cabeça condilar M – " + lado,
                "cdg": "P-5.30.02-" + final,
                "qtd": "1"
            },
                dispositivo1 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo mandibular G para corte e perfuração – " + lado,
                    "cdg": "P-5.30.DM-" + final,
                    "qtd": "1"
                },
                fossa = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Fossa articular média – " + lado,
                    "cdg": "P-5.00.02-" + final,
                    "qtd": "1"
                },
                dispositivo2 = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "ATM",
                    "nome": "Dispositivo fossa de corte e perfuração para articulação média - " + lado,
                    "cdg": "P-5.DF.02-" + final,
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "3"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 05 Bloqueado",
                    "cdg": "PC-920.205",
                    "qtd": "7"
                },
                parafuso3 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,4 x 10 Bloqueado",
                    "cdg": "PC-924.210",
                    "qtd": "14"
                }

            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    adicionarItemLista(dispositivo1);
    adicionarItemLista(fossa);
    adicionarItemLista(dispositivo2);
    // adicionarItemLista(parafuso1);
    // adicionarItemLista(parafuso2);
    // adicionarItemLista(parafuso3);

}


//Adicionais Smartmold
// Chave descartável (estéril e não autoclavável) 
// Chave permanente (Não estéril) 
// Parafuso autoperfurante 2.0 (média de 2 por implante) ( 2 implantes = 4 parafusos)  - A920xxx  
// Parafuso de emergência 2.3 (1 und)  Medida será enviada conforme o planejamento 3D

// espessuraZigoma
// espessuraParanasal
// espessuraMento
// espessuraAngulo
// espessuraPremaxila

var espessura;

function populateEspessura(elem) {
    espessura = elem.value;

    document.getElementById("espessuraSmartmold").value = '';
    document.getElementById("espessuraSmartmold").value = espessura + " mm";
}

//ZIGOMA ID
function changeZigoma(op) {
    let escolha = op.value;
    let categoria = 'ZIGOMA';


    let item;
    switch (escolha) {

        case 'Direito':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "ZIGOMA DIREITO ",
                "cdg": "E200.013-1 D",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "2"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        case 'Esquerdo':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "ZIGOMA ESQUERDO",
                "cdg": "E200.013-1 E",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "2"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        case 'Bilateral':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "ZIGOMA BILATERAL",
                "cdg": "E200.011-F",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "4"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    adicionarItemLista(chave1);
    adicionarItemLista(chave2);
    adicionarItemLista(conexao);
    // adicionarItemLista(parafuso1);
    // adicionarItemLista(parafuso2);
}

//PARANASAL ID
function changeParanasal(op) {
    let escolha = op.value;
    let categoria = 'PARANASAL';


    let item;
    switch (escolha) {
        case 'Bilateral':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "PARANASAL BILATERAL",
                "cdg": "E200.011-G",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "4"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    adicionarItemLista(chave1);
    adicionarItemLista(chave2);
    adicionarItemLista(conexao);
    // adicionarItemLista(parafuso1);
    // adicionarItemLista(parafuso2);
}

//MENTO ID
function changeMento(op) {
    let escolha = op.value;
    let categoria = 'MENTO';


    let item;
    switch (escolha) {
        case 'Bipartido':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "MENTO BIPARTIDO",
                "cdg": "E200.011-I",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "4"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        case 'PecaUnica':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "MENTO PEÇA ÚNICA",
                "cdg": "E200.011-H",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "2"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }
    adicionarItemLista(item);
    adicionarItemLista(chave1);
    adicionarItemLista(chave2);
    adicionarItemLista(conexao);
    // adicionarItemLista(parafuso1);
    // adicionarItemLista(parafuso2);
}

//ÂNGULO ID
let tipoAngulo = "";
function changeAnguloTipo(op) {
    let escolha = op.value;

    switch (escolha) {
        case "PecaUnica":
            tipoAngulo = "PEÇA ÚNICA";
            break;

        case "Bipartido":
            tipoAngulo = "BIPARTIDO";
            break;

        default:
            tipoAngulo = "";
            break;
    }
}

function changeAngulo(op) {
    let escolha = op.value;
    let categoria = 'ÂNGULO';


    let item;

    switch (escolha) {
        case 'Direito':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "ÂNGULO DE MAND DIREITO " + tipoAngulo,
                "cdg": "E200.011-KD",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "2"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        case 'Esquerdo':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "ÂNGULO DE MAND ESQUERDO " + tipoAngulo,
                "cdg": "E200.011-KE",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "2"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        case 'Bilateral':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "ÂNGULO DE MAND BILATERAL " + tipoAngulo,
                "cdg": "E200.011-J",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "4"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    adicionarItemLista(chave1);
    adicionarItemLista(chave2);
    adicionarItemLista(conexao);
    // adicionarItemLista(parafuso1);
    // adicionarItemLista(parafuso2);
}

//PRÉ-MAXILA ID
function changePremaxila(op) {
    let escolha = op.value;
    let categoria = 'PRÉ';


    let item;
    switch (escolha) {
        case 'PMMA':
            item = {
                "idProp": idProp,
                "tipo": "CMF",
                "produto": "SMARTMOLD",
                "nome": "PRÉ MAXILA " + espessura,
                "cdg": "E200.011-L",
                "qtd": "1"
            },
                chave1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave descartável (estéril e não autoclavável)",
                    "cdg": "ET40.001",
                    "qtd": "1"
                },
                chave2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Chave",
                    "nome": "Chave permanente (Não estéril)",
                    "cdg": "MM3017",
                    "qtd": "1"
                },
                conexao = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Conexão",
                    "nome": "Conexão",
                    "cdg": "MM3042-2",
                    "qtd": "1"
                },
                parafuso1 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso autoperfurante 2.0",
                    "cdg": "A920xxx",
                    "qtd": "2"
                },
                parafuso2 = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso de emergência 2.3",
                    "cdg": "A920.503",
                    "qtd": "1"
                }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }
    adicionarItemLista(item);
    adicionarItemLista(chave1);
    adicionarItemLista(chave2);
    adicionarItemLista(conexao);
    // adicionarItemLista(parafuso1);
    // adicionarItemLista(parafuso2);
}

let saveShort = [];
let saveQtd = [];
let saveLong = [];

const listaItens = document.getElementById('listaItens');
const listaQtdItens = document.getElementById('listaQtdItens');
const longListaItens = document.getElementById('longListaItens');

function createProductList() {

    var styleDifer = "";

    const tableProd = document.querySelector('.tableProd');
    let listaTabela = [];

    listaTabela.push(...listaProdutos);
    saveLong.push(...listaTabela);
    listaTabela.map(function (elem) {
        if (elem.tipo == "EXTRA") {
            styleDifer = "style='color: red;'";
        }
        const tr = `
                    <tr>
                        <td ${styleDifer}>${elem.tipo}</td>
                        <td>${elem.produto}</td>
                        <td>${elem.nome}</td>
                        <td>${elem.qtd}</td>
                        <td><span class="btn" onclick="apagarLinha(this, '${elem.cdg}', '${elem.qtd}')"><i class="bi bi-x-lg" style="color: red;"></i></span></td>                        
                    </tr>
                `;
        tamListaTabela++;
        tableProd.insertAdjacentHTML("beforeend", tr);
        saveShort.push(elem.cdg);
        saveQtd.push(elem.qtd);
    });

    // criarCaixaTexto(saveLong);

    zerarEscolhas();
    listaItens.value = saveShort;
    listaQtdItens.value = saveQtd;
    longListaItens.value = JSON.stringify(saveLong);

    document.getElementById("msgExtra").hidden = false;
}

function zerarEscolhas() {
    $('#exampleModal').modal('hide');
    $('#closeProdModal').click();
    listaProdutos = [];
}

function criarCaixaTexto(saveLong) {
    var txt = document.getElementById('saveLong');

    if (txt == null) {
        var x = document.createElement("TEXTAREA");
        x.setAttribute("type", "text");
        x.setAttribute("rows", saveShort.length);
        x.setAttribute("cols", "100");
        x.setAttribute("hidden", "true");
        x.setAttribute("id", "saveLong");
        x.setAttribute("name", "saveLong");
        const myJSON = JSON.stringify(saveLong);
        var t = document.createTextNode(myJSON);
        x.appendChild(t);
        longListaItens.appendChild(x);
    } else {
        const myJSON = JSON.stringify(saveLong);
        txt.innerHTML = myJSON;
    }

}

function apagarLinha(uitem, cdg, qtd) {
    $(uitem).closest("tr").remove();

    saveShort.map(function (elem) {
        if (elem == cdg) {
            saveShort = saveShort.filter(item => item !== elem);
        }
    });

    saveLong.map(function (elem) {
        if (elem.cdg == cdg) {
            saveLong = saveLong.filter(item => item !== elem);
        }
    });

    saveQtd.map(function (elem) {
        if (elem == qtd) {
            saveQtd = saveQtd.filter(item => item !== elem);
        }
    });

    listaItens.value = saveShort;
    listaQtdItens.value = saveQtd;
    longListaItens.value = JSON.stringify(saveLong);
}

//FIM SMARTMOLD



let reconstrucaoOp;
let tamanhoRec;
let materialRec;
function handleReconstrucao(option) {
    option = option.value;
    switch (option) {
        case 'Orbita':
            chooseRecOrbita();
            break;

        case 'Maxila':
            chooseRecMaxila();
            break;
        case 'Mandibula':
            chooseRecMandibula();
            break;

        case 'Zigoma':
            chooseRecZigoma();
            break;
        case 'Infraorbitario':
            chooseRecInfraorbitario();
            break;

        case 'Glabela':
            chooseRecGlabela();
            break;

        case 'Frontal':
            chooseRecFrontal();
            break;
        case 'Angulo':
            chooseRecAngulo();
            break;

        case 'Mento':
            chooseRecMento();
            break;

        default:
            break;
    }

    reconstrucaoOp = option;
}


function chooseRecOrbita() {

    if ($('#recObita').is(":checked") == true) {
        document.getElementById('recOrbitaField').classList.remove("d-none");
    } else {
        document.getElementById('recOrbitaField').classList.add("d-none");
    }

}

function chooseRecMaxila() {

    if ($('#recMaxila').is(":checked") == true) {
        document.getElementById('recMaxilaField').classList.remove("d-none");
    } else {
        document.getElementById('recMaxilaField').classList.add("d-none");
    }

}

function chooseRecMandibula() {

    if ($('#recMandibula').is(":checked") == true) {
        document.getElementById('recMandibulaField').classList.remove("d-none");
    } else {
        document.getElementById('recMandibulaField').classList.add("d-none");
    }

}

function chooseRecZigoma() {

    if ($('#recZigoma').is(":checked") == true) {
        document.getElementById('recZigomaField').classList.remove("d-none");
    } else {
        document.getElementById('recZigomaField').classList.add("d-none");
    }

}

function chooseRecInfraorbitario() {

    if ($('#recInfraorbitario').is(":checked") == true) {
        document.getElementById('recInfraorbitarioField').classList.remove("d-none");
    } else {
        document.getElementById('recInfraorbitarioField').classList.add("d-none");
    }

}

function chooseRecGlabela() {

    if ($('#recGlabela').is(":checked") == true) {
        document.getElementById('recGlabelaField').classList.remove("d-none");
    } else {
        document.getElementById('recGlabelaField').classList.add("d-none");
    }

}

function chooseRecFrontal() {

    if ($('#recFrontal').is(":checked") == true) {
        document.getElementById('recFrontalField').classList.remove("d-none");
    } else {
        document.getElementById('recFrontalField').classList.add("d-none");
    }

}

function chooseRecAngulo() {

    if ($('#recAngulo').is(":checked") == true) {
        document.getElementById('recAnguloField').classList.remove("d-none");
    } else {
        document.getElementById('recAnguloField').classList.add("d-none");
    }

}

function chooseRecMento() {

    if ($('#recMento').is(":checked") == true) {
        document.getElementById('recMentoField').classList.remove("d-none");
    } else {
        document.getElementById('recMentoField').classList.add("d-none");
    }

}

//RECONSTRUÇÃO ID

function setMaterialRec(op) {
    materialRec = op.value;
}

function setTamanhoRec(op) {
    tamanhoRec = op.value;
    // console.log(tamanhoRec + " / " + reconstrucaoOp + " / " + materialRec);

    // console.log(tamanhoRec);
    // console.log(reconstrucaoOp);
    // console.log(materialRec);

    changeRec(tamanhoRec, reconstrucaoOp, materialRec);
}

function changeRec(tamanho, op, material) {
console.log(`${tamanho}, ${op}, ${material}`);
    let categoria = 'RECONSTRUÇÃO';

    let item;

    switch (op) {

        case 'Orbita':
            if (material.includes('PEEK')) {
                if (tamanho.includes('PEQUENO')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ORBITA EM PEEK - P",
                        "cdg": "PC-301-P1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('MÉDIO')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ORBITA EM PEEK - M",
                        "cdg": "PC-301-P2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL PEEK - Extra",
                        "cdg": "PC-300-PE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('PEQUENO')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ORBITA EM TITÂNIO - P",
                        "cdg": "PC-301-T1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('MÉDIO')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ORBITA EM TITÂNIO - M",
                        "cdg": "PC-301-T2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL TITÂNIO - Extra",
                        "cdg": "PC-300-TE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }
            break;

        case 'Maxila':

            if (material.includes('PEEK')) {
                if (tamanho.includes('PEQUENO')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MAXILAR EM PEEK - P",
                        "cdg": "PC-302-P1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('MÉDIA')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MAXILAR EM PEEK - M",
                        "cdg": "PC-302-P2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL PEEK - Extra",
                        "cdg": "PC-300-PE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('PEQUENO')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MAXILAR EM TITÂNIO - P",
                        "cdg": "PC-302-T1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('MÉDIA')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MAXILAR EM TITÂNIO - M",
                        "cdg": "PC-302-T2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL TITÂNIO - Extra",
                        "cdg": "PC-300-TE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }

            break;
        case 'Mandibula':

            if (material.includes('PEEK')) {
                if (tamanho.includes('PEQUENO')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MANDIBULAR EM PEEK - P",
                        "cdg": "PC-303-P1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('MÉDIA')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MANDIBULAR EM PEEK - M",
                        "cdg": "PC-303-P2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL PEEK - Extra",
                        "cdg": "PC-300-PE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('PEQUENO')) {

                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MANDIBULAR EM TITÂNIO - P",
                        "cdg": "PC-303-T1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('MÉDIO')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MANDIBULAR EM TITÂNIO - M",
                        "cdg": "PC-303-T2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL TITÂNIO - Extra",
                        "cdg": "PC-300-TE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }

            break;

        case 'Zigoma':

            if (material.includes('PEEK')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ZIGOMA EM PEEK - P",
                        "cdg": "PC-304-P1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ZIGOMA EM PEEK - M",
                        "cdg": "PC-304-P2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL PEEK - Extra",
                        "cdg": "PC-300-PE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ZIGOMA EM TITÂNIO - P",
                        "cdg": "PC-304-T1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ZIGOMA EM TITÂNIO - M",
                        "cdg": "PC-304-T2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL TITÂNIO - Extra",
                        "cdg": "PC-300-TE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }

            break;
        case 'Infraorbitario':

            if (material.includes('PEEK')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "INFRAORBITÁRIO EM PEEK - P",
                        "cdg": "PC-305-P1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "INFRAORBITÁRIO EM PEEK - M",
                        "cdg": "PC-305-P2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL PEEK - Extra",
                        "cdg": "PC-300-PE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "INFRAORBITÁRIO EM TITÂNIO - P",
                        "cdg": "PC-305-T1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "INFRAORBITÁRIO EM TITÂNIO - M",
                        "cdg": "PC-305-T2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL TITÂNIO - Extra",
                        "cdg": "PC-300-TE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }

            break;

        case 'Glabela':

            if (material.includes('PEEK')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "GLABELA EM PEEK - P",
                        "cdg": "PC-306-P1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "GLABELA EM PEEK - M",
                        "cdg": "PC-306-P2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL PEEK - Extra",
                        "cdg": "PC-300-PE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "GLABELA EM TITÂNIO - P",
                        "cdg": "PC-306-T1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "GLABELA EM TITÂNIO - M",
                        "cdg": "PC-306-T2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL TITÂNIO - Extra",
                        "cdg": "PC-300-TE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }


            break;

        case 'Frontal':

            if (material.includes('PEEK')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "FRONTAL EM PEEK - P",
                        "cdg": "PC-501-P1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "FRONTAL EM PEEK - M",
                        "cdg": "PC-501-P2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL PEEK - Extra",
                        "cdg": "PC-300-PE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "FRONTAL EM TITÂNIO - P",
                        "cdg": "PC-501-T1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "FRONTAL EM TITÂNIO - M",
                        "cdg": "PC-501-T2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL TITÂNIO - Extra",
                        "cdg": "PC-300-TE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }


            break;
        case 'Angulo':

            if (material.includes('PEEK')) {
                if (tamanho.includes('Direito')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ÂNG DE MAND EM PEEK - Dir",
                        "cdg": "PC-507-P1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Esquerdo')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ÂNG DE MAND EM PEEK - Esq",
                        "cdg": "PC-507-P2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Bilateral')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ÂNG DE MAND EM PEEK - Dir + Esq",
                        "cdg": "PC-507-P3",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('Direito')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ÂNG DE MAND EM TITÂNIO - Dir",
                        "cdg": "PC-507-T1",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Esquerdo')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ÂNG DE MAND EM TITÂNIO - Esq",
                        "cdg": "PC-507-T2",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Bilateral')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "ÂNG DE MAND EM TITÂNIO - Dir + Esq",
                        "cdg": "PC-507-T3",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }

            break;

        case 'Mento':

            if (material.includes('PEEK')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MENTO EM PEEK - P",
                        "cdg": "PC-402-P1 MEN",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MENTO EM PEEK - M",
                        "cdg": "PC-402-P2 MEN",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL PEEK - Extra",
                        "cdg": "PC-300-PE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            } else if (material.includes('TITÂNIO')) {
                if (tamanho.includes('P')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MENTO EM TITÂNIO - P",
                        "cdg": "PC-402MEN",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('M')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "MENTO EM TITÂNIO - M",
                        "cdg": "PC-403MEN",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                } else if (tamanho.includes('Outra')) {
                    item = {
                        "idProp": idProp,
                        "tipo": "CMF",
                        "produto": "RECONSTRUÇÃO",
                        "nome": "RECONSTRUÇÃO FACIAL TITÂNIO - Extra",
                        "cdg": "PC-300-TE",
                        "qtd": "1"
                    },
                        parafuso = {
                            "idProp": idProp,
                            "tipo": "EXTRA",
                            "produto": "Parafuso",
                            "nome": "Parafuso 2,0 x 10 Bloqueado",
                            "cdg": "PC-920.210",
                            "qtd": "24"
                        }
                }
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    // adicionarItemLista(parafuso);
}


let meshOp;
function handleMesh(option) {

    option = option.value;
    console.log(option);
    switch (option) {
        case 'maxila':
            chooseMeshMaxila();
            break;
        case 'mandibula':
            chooseMeshMandibula();
            break;

        default:
            break;
    }

    meshOp = option;
}


function chooseMeshMaxila() {

    if ($('#meshMaxila').is(":checked") == true) {
        document.getElementById('meshMaxilaField').classList.remove("d-none");
    } else {
        document.getElementById('meshMaxilaField').classList.add("d-none");
    }

}

function chooseMeshMandibula() {

    if ($('#meshMandibula').is(":checked") == true) {
        document.getElementById('meshMandibulaField').classList.remove("d-none");
    } else {
        document.getElementById('meshMandibulaField').classList.add("d-none");
    }

}


//MESH ID
function changeMesh(op) {
    let tamanho = op.value;
    let categoria = 'MESH 4U';

    let item;
    switch (meshOp) {
        case 'maxila':
            if (tamanho.includes('P')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "MESH4U",
                    "nome": "MAXILA TIÂNIO P",
                    "cdg": "PC-703-MAX"
                }
            } else if (tamanho.includes('M')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "MESH4U",
                    "nome": "MAXILA TIÂNIO M",
                    "cdg": "PC-704MAX"
                }
            }
            break;

        case 'mandibula':
            if (tamanho.includes('P')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "MESH4U",
                    "nome": "MANDIBULAR TIÂNIO P",
                    "cdg": "PC-703-MAN"
                }
            } else if (tamanho.includes('M')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "MESH4U",
                    "nome": "MANDIBULAR TIÂNIO M",
                    "cdg": "PC-704MAN"
                }
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }
    adicionarItemLista(item);
}

//CUSTOMLIFE ID
function setTamanhoCustom(op) {
    let tamanho = op.value;
    changeCustom(tamanho, customOp);
}

function changeCustom(tamanho, op) {

    let categoria = 'CUSTOMLIFE';

    let item;
    switch (op) {

        case 'Maxila':
            if (tamanho.includes('Parcial')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "CUSTOMLIFE",
                    "nome": "CUSTOM MAXILA PARCIAL",
                    "cdg": "PC-701-MAXP",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "12"
                    }
            } else if (tamanho.includes('Total')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "CUSTOMLIFE",
                    "nome": "CUSTOM MAXILA TOTAL",
                    "cdg": "PC-702-MAXT",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "24"
                    }
            }
            break;

        case 'Mandíbula':
            if (tamanho.includes('Parcial')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "CUSTOMLIFE",
                    "nome": "CUSTOM MANDIBULA PARCIAL",
                    "cdg": "PC-701-MANP",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "12"
                    }
            } else if (tamanho.includes('Total')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "CUSTOMLIFE",
                    "nome": "CUSTOM MANDIBULA TOTAL",
                    "cdg": "PC-702-MANT",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "24"
                    }
            }
            break;

        case 'Maxila e Mandíbula':
            if (tamanho.includes('Parcial')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "CUSTOMLIFE",
                    "nome": "CUSTOM MAX + MAND",
                    "cdg": "PC-700 MAX MAN",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "12"
                    }
            } else if (tamanho.includes('Total')) {
                item = {
                    "idProp": idProp,
                    "tipo": "CMF",
                    "produto": "CUSTOMLIFE",
                    "nome": "CUSTOM MAX + MAND",
                    "cdg": "PC-700 MAX MAN",
                    "qtd": "1"
                },
                    parafuso = {
                        "idProp": idProp,
                        "tipo": "EXTRA",
                        "produto": "Parafuso",
                        "nome": "Parafuso 2,0 x 10 Bloqueado",
                        "cdg": "PC-920.210",
                        "qtd": "24"
                    }
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    // adicionarItemLista(parafuso);
}


//CRANIO PEEK ID
function changePeek(op) {
    op = op.value;
    let categoria = 'CRÂNIO PEEK';

    let item;
    switch (op) {

        case 'P':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "CRÂNIO PEEK",
                "nome": "CRÂNIO PEEK - P",
                "cdg": "PC-201-P1",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "6"
                }
            break;

        case 'M':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "CRÂNIO PEEK",
                "nome": "CRÂNIO PEEK - M",
                "cdg": "PC-201-P2",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "8"
                }
            break;

        case 'G':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "CRÂNIO PEEK",
                "nome": "CRÂNIO PEEK - G",
                "cdg": "PC-201-P3",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "10"
                }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    // adicionarItemLista(parafuso);
}

//CRANIO TITÂNIO ID
function changeTitanio(op) {
    op = op.value;
    let categoria = 'CRÂNIO TITÂNIO';

    let item;
    switch (op) {

        case 'P':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "CRÂNIO TITÂNIO",
                "nome": "CRÂNIO TITÂNIO - P",
                "cdg": "PC-201-T1",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "6"
                }
            break;

        case 'M':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "CRÂNIO TITÂNIO",
                "nome": "CRÂNIO TITÂNIO - M",
                "cdg": "PC-201-T2",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "8"
                }
            break;

        case 'G':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "CRÂNIO TITÂNIO",
                "nome": "CRÂNIO TITÂNIO - G",
                "cdg": "PC-201-T3",
                "qtd": "1"
            },
                parafuso = {
                    "idProp": idProp,
                    "tipo": "EXTRA",
                    "produto": "Parafuso",
                    "nome": "Parafuso 2,0 x 10 Bloqueado",
                    "cdg": "PC-920.210",
                    "qtd": "10"
                }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
    // adicionarItemLista(parafuso);
}

//FASTMOLD CRÂNIO ID
function changeFastmold(op) {
    op = op.value;
    let categoria = 'FASTMOLD CRÂNIO';

    let item;
    switch (op) {

        case 'P':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "FASTMOLD CRÂNIO",
                "nome": "FASTMOLD CRÂNIO - P",
                "cdg": "E200.013-1"
            }
            break;

        case 'M':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "FASTMOLD CRÂNIO",
                "nome": "FASTMOLD CRÂNIO - M",
                "cdg": "E200.013-5"
            }
            break;

        case 'G':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "FASTMOLD CRÂNIO",
                "nome": "FASTMOLD CRÂNIO - G",
                "cdg": "E200.013-6"
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
}


//FASTCMF CRÂNIO ID
function changeFastcmf(op) {
    op = op.value;
    let categoria = 'FASTCMF CRÂNIO';

    let item;
    switch (op) {

        case 'M':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "FASTCMF CRÂNIO",
                "nome": "FASTCMF CRÂNIO - M",
                "cdg": "E200.016-1"
            }
            break;

        case 'G':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": "FASTCMF CRÂNIO",
                "nome": "FASTCMF CRÂNIO - G",
                "cdg": "E200.016-2"
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
}


//ATA ID
function changeAta(obs) {
    obs = obs.value;
    let categoria = 'ATA';

    let item;
    switch (ataOp) {

        case 'ATA BUCO':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": ataOp,
                "nome": obs,
                "cdg": "ATA.B"
            }
            break;

        case 'ATA COLUNA':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": ataOp,
                "nome": obs,
                "cdg": "ATA.Cl"
            }
            break;

        case 'ATA HOF':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": ataOp,
                "nome": obs,
                "cdg": "ATA HOF"
            }
            break;

        case 'ATA OTORRINO':
            item = {
                "idProp": idProp,
                "tipo": "CRÂNIO",
                "produto": ataOp,
                "nome": obs,
                "cdg": "ATA.O"
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
}

//BIOMODELO CRANIO ID
function changeBiomodCranio(qtd) {
    qtd = qtd.value;
    let categoria = 'BIOMODELO';

    let tamanho = document.getElementById("tamanhoBiomodCranio").value;
    let item;
    switch (tamanho) {

        case 'Parcial':
            item = {
                "idProp": idProp,
                "tipo": "BIOMODELO",
                "produto": "BIOMODELO CRÂNIO",
                "nome": qtd + "x BIOMODELO CRÂNIO",
                "cdg": "999506"
            }
            break;

        case 'Total':
            item = {
                "idProp": idProp,
                "tipo": "BIOMODELO",
                "produto": "BIOMODELO CRÂNIO",
                "nome": qtd + "x BIOMODELO CRÂNIO",
                "cdg": "999507"
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
}


//BIOMODELO MANDIBULA ID
function changeBiomodMandibula(qtd) {
    qtd = qtd.value;
    let categoria = 'BIOMODELO';

    let tamanho = document.getElementById("tamanhoBiomodMand").value;
    let tipo = document.getElementById("tipoBiomodMand").value;


    let item;
    switch (tamanho) {

        case 'Ampliado':
            if (tipo == 'Opaco') {
                item = {
                    "idProp": idProp,
                    "tipo": "BIOMODELO",
                    "produto": "MANDÍBULA",
                    "nome": qtd + "x MANDÍBULA AMPLIADA OPACO",
                    "cdg": "999517"
                }
            } else if (tipo == 'OpacoA') {
                item = {
                    "idProp": idProp,
                    "tipo": "BIOMODELO",
                    "produto": "MANDÍBULA",
                    "nome": qtd + "x MANDÍBULA AMPLIADA OPACO ANCORAGEM",
                    "cdg": "999517A"
                }
            }
            break;

        case 'Padrão':
            if (tipo == 'Opaco') {
                item = {
                    "idProp": idProp,
                    "tipo": "BIOMODELO",
                    "produto": "MANDÍBULA",
                    "nome": qtd + "x MANDÍBULA PADRÃO OPACO",
                    "cdg": "999500"
                }
            } else if (tipo == 'OpacoA') {
                item = {
                    "idProp": idProp,
                    "tipo": "BIOMODELO",
                    "produto": "MANDÍBULA",
                    "nome": qtd + "x MANDÍBULA PADRÃO OPACO ANCORAGEM",
                    "cdg": "999.500A"
                }
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
}

//BIOMODELO MAXILA ID
function changeBiomodMaxila(qtd) {
    qtd = qtd.value;
    let categoria = 'BIOMODELO';

    let tamanho = document.getElementById("tamanhoBiomodMax").value;
    let tipo = document.getElementById("tipoBiomodMax").value;


    let item;
    switch (tamanho) {

        case 'Ampliado':
            if (tipo == 'Opaco') {
                item = {
                    "idProp": idProp,
                    "tipo": "BIOMODELO",
                    "produto": "MAXILA",
                    "nome": qtd + "x MAXILA AMPLIADA OPACO",
                    "cdg": "999512"
                }
            } else if (tipo == 'OpacoA') {
                item = {
                    "idProp": idProp,
                    "tipo": "BIOMODELO",
                    "produto": "MAXILA",
                    "nome": qtd + "x MAXILA AMPLIADA OPACO ANCORAGEM",
                    "cdg": "999512A"
                }
            }
            break;

        case 'Padrão':
            if (tipo == 'Opaco') {
                item = {
                    "idProp": idProp,
                    "tipo": "BIOMODELO",
                    "produto": "MAXILA",
                    "nome": qtd + "x MAXILA PADRÃO OPACO",
                    "cdg": "999501"
                }
            } else if (tipo == 'OpacoA') {
                item = {
                    "idProp": idProp,
                    "tipo": "BIOMODELO",
                    "produto": "MAXILA",
                    "nome": qtd + "x MAXILA PADRÃO OPACO ANCORAGEM",
                    "cdg": "999.501A"
                }
            }
            break;

        default:
            tirarDaLista(categoria);
            break;
    }

    adicionarItemLista(item);
}

//BIOMODELO VÉRTEBRA ID
function changeBiomodVertebra(qtd) {
    qtd = qtd.value;


    let item;
    item = {
        "idProp": idProp,
        "tipo": "BIOMODELO",
        "produto": "VÉRTEBRA",
        "nome": qtd + "x VÉRTEBRA OPACO",
        "cdg": "999505"
    }

    adicionarItemLista(item);
}

//BIOMODELO OMBRO ID
function changeBiomodOmbro(qtd) {
    qtd = qtd.value;


    let item;
    item = {
        "idProp": idProp,
        "tipo": "BIOMODELO",
        "produto": "OMBRO",
        "nome": qtd + "x OMBRO (escapula + glenoide)",
        "cdg": "999556"
    }

    adicionarItemLista(item);
}

//BIOMODELO ORTOGNÁTICA ID
function changeBiomodOrtognatica(qtd) {
    qtd = qtd.value;


    let item;
    item = {
        "idProp": idProp,
        "tipo": "BIOMODELO",
        "produto": "ORTOGNÁTICA",
        "nome": qtd + "x ORTOGNÁTICA (operado mand/max) - Não Estéril",
        "cdg": "999504"
    }

    adicionarItemLista(item);
}

