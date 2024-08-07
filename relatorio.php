<?php
session_start();
// if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador')) || ($_SESSION["userperm"] == 'Qualidade') || ($_SESSION["userperm"] == 'Planejador(a)')) {
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador')) || ($_SESSION["userperm"] == 'Fábrica') || ($_SESSION["userperm"] == 'Qualidade')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $idProjeto = deshashItemNatural(addslashes($_GET['id']));
    if (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)')) {
        $permission = true;
    } else {
        $permission = false;
    }

    //chamar do banco de dados todos os casos
    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idProjeto'");
    while ($row = mysqli_fetch_array($ret)) {
        $propID = $row['pedPropRef'];
        $encrypted = hashItemNatural($propID);
        $pedID = $row['pedNumPedido'];
        $usercriacao = $row['pedUserCriador'];
        $observacao = $row['pedObservacao'];

        $pedIDHASH = hashItem($pedID);
        $usercriacaoHASH = hashItem($usercriacao);


        $id = $row['pedId'];
        $tipoProd = $row['pedTipoProduto'];
        $nomedr = $row['pedNomeDr'];
        $nomepac = $row['pedNomePac'];

        $dtInicioBD = $row['pedDtCriacaoPed'];
        $dtInicioBD = explode(" ", $dtInicioBD);
        $dataInicioAmericana = $dtInicioBD[0];
        $HoraInicioAmericana = $dtInicioBD[1];

        $dataInicioAmericana = explode("-", $dataInicioAmericana);
        $HoraInicioAmericana = explode(":", $HoraInicioAmericana);

        $dataInicio = $dataInicioAmericana[2] . '/' . $dataInicioAmericana[1] . '/' . $dataInicioAmericana[0];
        $horaInicio = $HoraInicioAmericana[0] . ':' . $HoraInicioAmericana[1];
        $dtInicioProj = $dataInicio . ' ' . $horaInicio;


        $numFluxo = $row['pedPosicaoFluxo'];
        $numFluxo = intval($numFluxo);
        $numFluxo = $numFluxo * 20;

        $andamento = $row['pedStatus'];

        $nomeFluxo = getNomeFluxoPed($conn, $pedID);
        $corFluxo = getCorFluxoPed($conn, $pedID);

        $docsFaltantes = $row['pedDocsFaltantes'];
        $pedStatus = $row['pedStatus'];

        //pesquisar proposta
        $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='$propID';");
        while ($rowProp = mysqli_fetch_array($retProp)) {
            $cdgCallisto = $rowProp['propListaItens'];
            $cdgCallisto = explode(',', $cdgCallisto);
            $cdgImg = $cdgCallisto[0];
        }

        $linkPasta = "";
        $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $propID . "' ;");
        while ($rowFile = mysqli_fetch_array($retFile)) {
            $linkPasta = $rowFile['fileCdnUrl'];
        }

        //pesquisar imagem
        $retImg = mysqli_query($conn, "SELECT * FROM imagensprodutos WHERE imgprodCodCallisto='$cdgImg';");
        while ($rowImg = mysqli_fetch_array($retImg)) {
            $linkImg = $rowImg['imgprodLink'];
            $altImg = $rowImg['imgprodNome'];
            $categoria = $rowImg['imgprodCategoria'];
        }

        // set the default timezone to use.
        date_default_timezone_set('UTC');
        $dtz = new DateTimeZone("America/Sao_Paulo");
        $dt = new DateTime("now", $dtz);
        $datacriacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

        $dataPrazoContada = getDataPrazoContada($conn, $pedID);
        $andamentoFluxo = getAndamentoFluxoPed($conn, $pedID);

        $iconAnexoidr = "";
        $iconAnexoiiidr = "";
        $iconAnexoii = "";
        $iconAnexoipac = "";
        $iconAnexoiiipac = "";


        
        if(getNomeFinalizador($conn, $pedID)){
            $nomeFinalizador = getNomeFinalizador($conn, $pedID);
        } else{
            $nomeFinalizador = "?";
        }

        if(getDataFinalizador($conn, $pedID)){
            $dataFinalizador = dateFormat2(getDataFinalizador($conn, $pedID));
        } else{
            $dataFinalizador = "?";
        }

        
