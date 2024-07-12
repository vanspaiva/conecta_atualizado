<script src="https://cdn01.jotfor.ms/static/prototype.forms.js?3.3.38631" type="text/javascript"></script>
<script src="https://cdn02.jotfor.ms/static/jotform.forms.js?3.3.38631" type="text/javascript"></script>
<script src="https://cdn03.jotfor.ms/s/umd/f3f7c4c7131/for-appointment-field.js?v=3.3.38631" type="text/javascript"></script>
<script src="https://cdn01.jotfor.ms/js/vendor/math-processor.js?v=3.3.38631" type="text/javascript"></script>
<script type="text/javascript">
    JotForm.newDefaultTheme = true;
    JotForm.extendsNewTheme = false;
    JotForm.singleProduct = false;
    JotForm.newPaymentUIForNewCreatedForms = true;
    JotForm.newPaymentUI = true;

    JotForm.setCalculations([{
        "replaceText": "",
        "readOnly": false,
        "newCalculationType": true,
        "useCommasForDecimals": false,
        "operands": "3",
        "equation": "{3}",
        "showBeforeInput": false,
        "showEmptyDecimals": false,
        "ignoreHiddenFields": false,
        "insertAsText": false,
        "id": "action_1665082873236",
        "resultField": "11",
        "decimalPlaces": "2",
        "isError": false,
        "conditionId": "1665082890787",
        "conditionTrue": false,
        "baseField": "3"
    }]);
    JotForm.setConditions([{
        "action": [{
            "replaceText": "",
            "readOnly": false,
            "newCalculationType": true,
            "useCommasForDecimals": false,
            "operands": "3",
            "equation": "{3}",
            "showBeforeInput": false,
            "showEmptyDecimals": false,
            "ignoreHiddenFields": false,
            "insertAsText": false,
            "id": "action_1665082873236",
            "resultField": "11",
            "decimalPlaces": "2",
            "isError": false,
            "conditionId": "1665082890787",
            "conditionTrue": false,
            "baseField": "3"
        }],
        "id": "1665082890787",
        "index": "0",
        "link": "Any",
        "priority": "0",
        "terms": [{
            "id": "term_1665082873236",
            "field": "3",
            "operator": "isFilled",
            "value": "",
            "isError": false
        }],
        "type": "calculation"
    }]);
    JotForm.clearFieldOnHide = "disable";
    JotForm.submitError = "jumpToFirstError";

    JotForm.init(function() {
        /*INIT-START*/
        if (window.JotForm && JotForm.accessible) $('input_4').setAttribute('tabindex', 0);
        if (window.JotForm && JotForm.accessible) $('input_5').setAttribute('tabindex', 0);
        if (window.JotForm && JotForm.accessible) $('input_6').setAttribute('tabindex', 0);
        if (window.JotForm && JotForm.accessible) $('input_7').setAttribute('tabindex', 0);
        if (window.JotForm && JotForm.accessible) $('input_8').setAttribute('tabindex', 0);
        if (window.JotForm && JotForm.accessible) $('input_9').setAttribute('tabindex', 0);
        if (window.JotForm && JotForm.accessible) $('input_11').setAttribute('tabindex', 0);

        JotForm.calendarMonths = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
        JotForm.appointmentCalendarDays = ["Segunda", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado", "Domingo"];
        JotForm.calendarOther = "Today";
        window.initializeAppointment({
            "text": {
                "text": "Question",
                "value": "Agendamento de Vídeo"
            },
            "labelAlign": {
                "text": "Label Align",
                "value": "Top",
                "dropdown": [
                    ["Auto", "Auto"],
                    ["Left", "Left"],
                    ["Right", "Right"],
                    ["Top", "Top"]
                ]
            },
            "required": {
                "text": "Required",
                "value": "No",
                "dropdown": [
                    ["No", "No"],
                    ["Yes", "Yes"]
                ]
            },
            "description": {
                "text": "Hover Text",
                "value": "",
                "textarea": true
            },
            "slotDuration": {
                "text": "Slot Duration",
                "value": "30",
                "dropdown": [
                    [15, "15 min"],
                    [30, "30 min"],
                    [45, "45 min"],
                    [60, "60 min"],
                    ["custom", "Custom min"]
                ],
                "hint": "Select how long each slot will be."
            },
            "startDate": {
                "text": "Start Date",
                "value": ""
            },
            "endDate": {
                "text": "End Date",
                "value": ""
            },
            "intervals": {
                "text": "Intervals",
                "value": [{
                    "from": "09:00",
                    "to": "17:00",
                    "days": ["Mon", "Tue", "Wed", "Thu", "Fri"]
                }],
                "hint": "The hours will be applied to the selected days and repeated."
            },
            "useBlockout": {
                "text": "Blockout Custom Dates",
                "value": "No",
                "dropdown": [
                    ["No", "No"],
                    ["Yes", "Yes"]
                ],
                "hint": "Disable certain date(s) in the calendar."
            },
            "blockoutDates": {
                "text": "Blockout dates",
                "value": [{
                    "startDate": "",
                    "endDate": ""
                }]
            },
            "useLunchBreak": {
                "text": "Lunch Time",
                "value": "Yes",
                "dropdown": [
                    ["No", "No"],
                    ["Yes", "Yes"]
                ],
                "hint": "Enable lunchtime in the calendar."
            },
            "lunchBreak": {
                "text": "Lunchtime hours",
                "value": [{
                    "from": "12:00",
                    "to": "14:00"
                }]
            },
            "timezone": {
                "text": "Timezone",
                "value": "America/Sao_Paulo (GMT-03:00)"
            },
            "timeFormat": {
                "text": "Time Format",
                "value": "24 Hour",
                "dropdown": [
                    ["24 Hour", "24 Hour"],
                    ["AM/PM", "AM/PM"]
                ],
                "icon": "images/blank.gif",
                "iconClassName": "toolbar-time_format_24"
            },
            "months": {
                "value": ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                "hidden": true
            },
            "days": {
                "value": ["Segunda", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado", "Domingo"],
                "hidden": true
            },
            "startWeekOn": {
                "text": "Start Week On",
                "value": "Sunday",
                "dropdown": [
                    ["Monday", "Monday"],
                    ["Sunday", "Sunday"]
                ],
                "toolbar": false
            },
            "rollingDays": {
                "text": "Rolling Days",
                "value": "",
                "toolbar": false
            },
            "prevMonthButtonText": {
                "text": "Previous month",
                "value": ""
            },
            "nextMonthButtonText": {
                "text": "Next month",
                "value": ""
            },
            "prevYearButtonText": {
                "text": "Previous year",
                "value": ""
            },
            "nextYearButtonText": {
                "text": "Next year",
                "value": ""
            },
            "prevDayButtonText": {
                "text": "Previous day",
                "value": ""
            },
            "nextDayButtonText": {
                "text": "Next day",
                "value": ""
            },
            "appointmentType": {
                "hidden": true,
                "value": "single"
            },
            "autoDetectTimezone": {
                "hidden": true,
                "value": "Yes"
            },
            "dateFormat": {
                "hidden": true,
                "value": "dd/mm/yyyy"
            },
            "maxAttendee": {
                "hidden": true,
                "value": "5"
            },
            "maxEvents": {
                "hidden": true,
                "value": ""
            },
            "minScheduleNotice": {
                "hidden": true,
                "value": "60"
            },
            "name": {
                "hidden": true,
                "value": "agendamentoDe"
            },
            "order": {
                "hidden": true,
                "value": "8"
            },
            "qid": {
                "toolbar": false,
                "value": "input_3"
            },
            "reminderEmails": {
                "hidden": true,
                "value": {
                    "schedule": [{
                        "value": "2",
                        "unit": "hour"
                    }]
                }
            },
            "type": {
                "hidden": true,
                "value": "control_appointment"
            },
            "useReminderEmails": {
                "hidden": true,
                "value": "No"
            },
            "id": {
                "toolbar": false,
                "value": "3"
            },
            "qname": {
                "toolbar": false,
                "value": "q3_agendamentoDe"
            },
            "cdnconfig": {
                "CDN": "https://cdn.jotfor.ms/"
            },
            "passive": false,
            "formProperties": {
                "products": false,
                "highlightLine": "Enabled",
                "coupons": false,
                "useStripeCoupons": false,
                "taxes": false,
                "comparePaymentForm": "",
                "paymentListSettings": false,
                "newPaymentUIForNewCreatedForms": "Yes",
                "formBackground": "#fff",
                "newAppointment": false
            },
            "formID": 222764549437062,
            "isPaymentForm": false,
            "isOpenedInPortal": false,
            "isCheckoutForm": false,
            "cartProducts": [],
            "isFastCheckoutShoppingApp": false,
            "translatedProductListTexts": false,
            "productListColors": false,
            "themeVersion": "v2"
        });
        JotForm.alterTexts({
            "ageVerificationError": "Você deve ter mais de {minAge} anos para enviar este formulário.",
            "alphabetic": "Este campo pode conter apenas letras.",
            "alphanumeric": "Este campo pode conter apenas letras e números.",
            "appointmentSelected": "Você selecionou {time} em {date}.",
            "ccDonationMinLimitError": "O valor mínimo é de {minAmount} {currency}",
            "ccInvalidCVC": "Código de verificação (CVV) inválido.",
            "ccInvalidExpireDate": "Data de vencimento inválida.",
            "ccInvalidNumber": "Número do cartão de crédito inválido.",
            "ccMissingDetails": "Please fill up the credit card details.",
            "ccMissingDonation": "Insira valores numéricos para o montante de doação.",
            "ccMissingProduct": "Selecione pelo menos um produto.",
            "characterLimitError": "Excesso de caracteres. O limite é de",
            "characterMinLimitError": "Poucos caracteres. O mínimo é",
            "confirmClearForm": "Tem certeza de que deseja limpar este formulário?",
            "confirmEmail": "E-mail não é correspondente.",
            "currency": "Este campo pode conter apenas valores monetários.",
            "cyrillic": "Este campo pode conter apenas caracteres cirílicos.",
            "dateInvalid": "Esta data não é válida. O formato da data é {format}.",
            "dateInvalidSeparate": "Esta data não é válida. Insira um {element} válido.",
            "dateLimited": "Esta data não está disponível.",
            "disallowDecimals": "Favor inserir um número inteiro.",
            "dragAndDropFilesHere_infoMessage": "Arraste e solte seus arquivos aqui",
            "email": "Insira um endereço de e-mail válido.",
            "fillMask": "Valor do campo deve preencher máscara.",
            "freeEmailError": "Não são permitidas contas de e-mail gratuitas.",
            "generalError": "O formulário contém erros. Por favor, corrija-os antes de continuar.",
            "generalPageError": "Há erros nesta página. Por favor, corrija-os antes de continuar.",
            "gradingScoreError": "Pontuação total deve ser menor ou igual a",
            "incompleteFields": "Há campos obrigatórios incompletos. Por favor, preencha-os.",
            "inputCarretErrorA": "A entrada não deve ser menor que o valor mínimo:",
            "inputCarretErrorB": "A entrada não deve ser maior que o valor máximo:",
            "justSoldOut": "Acabou de Esgotar",
            "lessThan": "Sua pontuação deve ser inferior ou igual a",
            "maxDigitsError": "O número máximo de caracteres permitido é de",
            "maxFileSize_infoMessage": "Tamanho máx.",
            "maxSelectionsError": "The maximum number of selections allowed is ",
            "minSelectionsError": "O número mínimo de seleções exigido é",
            "multipleFileUploads_emptyError": "{file} está vazio. Por favor, selecione os arquivos novamente.",
            "multipleFileUploads_fileLimitError": "São permitidos apenas {fileLimit} uploads.",
            "multipleFileUploads_minSizeError": "O arquivo {file} é muito pequeno. O tamanho mínimo é de {minSizeLimit}.",
            "multipleFileUploads_onLeave": "O upload de arquivos está em andamento. Se você sair agora, o envio será cancelado.",
            "multipleFileUploads_sizeError": "O arquivo {file} é muito grande. O tamanho máximo é de {sizeLimit}.",
            "multipleFileUploads_typeError": "O arquivo {file} possui uma extensão inválida. São permitidas apenas as extensões {extensions}.",
            "multipleFileUploads_uploadFailed": "File upload failed, please remove it and upload the file again.",
            "noSlotsAvailable": "Nenhum horário disponível",
            "notEnoughStock": "Não há estoque suficiente para a seleção atual",
            "notEnoughStock_remainedItems": "Não há estoque suficiente para a seleção atual ({count} itens restantes)",
            "noUploadExtensions": "File has no extension file type (e.g. .txt, .png, .jpeg)",
            "numeric": "Este campo pode conter apenas números.",
            "pastDatesDisallowed": "A data não pode estar no passado.",
            "pleaseWait": "Por favor, aguarde...",
            "required": "Este campo é obrigatório.",
            "requireEveryCell": "Toda célula é obrigatória.",
            "requireEveryRow": "Todos as linhas são obrigatórias.",
            "requireOne": "Pelo menos um campo é obrigatório.",
            "restrictedDomain": "This domain is not allowed",
            "selectionSoldOut": "Seleção Esgotada",
            "slotUnavailable": "{time} em {date} já foi ocupado. Selecione outro horário.",
            "soldOut": "Esgotado",
            "subProductItemsLeft": "({count} itens restantes)",
            "uploadExtensions": "Somente é possível fazer upload dos seguintes arquivos:",
            "uploadFilesize": "O tamanho do arquivo não pode ser maior que:",
            "uploadFilesizemin": "O ficheiro não pode ser menor que:",
            "url": "Este campo pode conter apenas uma URL válida.",
            "validateEmail": "Você precisa validar este e-mail",
            "wordLimitError": "Excesso de palavras. O limite é de",
            "wordMinLimitError": "Poucas palavras. O mínimo é"
        });
        /*INIT-END*/
    });

    JotForm.prepareCalculationsOnTheFly([null, null, {
        "name": "submit2",
        "qid": "2",
        "text": "Salvar",
        "type": "control_button"
    }, {
        "description": "",
        "name": "agendamentoDe",
        "qid": "3",
        "text": "Agendamento de Video",
        "type": "control_appointment"
    }, {
        "description": "",
        "name": "tipoVideo",
        "qid": "4",
        "subLabel": "",
        "text": "Tipo Video",
        "type": "control_textbox"
    }, {
        "description": "",
        "name": "projeto5",
        "qid": "5",
        "subLabel": "",
        "text": "Projeto",
        "type": "control_textbox"
    }, {
        "description": "",
        "name": "usuario",
        "qid": "6",
        "subLabel": "",
        "text": "Usuario",
        "type": "control_textbox"
    }, {
        "description": "",
        "name": "doutor",
        "qid": "7",
        "subLabel": "",
        "text": "Doutor",
        "type": "control_textbox"
    }, {
        "description": "",
        "name": "paciente",
        "qid": "8",
        "subLabel": "",
        "text": "Paciente",
        "type": "control_textbox"
    }, {
        "description": "",
        "name": "produto",
        "qid": "9",
        "subLabel": "",
        "text": "Produto",
        "type": "control_textbox"
    }, null, {
        "description": "",
        "name": "dataEscrita",
        "qid": "11",
        "subLabel": "",
        "text": "Data Escrita",
        "type": "control_textbox"
    }]);
    setTimeout(function() {
        JotForm.paymentExtrasOnTheFly([null, null, {
            "name": "submit2",
            "qid": "2",
            "text": "Salvar",
            "type": "control_button"
        }, {
            "description": "",
            "name": "agendamentoDe",
            "qid": "3",
            "text": "Agendamento de Video",
            "type": "control_appointment"
        }, {
            "description": "",
            "name": "tipoVideo",
            "qid": "4",
            "subLabel": "",
            "text": "Tipo Video",
            "type": "control_textbox"
        }, {
            "description": "",
            "name": "projeto5",
            "qid": "5",
            "subLabel": "",
            "text": "Projeto",
            "type": "control_textbox"
        }, {
            "description": "",
            "name": "usuario",
            "qid": "6",
            "subLabel": "",
            "text": "Usuario",
            "type": "control_textbox"
        }, {
            "description": "",
            "name": "doutor",
            "qid": "7",
            "subLabel": "",
            "text": "Doutor",
            "type": "control_textbox"
        }, {
            "description": "",
            "name": "paciente",
            "qid": "8",
            "subLabel": "",
            "text": "Paciente",
            "type": "control_textbox"
        }, {
            "description": "",
            "name": "produto",
            "qid": "9",
            "subLabel": "",
            "text": "Produto",
            "type": "control_textbox"
        }, null, {
            "description": "",
            "name": "dataEscrita",
            "qid": "11",
            "subLabel": "",
            "text": "Data Escrita",
            "type": "control_textbox"
        }]);
    }, 20);
</script>
<style type="text/css">
    @media print {
        .form-section {
            display: inline !important
        }

        .form-pagebreak {
            display: none !important
        }

        .form-section-closed {
            height: auto !important
        }

        .page-section {
            position: initial !important
        }
    }
</style>
<link type="text/css" rel="stylesheet" href="https://cdn01.jotfor.ms/themes/CSS/5e6b428acc8c4e222d1beb91.css?themeRevisionID=6310a6ad592c72439615db25" />
<link type="text/css" rel="stylesheet" href="https://cdn02.jotfor.ms/css/styles/payment/payment_styles.css?3.3.38631" />
<link type="text/css" rel="stylesheet" href="https://cdn03.jotfor.ms/css/styles/payment/payment_feature.css?3.3.38631" />
<style type="text/css" id="form-designer-style">
    /* Injected CSS Code */
    /*PREFERENCES STYLE*/
    .form-all {
        font-family: Inter, sans-serif;
    }

    .form-all .qq-upload-button,
    .form-all .form-submit-button,
    .form-all .form-submit-reset,
    .form-all .form-submit-print {
        font-family: Inter, sans-serif;
    }

    .form-all .form-pagebreak-back-container,
    .form-all .form-pagebreak-next-container {
        font-family: Inter, sans-serif;
    }

    .form-header-group {
        font-family: Inter, sans-serif;
    }

    .form-label {
        font-family: Inter, sans-serif;
    }

    .form-label.form-label-auto {

        display: block;
        float: none;
        text-align: left;
        width: 100%;

    }

    .form-line {
        margin-top: 12px;
        margin-bottom: 12px;
    }

    .form-all {
        max-width: 752px;
        width: 100%;
    }

    .form-label.form-label-left,
    .form-label.form-label-right,
    .form-label.form-label-left.form-label-auto,
    .form-label.form-label-right.form-label-auto {
        width: 230px;
    }

    .form-all {
        font-size: 16px
    }

    .form-all .qq-upload-button,
    .form-all .qq-upload-button,
    .form-all .form-submit-button,
    .form-all .form-submit-reset,
    .form-all .form-submit-print {
        font-size: 16px
    }

    .form-all .form-pagebreak-back-container,
    .form-all .form-pagebreak-next-container {
        font-size: 16px
    }

    .supernova .form-all,
    .form-all {
        background-color: #fff;
    }

    .form-all {
        color: #2C3345;
    }

    .form-header-group .form-header {
        color: #2C3345;
    }

    .form-header-group .form-subHeader {
        color: #2C3345;
    }

    .form-label-top,
    .form-label-left,
    .form-label-right,
    .form-html,
    .form-checkbox-item label,
    .form-radio-item label,
    span.FITB .qb-checkbox-label,
    span.FITB .qb-radiobox-label,
    span.FITB .form-radio label,
    span.FITB .form-checkbox label,
    [data-blotid][data-type=checkbox] [data-labelid],
    [data-blotid][data-type=radiobox] [data-labelid],
    span.FITB-inptCont[data-type=checkbox] label,
    span.FITB-inptCont[data-type=radiobox] label {
        color: #2C3345;
    }

    .form-sub-label {
        color: #464d5f;
    }

    .supernova {
        background-color: rgba(255, 255, 255, 0);
    }

    .supernova body {
        background: transparent;
    }

    .form-textbox,
    .form-textarea,
    .form-dropdown,
    .form-radio-other-input,
    .form-checkbox-other-input,
    .form-captcha input,
    .form-spinner input {
        background-color: #fff;
    }

    .supernova {
        background-image: none;
    }

    #stage {
        background-image: none;
    }

    .form-all {
        background-image: none;
    }

    .ie-8 .form-all:before {
        display: none;
    }

    .ie-8 {
        margin-top: auto;
        margin-top: initial;
    }

    /*PREFERENCES STYLE*/
    /*__INSPECT_SEPERATOR__*/
    /* Injected CSS Code */
</style>

 <form class="jotform-form" action="https://submit.jotform.com/submit/222764549437062/" method="post" name="form_222764549437062" id="222764549437062" accept-charset="utf-8" autocomplete="on"><input type="hidden" name="formID" value="222764549437062" /><input type="hidden" id="JWTContainer" value="" /><input type="hidden" id="cardinalOrderNumber" value="" />
    <div role="main" class="form-all">
        <style>
            .form-all:before {
                background: none;
            }
        </style>
        <ul class="form-section page-section">
            <li class="form-line form-line-column form-col-1 always-hidden" data-type="control_textbox" id="id_4"><label class="form-label form-label-top form-label-auto" id="label_4" for="input_4"> Tipo Vídeo </label>
                <div id="cid_4" class="form-input-wide always-hidden" data-layout="half"> <input type="text" id="input_4" name="q4_tipoVideo" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_4" /> </div>
            </li>
            <li class="form-line form-line-column form-col-2 always-hidden" data-type="control_textbox" id="id_5"><label class="form-label form-label-top form-label-auto" id="label_5" for="input_5"> Projeto </label>
                <div id="cid_5" class="form-input-wide always-hidden" data-layout="half"> <input type="text" id="input_5" name="q5_projeto5" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_5" /> </div>
            </li>
            <li class="form-line form-line-column form-col-3 always-hidden" data-type="control_textbox" id="id_6"><label class="form-label form-label-top form-label-auto" id="label_6" for="input_6"> Usuário </label>
                <div id="cid_6" class="form-input-wide always-hidden" data-layout="half"> <input type="text" id="input_6" name="q6_usuario" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_6" /> </div>
            </li>
            <li class="form-line form-line-column form-col-4 always-hidden" data-type="control_textbox" id="id_7"><label class="form-label form-label-top form-label-auto" id="label_7" for="input_7"> Doutor </label>
                <div id="cid_7" class="form-input-wide always-hidden" data-layout="half"> <input type="text" id="input_7" name="q7_doutor" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_7" /> </div>
            </li>
            <li class="form-line form-line-column form-col-5 always-hidden" data-type="control_textbox" id="id_8"><label class="form-label form-label-top form-label-auto" id="label_8" for="input_8"> Paciente </label>
                <div id="cid_8" class="form-input-wide always-hidden" data-layout="half"> <input type="text" id="input_8" name="q8_paciente" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_8" /> </div>
            </li>
            <li class="form-line form-line-column form-col-6 always-hidden" data-type="control_textbox" id="id_9"><label class="form-label form-label-top form-label-auto" id="label_9" for="input_9"> Produto </label>
                <div id="cid_9" class="form-input-wide always-hidden" data-layout="half"> <input type="text" id="input_9" name="q9_produto" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_9" /> </div>
            </li>
            <li class="form-line form-line-column form-col-7 always-hidden" data-type="control_textbox" id="id_11"><label class="form-label form-label-top form-label-auto" id="label_11" for="input_11"> Data Escrita </label>
                <div id="cid_11" class="form-input-wide always-hidden" data-layout="half"> <input type="text" id="input_11" name="q11_dataEscrita" data-type="input-textbox" class="form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_11" /> </div>
            </li>
            <li class="form-line" data-type="control_appointment" id="id_3"><label class="form-label form-label-top" id="label_3" for="input_3"> Agendamento de Vídeo </label>
                <div id="cid_3" class="form-input-wide" data-layout="full">
                    <div id="input_3" class="appointmentFieldWrapper jfQuestion-fields"><input class="appointmentFieldInput" name="q3_agendamentoDe[implementation]" value="new" id="input_3implementation" /><input class="appointmentFieldInput " name="q3_agendamentoDe[date]" id="input_3_date" data-timeformat="24 Hour" /><input class="appointmentFieldInput" name="q3_agendamentoDe[duration]" value="30" id="input_3_duration" /><input class="appointmentFieldInput" name="q3_agendamentoDe[timezone]" value="America/Sao_Paulo (GMT-03:00)" id="input_3_timezone" />
                        <div class="appointmentField"></div>
                    </div>
                </div>
            </li>
            <li class="form-line" data-type="control_button" id="id_2">
                <div id="cid_2" class="form-input-wide" data-layout="full">
                    <div data-align="auto" class="form-buttons-wrapper form-buttons-auto jsTest-button-wrapperField"><button id="input_2" type="submit" class="form-submit-button form-submit-button-simple_orange submit-button jf-form-buttons jsTest-submitField" data-component="button" data-content="">Salvar</button></div>
                </div>
            </li>
            <li style="display:none">Should be Empty: <input type="text" name="website" value="" /></li>
        </ul>
    </div>
    <script>
        JotForm.showJotFormPowered = "0";
    </script>
    <script>
        JotForm.poweredByText = "Powered by Jotform";
    </script><input type="hidden" class="simple_spc" id="simple_spc" name="simple_spc" value="222764549437062" />
    <script type="text/javascript">
        var all_spc = document.querySelectorAll("form[id='222764549437062'] .si" + "mple" + "_spc");
        for (var i = 0; i < all_spc.length; i++) {
            all_spc[i].value = "222764549437062-222764549437062";
        }
    </script>
</form>
<script type="text/javascript">
    JotForm.ownerView = true;
</script>
<script src="https://cdn.jotfor.ms//js/vendor/smoothscroll.min.js?v=3.3.38631"></script>
<script src="https://cdn.jotfor.ms//js/errorNavigation.js?v=3.3.38631"></script>