?>


        <style>
            .nav-link.disabled {
                color: silver !important;
            }

            .bg-amarelo {
                background-color: #FAF53D;
            }

            .bg-verde-claro {
                background-color: #9FFFD2;
            }

            .bg-verde {
                background-color: #34B526;
            }

            .bg-rosa {
                background-color: #FAA4B5;
            }

            .bg-vermelho {
                background-color: #FA242A;
            }

            .bg-vermelho-claro {
                background-color: #FA6069;
            }

            .bg-roxo {
                background-color: #C165FF;
            }

            .bg-azul {
                background-color: #42A1DB;
            }

            .bg-cinza {
                background-color: #cfcfcf;
            }

            .bg-lilas {
                background-color: #8665E6;
            }
        </style>

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';
            ?>

            <style>
                .available i {
                    color: #fdae78 !important;
                }
            </style>

            <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
            <div id="main" class="font-montserrat">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-1 d-flex justify-content-end">
                            <a class='button-back p-0 m-0 pt-2' type='button' onclick='history.go(-1)' style='color: #ee7624'><i class='fas fa-chevron-left fa-2x'></i></a>
                        </div>
                        <div class="col">
                            <h2 class="text-conecta" style="font-weight: 400;">Projeto <span style="font-weight: 700;"><?php echo $pedID; ?></span></h2>
                            <hr style="border-color: #ee7624;">
                            <br>
                        </div>
                    </div>

                    <div class="row my-2 p-1 d-flex justify-content-center">
                        <div class="col-sm-11">
                            <div class="card shadow rounded">
                                <div class="card-head"></div>
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-sm-2 d-flex align-items-end">
                                            <span class="d-flex justify-content-center shadow-sm" style="border-radius: 50%; padding: 5px 10px;">
                                                <img class="img-icon-case" src="<?php echo $linkImg; ?>" alt="<?php echo $altImg; ?>">
                                            </span>
                                        </div>
                                        <div class="col-sm p-2">
                                            <div class="row d-flex align-itens-center justify-content-start pt-2">
                                                <h5 class="d-flex justify-content-center"><span class="badge <?php echo $corFluxo; ?>" style="color: #ffffff;"><?php echo $nomeFluxo; ?></span></h5>
                                            </div>
                                            <div class="row d-flex align-items-center justify-content-start">
                                                <h4><?php echo $tipoProd; ?>
                                                    <?php
                                                    if ($permission) {
                                                    ?>
                                                        <a href="update-caso?id=<?php echo $id; ?>">
                                                            <span class="btn text-conecta"><i class="fas fa-edit"></i></span>
                                                        </a>

                                                        <a href="<?php echo $linkPasta; ?>" class="btn text-secondary" target="_blank"><i class="fab fa-google-drive"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </h4>
                                            </div>
                                            <div class="row d-flex align-items-center justify-content-start">
                                                Doutor(a): <?php echo $nomedr; ?>
                                            </div>
                                            <div class="row d-flex align-items-center justify-content-start">
                                                Paciente: <?php echo $nomepac; ?>
                                            </div>

                                        </div>
                                        <div class="col-sm-4 p-4">
                                            <div>
                                                <h5 class="text-conecta">Confira aqui o progresso do seu pedido</h5>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $numFluxo; ?>%" aria-valuenow="<?php echo $numFluxo; ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <?php echo $numFluxo . '%'; ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="row my-2 p-1 d-flex justify-content-center">

                        <div class="col-sm-11">
                            <div class="row">
                                <!--Cartão Principal com ABAS-->
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-head"></div>
                                        <div class="card-body">
                                            <div>
                                                <h4 class="text-muted"> <b>Descritivo do Pedido</b></h4>
                                                <div class="row">
                                                    <div class="col">
                                                        <div>
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col"><b>#</b></th>
                                                                        <th scope="col"><b>Cdg</b></th>
                                                                        <th scope="col"><b>Descrição</b></th>
                                                                        <th scope="col"><b>Qtd</b></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    $retItens = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $propID . "';");
                                                                    while ($rowItens = mysqli_fetch_array($retItens)) {
                                                                    ?>
                                                                        <tr>
                                                                            <th><?php echo $i ?></th>
                                                                            <td><?php echo $rowItens['itemCdg']; ?></td>
                                                                            <td><?php echo $rowItens['itemNome']; ?></td>
                                                                            <td><?php echo $rowItens['itemQtd']; ?></td>
                                                                        </tr>
                                                                    <?php
                                                                        $i++;
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div>
                                                <h4 class="text-muted"> <b>Relatório</b></h4>
                                                <div class="row">
                                                    <div class="col">
                                                        <?php
                                                        $retRelatorio = mysqli_query($conn, "SELECT * FROM relatorios WHERE relNumPedRef='$idProjeto';");
                                                        while ($rowRelatorio = mysqli_fetch_array($retRelatorio)) {
                                                            if ($rowRelatorio['relStatus'] == 'VAZIO') {
                                                        ?>
                                                                <div class="d-flex justify-content-center">
                                                                    <span class="alert alert-warning">Nenhum relatório disponível</span>
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <hr style="border-bottom: 1px solid silver;">
                                                                <div class="d-flex justify-content-center">
                                                                    <h4 class="py-4">Novo Relatório disponível!</h4>
                                                                </div>
                                                                <?php
                                                                $retFile = mysqli_query($conn, "SELECT * FROM relatorios WHERE relNumPedRef= '" . $idProjeto . "' ;");
                                                                while ($rowFile = mysqli_fetch_array($retFile)) {
                                                                    $urlDownload = $rowFile['relPath'];
                                                                }
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col d-flex justify-content-center">
                                                                        <a id="btndownload" class="btn btn-conecta" href="<?php echo $urlDownload; ?>" target="_blank"><i class="fas fa-file-download"></i> Baixar Relatório</a>
                                                                    </div>
                                                                </div>
                                                                <div class="row py-4">
                                                                    <div class="col">
                                                                        <embed src="<?php echo $urlDownload; ?>" type="application/pdf" width="100%" height="750px" />
                                                                    </div>
                                                                </div>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card shadow mr-1 mb-3 rounded w-100" style="border-top: #ee7624 7px solid;">
                                        <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col">
                                                        <h2 class="pb-2 text-conecta text-center" style="font-weight: bold;">Projeto <?php echo $idProjeto; ?></h2>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col">
                                                        <p style="line-height: 1.5rem; font-size: small;"><b>Início do Projeto: </b> <?php echo $dtInicioProj; ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <p style="line-height: 1.5rem; font-size: small;"> <b>Proposta de Ref.: </b> <?php echo $propID; ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <p style="line-height: 1.5rem; font-size: small;"><b>Status: </b> <span class="badge badge-info"><?php echo $nomeFluxo; ?></p></span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <?php
                                                if ($pedStatus == "ENVIADO") {
                                                ?>
                                                    <div class="row">
                                                        <div class="col text-center">
                                                            <div class="badge badge-success">Pedido Finalizado!</div>
                                                            <p style="line-height: 1.5rem; font-size: small;" class="pt-2">Finalizado por <?php echo $nomeFinalizador; ?> na data <?php echo $dataFinalizador; ?></p>

                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="row">
                                                        <div class="col text-center">
                                                            <span class="btn btn-conecta" data-toggle="modal" data-target="#certezarefazer"> Finalizar Pedido</span>
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


                    </div>

                </div>
            </div>

            <!-- Modal Certeza Refazer Análise Rápida de Tomografia-->
            <div class="modal fade" id="certezarefazer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="container-fluid">
                                <div class="row pt-4">
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <p style="line-height: 1.5rem; font-size: small;">Ao finalizar o Pedido será armazenado a <span class="text-conecta">data</span> e o <span class="text-conecta">usuário</span> que realizou a ação. Está ciente e deseja prosseguir?</p>

                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col d-flex justify-content-center">
                                        <button type="button" class="btn btn-outline-conecta mr-2" id="btnCloseCerteza" data-dismiss="modal" aria-label="Fechar">
                                            Cancelar
                                        </button>

                                        <a class="btn btn-conecta ml-2" href="finalizarpedido?id=<?php echo $idProjeto;?>"> Ciente</a>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <?php include_once 'php/footer_index.php' ?>
            <script src="https://cdn01.jotfor.ms/static/prototype.forms.js?3.3.36261" type="text/javascript"></script>
            <script src="https://cdn02.jotfor.ms/static/jotform.forms.js?3.3.36261" type="text/javascript"></script>
            <script src="https://cdn03.jotfor.ms//s/umd/ie11/for-appointment-field.js" type="text/javascript"></script>
            <script type="text/javascript">
                JotForm.newDefaultTheme = true;
                JotForm.extendsNewTheme = false;
                JotForm.singleProduct = false;
                JotForm.newPaymentUIForNewCreatedForms = true;
                JotForm.newPaymentUI = true;
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

                    JotForm.calendarMonths = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
                    JotForm.appointmentCalendarDays = ["Segunda", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado", "Domingo"];
                    JotForm.calendarOther = "Today";

                    JotForm.checkAppointmentAvailability = function checkAppointmentAvailability(day, slot, data) {
                        if (!(day && slot && data && data[day])) return false;
                        return data[day][slot];
                    };

                    (function init(props) {
                        var PREFIX = window.location.href.indexOf('jotform.pro') > -1 || window.location.pathname.indexOf('build') > -1 || window.location.pathname.indexOf('form-templates') > -1 || window.location.pathname.indexOf('pdf-templates') > -1 || window.location.pathname.indexOf('table-templates') > -1 || window.location.pathname.indexOf('approval-templates') > -1 ? '/server.php' : JotForm.server;

                        // boilerplate
                        var effectsOut = null;
                        var changed = {};
                        var constructed = false;
                        var _window = window,
                            document = _window.document;

                        var wrapper = document.querySelector('#' + props.qid.value);
                        var uniqueId = props.qid.value;
                        var element = wrapper.querySelector('.appointmentField');
                        var input = wrapper.querySelector('#input_' + props.id.value + '_date');
                        var tzInput = wrapper.querySelector('#input_' + props.id.value + '_timezone');
                        var currentYear = new Date().getFullYear();
                        var timezonePickerCommon = void 0;
                        var isTimezonePickerFromCommonLoaded = false;

                        function debounce(func, wait, immediate) {
                            var timeout = void 0;
                            return function wrappedFN() {
                                for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
                                    args[_key] = arguments[_key];
                                }

                                var context = this;
                                var later = function later() {
                                    timeout = null;
                                    if (!immediate) func.apply.apply(func, [context].concat(args));
                                };
                                var callNow = immediate && !timeout;
                                clearTimeout(timeout);
                                timeout = setTimeout(later, wait);
                                if (callNow) func.apply.apply(func, [context].concat(args));
                            };
                        }

                        var classNames = function classNames(obj) {
                            return Object.keys(obj).reduce(function(acc, key) {
                                if (!obj[key]) return acc;
                                return [].concat(acc, [key]);
                            }, []).join(' ');
                        };

                        var assignObject = function assignObject() {
                            for (var _len2 = arguments.length, objects = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
                                objects[_key2] = arguments[_key2];
                            }

                            return objects.reduce(function(acc, obj) {
                                Object.keys(obj).forEach(function(key) {
                                    acc[key] = obj[key];
                                });

                                return acc;
                            }, {});
                        };

                        var objectEntries = function objectEntries(obj) {
                            return Object.keys(obj).reduce(function(acc, key) {
                                var value = obj[key];
                                var pair = [key, value];
                                return [].concat(acc, [pair]);
                            }, []);
                        };

                        var fillArray = function fillArray(arr, value) {
                            var newArr = [];
                            for (var i = 0; i < arr.length; i++) {
                                newArr.push(value);
                            }
                            return newArr;
                        };

                        var getJSON = function getJSON(url, cb) {
                            return new Ajax.Request(url, {
                                evalJSON: 'force',
                                method: 'GET',
                                onComplete: function onComplete(response) {
                                    return cb(response.responseJSON);
                                }
                            });
                        };

                        var beforeRender = function beforeRender() {
                            if (effectsOut) {
                                effectsOut();
                                effectsOut = null;
                            }
                        };

                        var afterRender = function afterRender() {
                            effectsOut = effects();
                        };

                        var setState = function setState(newState) {
                            var changedKeys = Object.keys(newState).filter(function(key) {
                                return state[key] !== newState[key];
                            });

                            if (!changedKeys.length) {
                                return;
                            }

                            changed = changedKeys.reduce(function(acc, key) {
                                var _assignObject;

                                return assignObject({}, acc, (_assignObject = {}, _assignObject[key] = state[key], _assignObject));
                            }, changed);

                            state = assignObject({}, state, newState);
                            if (constructed) {
                                render();
                            }
                        };

                        var isStartWeekOnMonday = function isStartWeekOnMonday() {
                            var _props = props,
                                startDay = _props.startWeekOn.value;

                            return !startDay || startDay === 'Monday';
                        };

                        var monthNames = function monthNames() {
                            return (JotForm.calendarMonthsTranslated || JotForm.calendarMonths || _Utils.specialOptions.Months.value).map(function(monthName) {
                                return String.prototype.locale ? monthName.locale() : monthName;
                            });
                        };
                        var daysOfWeek = function daysOfWeek() {
                            return (JotForm.appointmentCalendarDaysTranslated || JotForm.appointmentCalendarDays || _Utils.specialOptions.Days.value).map(function(dayName) {
                                return String.prototype.locale ? dayName.locale() : dayName;
                            });
                        };
                        // we need remove unnecessary "Sunday", if there is time field on the form
                        var dayNames = function dayNames() {
                            var days = daysOfWeek().length === 8 ? daysOfWeek().slice(1) : daysOfWeek();
                            return isStartWeekOnMonday() ? days : [days[days.length - 1]].concat(days.slice(0, 6));
                        };

                        var oneHour = 1000 * 60 * 60;
                        // const oneDay = oneHour * 24;

                        var intPrefix = function intPrefix(d) {
                            if (d < 10) {
                                return '0' + d;
                            }

                            return '' + d;
                        };

                        var toFormattedDateStr = function toFormattedDateStr(date) {
                            var _props2 = props,
                                _props2$dateFormat$va = _props2.dateFormat.value,
                                format = _props2$dateFormat$va === undefined ? 'yyyy-mm-dd' : _props2$dateFormat$va;

                            if (!date) return;
                            if (typeof date === 'string') {
                                var _date$split = date.split('-'),
                                    _year = _date$split[0],
                                    _month = _date$split[1],
                                    _day = _date$split[2];

                                return format.replace(/yyyy/, _year).replace(/mm/, _month).replace(/dd/, _day);
                            }

                            var year = date.getFullYear();
                            var month = intPrefix(date.getMonth() + 1);
                            var day = intPrefix(date.getUTCDate());
                            return format.replace(/yyyy/, year).replace(/mm/, month).replace(/dd/, day);
                        };

                        var toDateStr = function toDateStr(date) {
                            if (!date) return;
                            var year = date.getFullYear();
                            var month = intPrefix(date.getMonth() + 1);
                            var day = intPrefix(date.getDate());

                            return year + '-' + month + '-' + day;
                        };

                        var toDateTimeStr = function toDateTimeStr(date) {
                            if (!date) return;
                            var ymd = toDateStr(date);
                            var hour = intPrefix(date.getHours());
                            var minute = intPrefix(date.getMinutes());
                            return ymd + ' ' + hour + ':' + minute;
                        };

                        var getTimezoneOffset = function getTimezoneOffset(timezone) {
                            if (!timezone) {
                                return 0;
                            }
                            var cityArgs = timezone.split(' ');
                            var splitted = cityArgs[cityArgs.length - 1].replace(/\(GMT|\)/g, '').split(':');

                            if (!splitted) {
                                return 0;
                            }

                            return parseInt(splitted[0] || 0, 10) + (parseInt(splitted[1] || 0, 10) / 60 || 0);
                        };

                        var getGMTSuffix = function getGMTSuffix(offset) {
                            if (offset === 0) {
                                return '';
                            }

                            var offsetMinutes = Math.abs(offset) % 60;
                            var offsetHours = Math.abs(offset - offsetMinutes) / 60;

                            var str = intPrefix(offsetHours) + ':' + intPrefix(offsetMinutes);

                            if (offset < 0) {
                                return '+' + str;
                            }

                            return '-' + str;
                        };

                        // const toJSDate = (dateStr, timezone) => {
                        //   if (!dateStr) return;

                        //   const gmtSuffix = getGMTSuffix(timezone || state.timezone);

                        //   return new Date(`${dateStr} GMT${gmtSuffix}`);
                        // };

                        var getYearMonth = function getYearMonth(date) {
                            if (!date) return;

                            var _date$split2 = date.split('-'),
                                y = _date$split2[0],
                                m = _date$split2[1];

                            return y + '-' + m;
                        };

                        var getMondayBasedDay = function getMondayBasedDay(date) {
                            var day = date.getUTCDay();
                            if (day === 0) {
                                return 6; // sunday index
                            }
                            return day - 1;
                        };

                        var getDay = function getDay(date) {
                            return isStartWeekOnMonday() ? getMondayBasedDay(date) : date.getUTCDay();
                        };

                        var getUserTimezone = function getUserTimezone() {
                            var _props3 = props,
                                _props3$autoDetectTim = _props3.autoDetectTimezone;
                            _props3$autoDetectTim = _props3$autoDetectTim === undefined ? {} : _props3$autoDetectTim;
                            var autoDetectValue = _props3$autoDetectTim.value,
                                _props3$timezone = _props3.timezone;
                            _props3$timezone = _props3$timezone === undefined ? {} : _props3$timezone;
                            var timezoneAtProps = _props3$timezone.value;

                            if (autoDetectValue === 'No') {
                                return timezoneAtProps;
                            }

                            try {
                                var tzStr = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                if (tzStr) {
                                    var tz = tzStr + ' (GMT' + getGMTSuffix(new Date().getTimezoneOffset()) + ')';
                                    return tz;
                                }
                            } catch (e) {
                                console.error(e.message);
                            }

                            return props.timezone.value;
                        };

                        var passedProps = props;

                        var getStateFromProps = function getStateFromProps() {
                            var newProps = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

                            var startDate = new Date(newProps.startDate ? newProps.startDate.value : '');
                            var today = new Date();
                            var date = toDateStr(new Date(Math.max(startDate, today) || today));

                            return {
                                date: date,
                                timezones: state ? state.timezones : {
                                    loading: true
                                }
                            };
                        };

                        var getFirstAvailableDates = function getFirstAvailableDates(cb) {
                            var _props4 = props,
                                _props4$formID = _props4.formID,
                                formID = _props4$formID === undefined ? global.__formInfo.id : _props4$formID;
                            var _state = state,
                                _state$timezone = _state.timezone,
                                timezone = _state$timezone === undefined ? getUserTimezone() : _state$timezone;


                            if (!formID || !timezone) return;

                            // eslint-disable-next-line max-len
                            var url = PREFIX + '?action=getAppointments&formID=' + formID + '&timezone=' + encodeURIComponent(timezone) + '&ncTz=' + new Date().getTime() + '&firstAvailableDates';

                            return getJSON(url, function(_ref) {
                                var content = _ref.content;
                                return cb(content);
                            });
                        };

                        var state = getStateFromProps(props);

                        var loadTimezones = function loadTimezones(cb) {
                            setState({
                                timezones: {
                                    loading: true
                                }
                            });

                            getJSON((props.cdnconfig.CDN || '/') + 'assets/form/timezones.json?ncTz=' + new Date().getTime(), function(data) {
                                var timezones = objectEntries(data).reduce(function(acc, _ref2) {
                                    var group = _ref2[0],
                                        cities = _ref2[1];

                                    acc.push({
                                        group: group,
                                        cities: cities
                                    });
                                    return acc;
                                }, []);

                                cb(timezones);
                            });
                        };

                        var loadMonthData = function loadMonthData(startDate, endDate, cb) {
                            var _props5 = props,
                                _props5$formID = _props5.formID,
                                formID = _props5$formID === undefined ? (typeof global === 'undefined' ? 'undefined' : _typeof(global)) === 'object' ? global.__formInfo.id : null : _props5$formID,
                                id = _props5.id.value;
                            var _state2 = state,
                                timezone = _state2.timezone;


                            if (!formID || !timezone) return;

                            // eslint-disable-next-line max-len
                            var url = PREFIX + '?action=getAppointments&formID=' + formID + '&qid=' + id + '&timezone=' + encodeURIComponent(timezone) + '&startDate=' + toDateStr(startDate) + '&endDate=' + toDateStr(endDate) + '&ncTz=' + new Date().getTime();

                            return getJSON(url, function(_ref3) {
                                var data = _ref3.content;
                                return cb(data);
                            });
                        };

                        var generateMonthData = function generateMonthData(startDate, endDate, data) {
                            var d1 = startDate.getDate();
                            var d2 = endDate.getDate();
                            var dPrefix = startDate.getFullYear() + '-' + intPrefix(startDate.getMonth() + 1) + '-';

                            var daysLength = d2 - d1 + 1 || 0;
                            var days = fillArray(new Array(daysLength), '');

                            var slots = days.reduce(function(acc, x, day) {
                                var _assignObject2;

                                var dayStr = '' + dPrefix + intPrefix(day + 1);
                                return assignObject(acc, (_assignObject2 = {}, _assignObject2[dayStr] = data[dayStr] || false, _assignObject2));
                            }, {});

                            var availableDays = Object.keys(data).filter(function(d) {
                                return !Array.isArray(slots[d]) && !!slots[d];
                            });

                            return {
                                availableDays: availableDays,
                                slots: slots
                            };
                        };

                        var lastReq = void 0;

                        var updateMonthData = function updateMonthData(startDate, endDate, data) {
                            var _generateMonthData = generateMonthData(startDate, endDate, data),
                                availableDays = _generateMonthData.availableDays,
                                slots = _generateMonthData.slots;

                            if (JSON.stringify(slots) === JSON.stringify(state.slots)) {
                                return;
                            }

                            setState({
                                availableDays: availableDays,
                                slots: slots
                            });
                        };

                        var getDateRange = function getDateRange(dateStr) {
                            var _dateStr$split = dateStr.split('-'),
                                y = _dateStr$split[0],
                                m = _dateStr$split[1];

                            var startDate = new Date(y, m - 1, 1);
                            var endDate = new Date(y, m, 0);
                            return [startDate, endDate];
                        };

                        var load = function load() {
                            var _state3 = state,
                                dateStr = _state3.date;

                            var _getDateRange = getDateRange(dateStr),
                                startDate = _getDateRange[0],
                                endDate = _getDateRange[1];

                            setState(assignObject({
                                loading: true
                            }, generateMonthData(startDate, endDate, {})));

                            var req = loadMonthData(startDate, endDate, function(data) {
                                if (lastReq !== req) {
                                    return;
                                }

                                updateMonthData(startDate, endDate, data);
                                var _state4 = state,
                                    availableDays = _state4.availableDays,
                                    forcedStartDate = _state4.forcedStartDate,
                                    forcedEndDate = _state4.forcedEndDate,
                                    slots = _state4.slots;


                                var firstAvailable = availableDays.find(function(d) {
                                    var foundSlot = Object.keys(slots[d]).find(function(slot) {
                                        var slotDate = dateInTimeZone(new Date((d + ' ' + slot).replace(/-/g, '/')));

                                        if (forcedStartDate && slotDate > forcedStartDate) return false;
                                        if (forcedEndDate && slotDate < forcedEndDate) return false;

                                        return true;
                                    });

                                    return foundSlot;
                                });

                                var newDate = availableDays.indexOf(dateStr) === -1 && firstAvailable;

                                setState({
                                    loading: false,
                                    date: newDate || dateStr
                                });
                            });

                            lastReq = req;
                        };

                        var dateInTimeZone = function dateInTimeZone(date) {
                            var timezone = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : state.timezone;

                            if (!date) return;
                            var diffTime = (getTimezoneOffset(timezone) - state.nyTz) * oneHour;
                            return new Date(date.getTime() - diffTime);
                        };

                        var dz = function dz(date, tz1, tz2) {
                            if (!date) return;
                            var diffTime = (tz1 - tz2) * oneHour;
                            return new Date(date.getTime() - diffTime);
                        };

                        var revertDate = function revertDate(d, t1, t2) {
                            if (!d) return '';

                            var pDate = new Date(d.replace(/-/, '/'));
                            var utz = getTimezoneOffset(getUserTimezone());
                            var tz1 = getTimezoneOffset(t1) - utz;
                            var tz2 = getTimezoneOffset(t2) - utz;

                            var val = dz(pDate, tz1, tz2);

                            return toDateTimeStr(val);
                        };

                        var amPmConverter = function amPmConverter(_time) {
                            var _props6 = props,
                                _props6$timeFormat = _props6.timeFormat;
                            _props6$timeFormat = _props6$timeFormat === undefined ? {} : _props6$timeFormat;
                            var _props6$timeFormat$va = _props6$timeFormat.value,
                                timeFormat = _props6$timeFormat$va === undefined ? '24 Hour' : _props6$timeFormat$va;

                            if (!_time || !(typeof _time === 'string') || _time.indexOf('M') > -1 || !timeFormat || timeFormat === '24 Hour') {
                                return _time;
                            }
                            var time = _time.substring(0, 2);
                            var hour = time % 12 || 12;
                            var ampm = time < 12 ? 'AM' : 'PM';
                            return '' + hour + _time.substring(2, 5) + ' ' + ampm;
                        };

                        var validate = function validate(dateStr, cb) {
                            var _state5 = state,
                                defaultValue = _state5.defaultValue;


                            if (JotForm.isEditMode() && defaultValue === dateStr) {
                                return cb(true);
                            }

                            var parts = dateStr.split(' ');
                            var slot = parts.slice(1).join(' ');

                            var _parts$0$split = parts[0].split('-'),
                                y = _parts$0$split[0],
                                m = _parts$0$split[1],
                                d = _parts$0$split[2];

                            var startDate = new Date(y, m - 1, 1);
                            var endDate = new Date(y, m, 0);

                            loadMonthData(startDate, endDate, function(data) {
                                var day = y + '-' + m + '-' + d;
                                var isValid = JotForm.checkAppointmentAvailability(day, amPmConverter(slot), data);
                                cb(isValid);
                                if (!isValid) {
                                    var _assignObject3;

                                    // add unavailable slot if it is not in response for deselection
                                    data[day] = assignObject({}, data[day], (_assignObject3 = {}, _assignObject3[slot] = false, _assignObject3));
                                }

                                // still in same month
                                if (state.date.indexOf(y + '-' + m) === 0) {
                                    updateMonthData(startDate, endDate, data);
                                }
                            });
                        };

                        // let validationInterval;

                        var validation = function validation(_value) {
                            var shouldValidate = _value || $(input).hasClassName('validate');

                            if (!shouldValidate) {
                                $(input).addClassName('valid');
                                JotForm.corrected(input);
                                JotForm.runConditionForId(props.id.value);
                                return;
                            }

                            if (!_value) {
                                $(input).removeClassName('valid');
                                JotForm.errored(input, JotForm.texts.required);
                                JotForm.runConditionForId(props.id.value);
                                return;
                            }

                            validate(_value, function(isValid) {
                                if (isValid) {
                                    $(input).addClassName('valid');
                                    JotForm.corrected(input);
                                    JotForm.runConditionForId(props.id.value);
                                    return;
                                }

                                // clearInterval(validationInterval);

                                var parts = _value.split(' ');
                                var dateStr = parts[0];

                                var date = new Date(dateStr);
                                var day = getDay(date);
                                var datetime = dayNames()[day] + ', ' + monthNames()[date.getMonth()] + ' ' + intPrefix(date.getUTCDate()) + ', ' + date.getFullYear();

                                var time = parts.slice(1).join(' ');
                                var errorText = JotForm.texts.slotUnavailable.replace('{time}', time).replace('{date}', datetime);

                                $(input).removeClassName('valid');
                                JotForm.errored(input, errorText);
                                JotForm.runConditionForId(props.id.value);
                            });
                        };

                        var setValue = function setValue(value) {
                            input.value = value ? toDateTimeStr(dateInTimeZone(new Date(value.replace(/-/g, '/')))) : '';

                            setState({
                                value: value
                            });

                            //!!!!Envia hora para Conecta!!!!
                            // console.log(value);

                            var newValue = value.split(" ");
                            var newData = newValue[0];
                            newData = newData.split("-");
                            var Data = newData[2] + "/" + newData[1] + "/" + newData[0];
                            var newHora = newValue[1];

                            newValue = Data + " " + newHora;
                            document.getElementById("data").value = newValue;


                            // trigger input event for supporting progress bar widget
                            input.triggerEvent('input');

                            // clearInterval(validationInterval);

                            validation(value);
                            // validationInterval = setInterval(() => { validation(state.value); }, 1000 * 5);
                        };

                        var handleClick = function handleClick(e) {
                            var target = e.target;

                            var $target = $(target);

                            if (!$target || !$target.hasClassName) {
                                return;
                            }

                            if ($target.hasClassName('disabled') && !$target.hasClassName('active')) {
                                return;
                            }

                            e.preventDefault();
                            var value = target.dataset.value;

                            setValue($target.hasClassName('active') ? undefined : value);
                        };

                        var setTimezone = function setTimezone(timezone) {
                            tzInput.value = timezone;
                            setState({
                                timezone: timezone
                            });
                            if (input.value) {
                                var date = toDateTimeStr(dz(new Date(input.value.replace(/-/g, '/')), state.nyTz, getTimezoneOffset(state.timezone)));
                                setDate(date.split(' ')[0]);
                                setState({
                                    value: date
                                });
                            }
                        };

                        var handleTimezoneChange = function handleTimezoneChange(e) {
                            var target = e.target;
                            var timezone = target.value;

                            setTimezone(timezone);
                        };

                        var setDate = function setDate(date) {
                            return setState({
                                date: date
                            });
                        };

                        var handleDateChange = function handleDateChange(e) {
                            var target = e.target;
                            var date = target.dataset.value;


                            if (!date) return;

                            setDate(date);
                        };

                        var handleMonthYearChange = function handleMonthYearChange(e) {
                            var _e$target = e.target,
                                dataset = _e$target.dataset,
                                inputVal = _e$target.value;
                            var name = dataset.name;

                            if (!name) {
                                return;
                            }

                            var _state6 = state,
                                date = _state6.date;

                            var oldDate = new Date(date);
                            var oldMonth = oldDate.getMonth();
                            var oldYear = oldDate.getFullYear();
                            var oldDay = oldDate.getUTCDate();

                            var value = inputVal || e.target.getAttribute('value');

                            if (name === 'month') {
                                var newDate = new Date(oldYear, value, oldDay);
                                var i = 1;
                                while ('' + newDate.getMonth() !== '' + value && i < 10) {
                                    newDate = new Date(oldYear, value, oldDay - i);
                                    i++;
                                }

                                return setDate(toDateStr(newDate));
                            }

                            return setDate(toDateStr(new Date(value, oldMonth, oldDay)));
                        };

                        var toggleMobileState = function toggleMobileState() {
                            var $wrapper = $(wrapper);
                            if ($wrapper.hasClassName('isOpenMobile')) {
                                $wrapper.removeClassName('isOpenMobile');
                            } else {
                                $wrapper.addClassName('isOpenMobile');
                            }
                        };

                        var keepSlotsScrollPosition = function keepSlotsScrollPosition() {
                            var visibleSlot = element.querySelector('.appointmentSlots.slots .slot.active, .appointmentSlots.slots .slot:not(.disabled)');

                            element.querySelector('.appointmentSlots.slots').scrollTop = visibleSlot ? visibleSlot.offsetTop : 0;
                        };

                        var setTimezonePickerState = function setTimezonePickerState() {
                            var _state7 = state,
                                timezone = _state7.timezone;
                            var _props7 = props,
                                _props7$autoDetectTim = _props7.autoDetectTimezone;
                            _props7$autoDetectTim = _props7$autoDetectTim === undefined ? {} : _props7$autoDetectTim;
                            var autoDetecTimezoneValue = _props7$autoDetectTim.value,
                                _props7$timezone = _props7.timezone;
                            _props7$timezone = _props7$timezone === undefined ? {} : _props7$timezone;
                            var timezoneValueProps = _props7$timezone.value;

                            if (autoDetecTimezoneValue === 'No') {
                                timezonePickerCommon.setSelectedTimezone(timezoneValueProps);
                            } else {
                                timezonePickerCommon.setSelectedTimezone(timezone);
                            }
                            timezonePickerCommon.setIsAutoSelectTimezoneOpen(autoDetecTimezoneValue);
                        };

                        var handleUIUpdate = function handleUIUpdate() {
                            try {
                                var breakpoints = {
                                    450: 'isLarge',
                                    225: 'isNormal',
                                    175: 'shouldBreakIntoNewLine'
                                };

                                var offsetWidth = function() {
                                    try {
                                        var appointmentCalendarRow = element.querySelector('.appointmentFieldRow.forCalendar');
                                        var appointmendCalendar = element.querySelector('.appointmentCalendar');
                                        return appointmentCalendarRow.getBoundingClientRect().width - appointmendCalendar.getBoundingClientRect().width;
                                    } catch (e) {
                                        return null;
                                    }
                                }();

                                if (offsetWidth === null || parseInt(wrapper.readAttribute('data-breakpoint-offset'), 10) === offsetWidth) {
                                    return;
                                }

                                var breakpoint = Object.keys(breakpoints).reduce(function(prev, curr) {
                                    return Math.abs(curr - offsetWidth) < Math.abs(prev - offsetWidth) ? curr : prev;
                                });
                                var breakpointName = breakpoints[breakpoint];

                                wrapper.setAttribute('data-breakpoint', breakpointName);
                                wrapper.setAttribute('data-breakpoint-offset', offsetWidth);
                            } catch (e) {
                                // noop.
                            }
                        };

                        var uiUpdateInterval = void 0;

                        var effects = function effects() {
                            clearInterval(uiUpdateInterval);

                            var shouldLoad = changed.timezone && changed.timezone !== state.timezone || // time zone changed
                                changed.date && getYearMonth(changed.date) !== getYearMonth(state.date); // y-m changed

                            changed = {};

                            if (shouldLoad) {
                                load();
                            }

                            var cancelBtn = element.querySelector('.cancel');

                            if (cancelBtn) {
                                cancelBtn.addEventListener('click', function() {
                                    setValue(undefined);
                                });
                            }

                            var forSelectedDate = element.querySelector('.forSelectedDate span');

                            if (forSelectedDate) {
                                forSelectedDate.addEventListener('click', function() {
                                    setDate(state.value.split(' ')[0]);
                                });
                            }

                            if (isTimezonePickerFromCommonLoaded) {
                                setTimezonePickerState();
                                var timezonePickerWrapper = element.querySelector('.forTimezonePicker');
                                timezonePickerCommon.init(timezonePickerWrapper);
                            } else {
                                element.querySelector('.timezonePicker').addEventListener('change', handleTimezoneChange);
                            }

                            element.querySelector('.calendar .days').addEventListener('click', handleDateChange);
                            element.querySelector('.monthYearPicker').addEventListener('change', handleMonthYearChange);
                            element.querySelector('.dayPicker').addEventListener('click', handleDateChange);
                            element.querySelector('.selectedDate').addEventListener('click', toggleMobileState);

                            Array.prototype.slice.call(element.querySelectorAll('.monthYearPicker .pickerArrow')).forEach(function(el) {
                                return el.addEventListener('click', handleMonthYearChange);
                            });
                            Array.prototype.slice.call(element.querySelectorAll('.slot')).forEach(function(el) {
                                return el.addEventListener('click', handleClick);
                            });

                            keepSlotsScrollPosition();
                            uiUpdateInterval = setInterval(handleUIUpdate, 250);

                            JotForm.runAllCalculations();
                        };

                        var onTimezoneOptionClick = function onTimezoneOptionClick(timezoneValue) {
                            setTimezone(timezoneValue);
                        };

                        var renderMonthYearPicker = function renderMonthYearPicker() {
                            var _state8 = state,
                                date = _state8.date;

                            var _split = (date || '-').split('-'),
                                year = _split[0],
                                month = _split[1];

                            var yearOpts = fillArray(new Array(20), '').map(function(v, i) {
                                return '' + (currentYear + i);
                            });

                            var prevMonthButtonText = props.prevMonthButtonText && props.prevMonthButtonText.text || 'Previous month';
                            var nextMonthButtonText = props.nextMonthButtonText && props.nextMonthButtonText.text || 'Next month';
                            var prevYearButtonText = props.prevYearButtonText && props.prevYearButtonText.text || 'Previous year';
                            var nextYearButtonText = props.nextYearButtonText && props.nextYearButtonText.text || 'Next year';

                            return '\n      <div class=\'monthYearPicker\'>\n        <div class=\'pickerItem\'>\n          <select class=\'pickerMonth\' data-name=\'month\'>\n            ' + monthNames().map(function(monthName, i) {
                                return '<option ' + (parseInt(month, 10) === i + 1 ? 'selected' : '') + ' value=\'' + i + '\'>' + monthName + '</option>';
                            }).join('') + '\n          </select>\n          <button type=\'button\' class=\'pickerArrow pickerMonthArrow prev\' \n          ' + (Number(month) === 1 && Number(year) === currentYear && 'disabled') + '\n          value=\'' + (parseInt(month, 10) - 2) + '\' \n          data-name=\'month\' \n          aria-label="' + prevMonthButtonText + '"\n          >\n          </button>\n          <button \n          type=\'button\'\n          class=\'pickerArrow pickerMonthArrow next\'\n          ' + (Number(month) === 12 && Number(year) === currentYear + 19 ? 'disabled' : '') + '\n          value=\'' + parseInt(month, 10) + '\'\n          data-name=\'month\'\n          aria-label="' + nextMonthButtonText + '"\n          >\n          </button>\n        </div>\n        <div class=\'pickerItem\'>\n          <select class=\'pickerYear\' data-name=\'year\'>\n            ' + yearOpts.map(function(yearName) {
                                return '<option ' + (year === yearName ? 'selected' : '') + '>' + yearName + '</option>';
                            }).join('') + '\n          </select>\n          <button\n          type=\'button\'\n          class=\'pickerArrow pickerYearArrow prev\'\n          ' + (Number(year) === currentYear && 'disabled') + '\n          value=\'' + (parseInt(year, 10) - 1) + '\'\n          data-name=\'year\'\n          aria-label="' + prevYearButtonText + '"\n          />\n          <button\n          type=\'button\'\n          class=\'pickerArrow pickerYearArrow next\'\n          ' + (Number(year) === currentYear + 19 && 'disabled') + '\n          value=\'' + (parseInt(year, 10) + 1) + '\'\n          data-name=\'year\'\n          aria-label="' + nextYearButtonText + '"\n          />\n        </div>\n      </div>\n    ';
                        };

                        var getNav = function getNav() {
                            var _state9 = state,
                                availableDays = _state9.availableDays,
                                dateStr = _state9.date;


                            var next = void 0;
                            var prev = void 0;

                            var _dateStr$split2 = dateStr.split('-'),
                                year = _dateStr$split2[0],
                                month = _dateStr$split2[1];

                            if (availableDays) {
                                var dayIndex = availableDays.indexOf(dateStr);
                                if (dayIndex > 0) {
                                    prev = availableDays[dayIndex - 1];
                                } else {
                                    var prevDate = new Date(year, month - 1, 0);
                                    if (prevDate.getFullYear() >= currentYear) {
                                        prev = toDateStr(prevDate);
                                    }
                                }

                                if (dayIndex + 1 < availableDays.length) {
                                    next = availableDays[dayIndex + 1];
                                } else {
                                    var nextDate = new Date(year, month, 1);
                                    if (nextDate.getFullYear() <= currentYear + 19) {
                                        next = toDateStr(nextDate);
                                    }
                                }
                            }
                            return {
                                prev: prev,
                                next: next
                            };
                        };

                        var renderDayPicker = function renderDayPicker() {
                            var _state10 = state,
                                loading = _state10.loading;

                            var _getNav = getNav(),
                                prev = _getNav.prev,
                                next = _getNav.next;

                            var prevDayButtonText = props.prevDayButtonText && props.prevDayButtonText.text || 'Previous day';
                            var nextDayButtonText = props.nextDayButtonText && props.nextDayButtonText.text || 'Next day';

                            return '\n      <div class=\'appointmentDayPicker dayPicker\'>\n        <button type=\'button\' ' + (loading || !prev ? 'disabled' : '') + ' class="appointmentDayPickerButton prev" ' + (prev && 'data-value="' + prev + '"') + ' aria-label="' + prevDayButtonText + '">&lt;</button>\n        <button type=\'button\' ' + (loading || !next ? 'disabled' : '') + ' class="appointmentDayPickerButton next" ' + (next && 'data-value="' + next + '"') + ' aria-label="' + nextDayButtonText + '">&gt;</button>\n      </div>\n    ';
                        };

                        var renderTimezonePicker = function renderTimezonePicker() {
                            var _state11 = state,
                                timezone = _state11.timezone,
                                timezones = _state11.timezones;


                            return '\n      <div class=\'timezonePickerWrapper\'> \n        <select class=\'timezonePicker\'>\n          ' + (!timezones.loading && timezones.map(function(_ref4) {
                                var group = _ref4.group,
                                    cities = _ref4.cities;
                                return '\n                <optgroup label="' + group + '">\n                  ' + cities.map(function(val) {
                                    return '<option ' + (timezone.indexOf((group + '/' + val).split(' ')[0]) > -1 ? 'selected' : '') + ' value=\'' + group + '/' + val + '\'>' + val + '</option>';
                                }).join('') + '\n                </optgroup>\n              ';
                            }).join('')) + '\n        </select>\n        <div class=\'timezonePickerName\'>' + timezone + '</div>\n      </div>\n    ';
                        };

                        var renderCalendarDays = function renderCalendarDays() {
                            var _state12 = state,
                                slots = _state12.slots,
                                dateStr = _state12.date,
                                value = _state12.value,
                                availableDays = _state12.availableDays;

                            var days = slots ? Object.keys(slots) : [];
                            var todayStr = toDateStr(new Date());

                            if (!days.length) {
                                return '';
                            }

                            var firstDay = getDay(new Date(days[0]));
                            days.unshift.apply(days, fillArray(new Array(firstDay), 'precedingDay'));

                            var trailingDays = Math.ceil(days.length / 7) * 7 - days.length;
                            days.push.apply(days, fillArray(new Array(trailingDays), 'trailingDay'));

                            var weeks = days.map(function(item, i) {
                                return i % 7 === 0 ? days.slice(i, i + 7) : null;
                            }).filter(function(a) {
                                return a;
                            });

                            var dateValue = value && value.split(' ')[0];

                            return '\n      ' + weeks.map(function(week) {
                                return '<div class=\'calendarWeek\'>' + week.map(function(day) {
                                    var dayObj = new Date(day);
                                    if (day === 'precedingDay' || day === 'trailingDay') {
                                        return '<div class="calendarDay ' + day + ' empty"></div>';
                                    }
                                    var active = day === dateStr;
                                    var isToday = todayStr === day;
                                    var beforeStartDate = state.forcedStartDate ? state.forcedStartDate > dayObj : false;
                                    var afterEndDate = state.forcedEndDate ? state.forcedEndDate < dayObj : false;
                                    var isUnavailable = availableDays.indexOf(day) === -1 || beforeStartDate || afterEndDate;
                                    var isSelected = day === dateValue;
                                    var classes = 'calendarDay ' + classNames({
                                        isSelected: isSelected,
                                        isToday: isToday,
                                        isUnavailable: isUnavailable,
                                        isActive: active
                                    });
                                    return '<div \n                      class=\'' + classes + '\' \n                      data-value=\'' + day + '\'\n                      role="button"\n                      aria-disabled="' + (isUnavailable ? true : false) + '"  \n                    >\n                        <span class=\'calendarDayEach\'>' + day.split('-')[2].replace(/^0/, '') + '</span>\n                    </div>';
                                }).join('') + '</div>';
                            }).join('') + '\n    ';
                        };

                        var renderEmptyState = function renderEmptyState() {
                            /* eslint-disable */
                            return '\n      <div class="appointmentSlots-empty">\n        <div class="appointmentSlots-empty-container">\n          <div class="appointmentSlots-empty-icon">\n            <svg width="124" height="102" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\n              <defs>\n                <path d="M55 32.001c0 21.54 17.46 39 39 39 3.457 0 6.81-.45 10-1.294v34.794H0v-104l71 .001c-9.7 7.095-16 18.561-16 31.5z" id="a"/>\n              </defs>\n              <g fill="none" fill-rule="evenodd">\n                <g transform="translate(-1 -1)">\n                  <mask id="b" fill="#fff">\n                    <use xlink:href="#a"/>\n                  </mask>\n                  <g mask="url(#b)">\n                    <path d="M18.85 52.001c9.858 0 17.85 7.992 17.85 17.85 0 9.859-7.992 17.85-17.85 17.85S1 79.71 1 69.851c0-9.858 7.992-17.85 17.85-17.85zm5.666 10.842L17.38 69.98l-2.44-2.44a2.192 2.192 0 00-3.1 3.1l3.99 3.987a2.192 2.192 0 003.098 0l8.687-8.686a2.191 2.191 0 00-3.1-3.099z" fill="#D5D6DA"/>\n                    <path d="M92.043 10.643H81.597V7.576A6.582 6.582 0 0075.023 1a6.582 6.582 0 00-6.574 6.575v3.067H41.833V7.576A6.582 6.582 0 0035.26 1a6.582 6.582 0 00-6.574 6.575v3.149a2.187 2.187 0 00-.585-.082H19.37c-6.042 0-10.957 4.916-10.957 10.958v27.126a2.192 2.192 0 004.383 0V33.215h86.211a2.192 2.192 0 000-4.383H12.795v-7.231a6.582 6.582 0 016.574-6.575H28.1c.203 0 .398-.03.585-.08v2.82a6.582 6.582 0 006.574 6.574c3.625 0 10.574-2.95 10.574-6.574v-2.74H68.45v2.74a6.582 6.582 0 006.574 6.574c3.625 0 7.574-2.95 7.574-6.574v-2.74h9.446a6.582 6.582 0 016.574 6.575v73.072a3.95 3.95 0 01-3.946 3.945h-77.95a3.95 3.95 0 01-3.944-3.944v-5.67c0-1.047-.981-2.192-2.192-2.192-1.21 0-2.191.981-2.191 2.192v5.67c0 4.592 3.736 8.327 8.327 8.327h77.95c4.592 0 8.328-3.736 8.328-8.328V21.601c0-6.042-4.915-10.958-10.957-10.958zM37.45 17.766a2.194 2.194 0 01-2.191 2.191 2.194 2.194 0 01-2.191-2.191V7.576c0-1.209.983-2.192 2.19-2.192 1.21 0 2.192.983 2.192 2.192v10.19zm39.764 0a2.194 2.194 0 01-2.191 2.191 2.194 2.194 0 01-2.191-2.191V7.576c0-1.209.983-2.192 2.191-2.192 1.208 0 2.191.983 2.191 2.192v10.19z" fill="#D5D6DA" fill-rule="nonzero"/>\n                    <path d="M55.68 63.556c-4.592 0-8.328 3.736-8.328 8.327 0 4.592 3.736 8.328 8.327 8.328 4.592 0 8.328-3.736 8.328-8.328 0-4.591-3.736-8.327-8.328-8.327zm0 12.272a3.95 3.95 0 01-3.945-3.945 3.95 3.95 0 013.944-3.944 3.95 3.95 0 013.945 3.944 3.95 3.95 0 01-3.945 3.945zm26.854-12.272c-4.591 0-8.327 3.736-8.327 8.327 0 4.592 3.736 8.328 8.327 8.328 4.592 0 8.328-3.736 8.328-8.328 0-4.591-3.736-8.327-8.328-8.327zm0 12.272a3.95 3.95 0 01-3.944-3.945 3.95 3.95 0 013.944-3.944 3.95 3.95 0 013.945 3.944 3.95 3.95 0 01-3.945 3.945zM30.126 36.701c-4.591 0-8.327 3.736-8.327 8.328 0 4.591 3.736 8.327 8.327 8.327 4.592 0 8.328-3.736 8.328-8.327 0-4.592-3.736-8.328-8.328-8.328zm0 12.272a3.95 3.95 0 01-3.944-3.944 3.95 3.95 0 013.944-3.945 3.95 3.95 0 013.945 3.945 3.95 3.95 0 01-3.945 3.944z" fill="#D5D6DA" fill-rule="nonzero"/>\n                    <path d="M83.836 36.701c-4.592 0-8.328 3.736-8.328 8.328 0 4.591 3.736 8.327 8.328 8.327 4.591 0 8.327-3.736 8.327-8.327 0-4.592-3.736-8.328-8.327-8.328zm0 12.272a3.95 3.95 0 01-3.945-3.944 3.95 3.95 0 013.945-3.945 3.95 3.95 0 013.944 3.945 3.95 3.95 0 01-3.944 3.944z" fill="#2B3245" fill-rule="nonzero"/>\n                    <path d="M56.981 36.701c-4.592 0-8.327 3.736-8.327 8.328 0 4.591 3.735 8.327 8.327 8.327 4.592 0 8.327-3.736 8.327-8.327 0-4.592-3.735-8.328-8.327-8.328zm0 12.272a3.95 3.95 0 01-3.944-3.944 3.95 3.95 0 013.944-3.945 3.95 3.95 0 013.945 3.945 3.95 3.95 0 01-3.945 3.944z" fill="#D5D6DA" fill-rule="nonzero"/>\n                    <path d="M68.829 11.201l.001 6.375a6.375 6.375 0 006.146 6.371l.229.004a6.375 6.375 0 006.371-6.146l.004-.229-.001-6.375h6.871c6.627 0 12 5.373 12 12v8.4H11.2v-8.4c0-6.627 5.373-12 12-12h5.849l.001 6.75a6 6 0 005.775 5.996l.225.004h.375a6.375 6.375 0 006.375-6.375l-.001-6.375h27.03z" fill="#D5D6DA"/>\n                  </g>\n                </g>\n                <path d="M92 0c17.673 0 32 14.327 32 32 0 17.673-14.327 32-32 32-17.673 0-32-14.327-32-32C60 14.327 74.327 0 92 0zm21.268 15.365L75.365 53.268A26.884 26.884 0 0092 59c14.912 0 27-12.088 27-27a26.88 26.88 0 00-5.732-16.635zM92 5C77.088 5 65 17.088 65 32c0 6.475 2.28 12.417 6.079 17.069l37.99-37.99A26.888 26.888 0 0092 5z" fill="#D5D6DA"/>\n              </g>\n            </svg>\n          </div>\n          <div class="appointmentSlots-empty-text">' + JotForm.texts.noSlotsAvailable + '</div>\n        </div>\n      </div>\n    ';
                            /* eslint-enable */
                        };

                        var dateWithAMPM = function dateWithAMPM() {
                            var date = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
                            var _props8 = props,
                                _props8$timeFormat = _props8.timeFormat;
                            _props8$timeFormat = _props8$timeFormat === undefined ? {} : _props8$timeFormat;
                            var _props8$timeFormat$va = _props8$timeFormat.value,
                                timeFormat = _props8$timeFormat$va === undefined ? '24 Hour' : _props8$timeFormat$va;

                            var time = new Date(date.replace(/-/g, '/')).toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: 'numeric',
                                hourCycle: timeFormat === 'AM/PM' ? 'h12' : 'h23'
                            });
                            var day = date && date.split(' ')[0];
                            return day + ' ' + time;
                        };

                        var renderSlots = function renderSlots() {
                            var _state13 = state,
                                dateStr = _state13.date,
                                _state13$value = _state13.value,
                                dateValue = _state13$value === undefined ? '' : _state13$value,
                                _state13$defaultValue = _state13.defaultValue,
                                defaultValue = _state13$defaultValue === undefined ? '' : _state13$defaultValue,
                                timezone = _state13.timezone,
                                forcedStartDate = _state13.forcedStartDate,
                                forcedEndDate = _state13.forcedEndDate;

                            var dateSlots = state.slots && state.slots[dateStr] || {};

                            var stateValue = dateWithAMPM(dateValue);
                            var stateDefaultValue = dateWithAMPM(defaultValue);
                            var defaultValueTZ = revertDate(defaultValue, ' ', timezone);

                            var parsedDefaultVal = dateWithAMPM(defaultValueTZ);

                            var entries = objectEntries(dateSlots);

                            if (!entries || !entries.length) {
                                return renderEmptyState();
                            }

                            return entries.map(function(_ref5) {
                                var name = _ref5[0],
                                    value = _ref5[1];

                                var rn = amPmConverter(name);
                                var slotValue = dateStr + ' ' + rn;
                                var realD = dateInTimeZone(new Date(slotValue.replace(/-/g, '/')));
                                var active = stateValue === slotValue;

                                var disabled = (forcedStartDate && forcedStartDate > realD || forcedEndDate && forcedEndDate < realD || !(value || parsedDefaultVal === slotValue)) && stateDefaultValue !== slotValue;

                                return '<div class="appointmentSlot slot ' + classNames({
                                    disabled: disabled,
                                    active: active
                                }) + '" data-value="' + slotValue + '" role="button">' + name + '</div>';
                            }).join('');
                        };

                        var renderDay = function renderDay() {
                            var _state14 = state,
                                dateStr = _state14.date;

                            var date = new Date(dateStr);
                            var day = getDay(date);

                            return '\n      <div class=\'appointmentDate\'>\n        ' + (dateStr && dayNames()[day] + ', ' + monthNames()[date.getUTCMonth()] + ' ' + intPrefix(date.getUTCDate())) + '\n      </div>\n    ';
                        };

                        var renderCalendar = function renderCalendar() {
                            var _state15 = state,
                                dateStr = _state15.date;


                            return '\n      <div class=\'selectedDate\'>\n        <input class=\'currentDate\' type=\'text\' value=\'' + toFormattedDateStr(dateStr) + '\' style=\'pointer-events: none;\' />\n      </div>\n      ' + renderMonthYearPicker() + '\n      <div class=\'appointmentCalendarDays days\'>\n        <div class=\'daysOfWeek\'>\n          ' + dayNames().map(function(day) {
                                return '<div class="dayOfWeek ' + day.toLowerCase() + '">' + day.toUpperCase().slice(0, 3) + '</div>';
                            }).join('') + '\n        </div>\n        ' + renderCalendarDays() + '\n      </div>\n    ';
                        };

                        var renderSelectedDate = function renderSelectedDate() {
                            var _state16 = state,
                                _state16$value = _state16.value,
                                value = _state16$value === undefined ? '' : _state16$value;

                            var dateStr = value && value.split(' ')[0];
                            var _props9 = props,
                                _props9$timeFormat = _props9.timeFormat;
                            _props9$timeFormat = _props9$timeFormat === undefined ? {} : _props9$timeFormat;
                            var _props9$timeFormat$va = _props9$timeFormat.value,
                                timeFormat = _props9$timeFormat$va === undefined ? '24 Hour' : _props9$timeFormat$va;


                            var date = new Date(dateStr);
                            var time = new Date(value.replace(/-/g, '/')).toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: 'numeric',
                                hourCycle: timeFormat === 'AM/PM' ? 'h12' : 'h23'
                            });
                            var day = getDay(date);
                            var datetime = dayNames()[day] + ', ' + monthNames()[date.getUTCMonth()] + ' ' + intPrefix(date.getUTCDate()) + ', ' + date.getFullYear();

                            var text = JotForm.texts.appointmentSelected.replace('{time}', time).replace('{date}', datetime);
                            var valEl = '<div style=\'display: none\' class=\'jsAppointmentValue\'>' + datetime + ' ' + time + '</div>';
                            return value ? valEl + '<div class=\'appointmentFieldRow forSelectedDate\'><span aria-live="polite">' + text + '</span><button type=\'button\' class=\'cancel\'>x</button></div>' : '';
                        };

                        var render = debounce(function() {
                            var _state17 = state,
                                loading = _state17.loading;


                            beforeRender();
                            element.innerHTML = '\n      <div class=\'appointmentFieldContainer\'>\n        <div class=\'appointmentFieldRow forCalendar\'>\n          <div class=\'calendar appointmentCalendar\'>\n            <div class=\'appointmentCalendarContainer\'>\n              ' + renderCalendar() + '\n            </div>\n          </div>\n          <div class=\'appointmentDates\'>\n            <div class=\'appointmentDateSelect\'>\n              ' + renderDay() + '\n              ' + renderDayPicker() + '\n            </div>\n            <div class=\'appointmentSlots slots ' + classNames({
                                isLoading: loading
                            }) + '\'>\n              <div class=\'appointmentSlotsContainer\'>\n                ' + renderSlots() + '\n              </div>\n            </div>\n            <div class=\'appointmentCalendarTimezone forTimezonePicker\'>\n              ' + (isTimezonePickerFromCommonLoaded ? '' : renderTimezonePicker()) + '\n            </div>\n          </div>\n        </div>\n        ' + renderSelectedDate() + '\n      </div>\n    ';
                            afterRender();
                        });

                        var _update = function _update(newProps) {
                            state = assignObject({}, state, getStateFromProps(newProps));
                            props = newProps;
                            load();
                        };

                        input.addEventListener('change', function(e) {
                            if (!state.nyTz) return;
                            var date = e.target.value ? toDateTimeStr(dz(new Date(e.target.value.replace(/-/g, '/')), state.nyTz, getTimezoneOffset(state.timezone))) : '';
                            var isAMPM = props.timeFormat === '24 hour';
                            if (date) {
                                setDate(date.split(' ')[0]);
                                setState({
                                    value: date,
                                    defaultValue: isAMPM ? date : dateWithAMPM(date)
                                });
                                validation(isAMPM ? date : dateWithAMPM(date));
                            }
                        });
                        tzInput.addEventListener('change', function(e) {
                            var defaultTimezone = e.target.value;
                            setTimezone(defaultTimezone);
                            setState({
                                defaultTimezone: defaultTimezone
                            });
                        });
                        document.addEventListener('translationLoad', function() {
                            return render();
                        });

                        var getInitialData = function getInitialData(timezones) {
                            getFirstAvailableDates(function(data) {
                                var nyTz = -4;
                                try {
                                    nyTz = getTimezoneOffset(timezones.find(function(_ref6) {
                                        var group = _ref6.group;
                                        return group === 'America';
                                    }).cities.find(function(c) {
                                        return c.indexOf('New_York') > -1;
                                    }));
                                } catch (e) {
                                    console.log(e);
                                }
                                JotForm.appointments.initialData = data;
                                JotForm.nyTz = nyTz;
                                JotForm.appointments.listeners.forEach(function(fn) {
                                    return fn({
                                        data: data,
                                        timezones: timezones,
                                        nyTz: nyTz
                                    });
                                });
                            });
                        };

                        if (!JotForm.appointments) {
                            JotForm.appointments = {
                                listeners: []
                            };

                            loadTimezones(function(timezones) {
                                JotForm.timezones = timezones;
                                getInitialData(timezones);
                            });
                        }

                        var requestTry = 1;
                        var requestTimeout = 1000;

                        var construct = function construct(_ref7) {
                            var data = _ref7.data,
                                timezones = _ref7.timezones,
                                nyTz = _ref7.nyTz;

                            var qdata = data[props.id.value];
                            var _props10 = props,
                                _props10$autoDetectTi = _props10.autoDetectTimezone;
                            _props10$autoDetectTi = _props10$autoDetectTi === undefined ? {} : _props10$autoDetectTi;
                            var autoDetectValue = _props10$autoDetectTi.value;


                            if (autoDetectValue === 'No') {
                                load();
                            }

                            if (!qdata || qdata.error) {
                                constructed = true;

                                if (!qdata && requestTry < 4) {
                                    requestTry += 1;
                                    setTimeout(function() {
                                        getInitialData(JotForm.timezones);
                                    }, requestTry * requestTimeout);
                                }

                                return;
                            }

                            constructed = false;

                            var userTimezone = getUserTimezone();

                            var setUpdatedTimezone = function setUpdatedTimezone(currentTimezone) {
                                if (!currentTimezone) {
                                    return currentTimezone;
                                }

                                var _currentTimezone$spli = currentTimezone.split('/'),
                                    currentCont = _currentTimezone$spli[0],
                                    currCity = _currentTimezone$spli[1];

                                var currentCity = currCity && currCity.split(' (')[0];
                                var group = timezones.find(function(timezone) {
                                    return timezone.group === currentCont;
                                });
                                if (!group) {
                                    return currentTimezone;
                                }
                                var matchedTimezone = group.cities.find(function(c) {
                                    return c.indexOf(currentCity) > -1;
                                });

                                if (!matchedTimezone) return false;

                                return group.group + '/' + matchedTimezone;
                            };

                            var timezone = setUpdatedTimezone(userTimezone) || setUpdatedTimezone(props.timezone.value) || props.timezone.value;

                            if (window.timezonePickerCommon) {
                                isTimezonePickerFromCommonLoaded = true;
                                timezonePickerCommon = window.timezonePickerCommon({
                                    id: uniqueId,
                                    timezones: timezones,
                                    selectedTimezone: timezone,
                                    onOptionClick: onTimezoneOptionClick,
                                    usePortal: true
                                });
                            }

                            setTimezone(timezone);
                            var dateStr = Object.keys(qdata)[0];

                            var _getDateRange2 = getDateRange(dateStr),
                                startDate = _getDateRange2[0],
                                endDate = _getDateRange2[1];

                            updateMonthData(startDate, endDate, qdata);
                            var _state18 = state,
                                availableDays = _state18.availableDays;

                            var newDate = availableDays.indexOf(dateStr) === -1 ? availableDays[0] : dateStr;

                            constructed = true;

                            setState({
                                timezones: timezones,
                                loading: false,
                                date: newDate || dateStr,
                                nyTz: nyTz
                            });

                            setTimeout(function() {
                                if (input.value) {
                                    input.triggerEvent('change');
                                }
                            }, 100);
                        };

                        JotForm.appointments.listeners.push(construct);

                        if (JotForm.appointments.initialData) {
                            setTimeout(function() {
                                construct({
                                    data: JotForm.appointments.initialData,
                                    timezones: JotForm.timezones,
                                    nyTz: JotForm.nyTz
                                });
                            }, requestTimeout);
                        }

                        JotForm.appointments[props.id.value] = {
                            update: function update(newProps) {
                                return _update(assignObject(passedProps, newProps));
                            },
                            forceStartDate: function forceStartDate(newDate) {
                                var equation = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

                                if (!newDate) {
                                    setState({
                                        forcedStartDate: undefined
                                    });
                                    return;
                                }

                                try {
                                    var forcedStartDate = new Date(newDate);
                                    if ('' + forcedStartDate === '' + state.forcedStartDate) return;
                                    var date = new Date(state.availableDays.find(function(d) {
                                        return new Date(d + ' 23:59:59') >= forcedStartDate;
                                    }));

                                    if (!date.getTime()) {
                                        date = forcedStartDate;
                                    }

                                    date = toDateStr(date);

                                    if (equation && !state.loading) {
                                        var diffTime = (getTimezoneOffset(state.timezone) + -state.nyTz) * oneHour;
                                        var realDate = new Date(forcedStartDate.getTime() + diffTime);
                                        var firstAvailableDay = new Date(state.availableDays.find(function(d) {
                                            return new Date(d + ' 23:59:59') >= realDate;
                                        }));
                                        if ('' + state.forcedStartDate === '' + realDate) return;

                                        setState({
                                            forcedStartDate: forcedStartDate,
                                            date: toDateStr(firstAvailableDay)
                                        });
                                        return;
                                    }

                                    setState({
                                        forcedStartDate: forcedStartDate,
                                        date: date
                                    });
                                } catch (e) {
                                    console.log(e);
                                }
                            },
                            forceEndDate: function forceEndDate(newDate) {
                                if (!newDate) {
                                    setState({
                                        forcedEndDate: undefined
                                    });
                                    return;
                                }

                                try {
                                    var forcedEndDate = new Date(newDate);
                                    if ('' + forcedEndDate === '' + state.forcedEndDate) return;
                                    var availableDays = state.availableDays.filter(function(d) {
                                        return new Date(d + ' 00:00:00') <= forcedEndDate;
                                    });

                                    var date = new Date(availableDays.indexOf(state.date) > -1 ? state.date : availableDays[availableDays.length - 1]);

                                    if (!date.getTime()) {
                                        date = forcedEndDate;
                                    }

                                    date = toDateStr(date);

                                    setState({
                                        forcedEndDate: forcedEndDate,
                                        date: date
                                    });
                                } catch (e) {
                                    console.log(e);
                                }
                            },
                            getComparableValue: function getComparableValue() {
                                return input.value && toDateTimeStr(dz(new Date(input.value.replace(/-/g, '/')), state.nyTz, getTimezoneOffset(props.timezone.value))) || '';
                            }
                        };

                        return _update;
                    })({
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
                            "value": "7"
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
                            "formBackground": "#fff"
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
            <link type="text/css" rel="stylesheet" href="https://cdn02.jotfor.ms/css/styles/payment/payment_styles.css?3.3.36261" />
            <link type="text/css" rel="stylesheet" href="https://cdn03.jotfor.ms/css/styles/payment/payment_feature.css?3.3.36261" />
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
                .formFooter-button,
                .submit-button {
                    background-color: #ee7624 !important;
                    border-color: #ee7624 !important;
                    color: #fff !important;
                }

                .appointmentSlot {
                    border: 1px solid #ee7624 !important;
                    color: #ee7624 !important;
                }

                .appointmentSlot:hover {
                    background-color: #f4f5f8ff !important;
                }

                .appointmentSlot.disabled {
                    background-color: #f4f5f8 !important;
                    border: 1px solid #c3cad8 !important;
                    color: #c3cad8 !important;
                    cursor: default !important;
                }

                .appointmentSlot.active {
                    background-color: #ee7624 !important;
                    border-color: #ee7624 !important;
                    color: #fff !important;
                }

                .appointmentFieldRow.forSelectedDate {
                    background-color: #ee7624 !important;
                }

                .txt-conecta-important {
                    font-weight: bold;
                    color: #ee7624;
                }
            </style>
            <script src="https://cdn.jotfor.ms//js/vendor/smoothscroll.min.js?v=3.3.36261"></script>
            <script src="https://cdn.jotfor.ms//js/errorNavigation.js?v=3.3.36261"></script>
            <script>
                $(document).ready(function() {
                    document.querySelector(".p3d-not-found-embed").textContent = 'Desculpe! Seu modelo 3D ainda não está disponível'
                });
            </script>
    <?php
    }
} else {
    header("location: index");
    exit();
}

    ?>