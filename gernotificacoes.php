<?php 
// ob_start();
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    require_once 'includes/dbh.inc.php';
    include("php/head_tables.php");
?>

    <style>
        .clicabletag {
            transition: ease all 0.2s;
        }

        .clicabletag:hover {
            cursor: pointer;
            transform: scale(0.9);
        }
    </style>

    <script src="https://cdn.tiny.cloud/1/zjf2h1vx7aqnqpv1gai59eeqiqb64jvhdg2tfv34o6i9i7lm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugin: 'a_tinymce_plugin',
            a_plugin_option: true,
            a_configuration_option: 400,
            height: 400,
            content_style: "body { color: black; }"
        });
    </script>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Notificação adicionada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Notificação foi deletada!</p></div>";
                    } else if ($_GET["error"] == "edited") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Notificação editada com sucesso!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10" id="titulo-pag">
                        <div class="row d-flex justify-content-start">
                            <div class="col-sm d-flex justify-content-start">
                                <h2 class="text-conecta" style="font-weight: 400;">Gestão de <span style="font-weight: 700;">Notificações</span></h2>
                            </div>
                            <div class="col-sm d-none d-sm-block">
                                <div class="d-flex justify-content-end">
                                    <div class="d-flex justify-content-end p-1">
                                        <button class="btn btn-conecta" data-toggle="modal" data-target="#novanotificacao"><i class="fas fa-plus"></i> Nova Notificação</button>
                                    </div>
                                    <div class="d-flex justify-content-end p-1">
                                        <a href="configNotificacao">
                                            <button class="btn btn-outline-secondary"><i class='fas fa-cog fa-1x'></i> </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr style="border: 1px solid #ee7624 !important;">
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <!--Tabs for large devices-->
                                <div class="d-flex justify-content-center">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link active text-tab" id="pills-email-tab" data-toggle="pill" href="#pills-email" role="tab" aria-controls="pills-email" aria-selected="true"><i class="far fa-envelope fa-1x"></i> E-mails</a>
                                        </li>
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link text-tab" id="pills-whatsapp-tab" data-toggle="pill" href="#pills-whatsapp" role="tab" aria-controls="pills-whatsapp" aria-selected="true"><i class="fab fa-whatsapp fa-1x"></i> Whatsapp</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Tabs for smaller devices -->
                                <div class="d-flex justify-content-center">
                                    <ul class="nav nav-pills mb-3 " id="pills-tab-small" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center active text-tab" id="pills-email-tab" data-toggle="pill" href="#pills-email" role="tab" aria-controls="pills-email" aria-selected="true"><i class="far fa-envelope fa-2x"></i></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-whatsapp-tab" data-toggle="pill" href="#pills-whatsapp" role="tab" aria-controls="pills-whatsapp" aria-selected="true"><i class="fab fa-whatsapp fa-2x"></i></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-email" role="tabpanel" aria-labelledby="pills-email-tab">
                                        <h4 class="text-black py-2"><b>E-mails</b></h4>
                                        <div class="content-panel">
                                            <table id="tableEmail" class="table table-striped table-advance table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Template</th>
                                                        <th>Título</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $retEmail = mysqli_query($conn, "SELECT * FROM notificacoesexternasemail ");
                                                    while ($rowEmail = mysqli_fetch_array($retEmail)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $rowEmail["ntfEmailId"]; ?></td>
                                                            <td><?php echo $rowEmail["ntfEmailNomeTemplate"]; ?></td>
                                                            <td><?php echo $rowEmail["ntfEmailAssuntoEmail"]; ?></td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <!-- <button class="btn text-info m-1" data-toggle="modal" data-target="#updatenotificacao" onclick="populate('email',<?php echo $rowEmail['ntfEmailId']; ?>)"><i class="far fa-edit"></i></button> -->
                                                                    <a href="editNotificacao?id=<?php echo $rowEmail["ntfEmailId"]; ?>&type=email">
                                                                        <button class="btn text-info m-1"><i class="far fa-edit"></i></button>
                                                                    </a>
                                                                    <a href="manageNotificacao?deleteemail=<?php echo $rowEmail["ntfEmailId"]; ?>">
                                                                        <button class="btn text-danger m-1" onClick="return confirm('Você realmente deseja apagar essa notificação?');"><i class="far fa-trash-alt"></i></button></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-whatsapp" role="tabpanel" aria-labelledby="pills-whatsapp-tab">
                                        <h4 class="text-black py-2"><b>Whatsapp</b></h4>
                                        <div class="content-panel">
                                            <table id="tableWpp" class="table table-striped table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Template</th>
                                                        <th>Título</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $retWpp = mysqli_query($conn, "SELECT * FROM notificacoesexternaswpp ");
                                                    while ($rowWpp = mysqli_fetch_array($retWpp)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $rowWpp["ntfWppId"]; ?></td>
                                                            <td><?php echo $rowWpp["ntfWppNomeTemplate"]; ?></td>
                                                            <td><?php echo $rowWpp["ntfWppTitulo"]; ?></td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <a href="editNotificacao?id=<?php echo $rowWpp["ntfWppId"]; ?>&type=wpp">
                                                                        <button class="btn text-info m-1"><i class="far fa-edit"></i></button>
                                                                    </a>
                                                                    <a href="manageNotificacao?deletewpp=<?php echo $rowWpp["ntfWppId"]; ?>">
                                                                        <button class="btn text-danger m-1" onClick="return confirm('Você realmente deseja apagar essa notificação?');"><i class="far fa-trash-alt"></i></button></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Modal Add Email -->
                        <div class="modal fade" id="novanotificacao" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-black">Nova Notificação</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <div class="form-row p-2 border rou rounded bg-light pt-4">
                                                <div class="form-group col-md d-flex justify-content-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tipoNotific" id="typeEmail" value="email">
                                                        <label class="form-check-label text-black" for="typeEmail">E-mail</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tipoNotific" id="typeWpp" value="wpp">
                                                        <label class="form-check-label text-black" for="typeWpp">Wpp</label>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md">
                                                    <label class="form-label text-black" for="categoria">Categoria <b style="color: red;">*</b> </label>
                                                    <select name="categoria" class="form-control" id="categoria" onchange="searchPlaceholders(this)" required>
                                                        <option>Selecione uma opção</option>
                                                        <?php
                                                        $retSlcBd = mysqli_query($conn, "SELECT * FROM bancosdadosnotificacoes ORDER BY bdntfNome ASC");
                                                        while ($rowSlcBd = mysqli_fetch_array($retSlcBd)) {
                                                        ?>
                                                            <option value="<?php echo $rowSlcBd['bdntfNome']; ?>"><?php echo strtoupper($rowSlcBd['bdntfNome']); ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row pt-3">
                                                <div class="form-group col-md">
                                                    <label for="template" class="text-black">Nome Template <b style="color: red;">*</b> </label>
                                                    <input type="text" class="form-control" id="template" name="template" required>
                                                </div>
                                                <div class="form-group col-md">
                                                    <label for="titulo" class="text-black">Assunto / Título <b style="color: red;">*</b> </label>
                                                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md">
                                                    <label for="destinatario" class="text-black">Destinatário <b style="color: red;">*</b> </label>
                                                    <input type="text" class="form-control" id="destinatario" name="destinatario" required>
                                                    <small>Utilize alguma tag de tipo [nome] ou [sistema]</small>
                                                </div>
                                            </div>
                                            <div class="form-row p-2" id="rowPlacehoders" hidden>
                                                <div class="form-group col-md">
                                                    <label for="titulo" class="text-black">Tags: </label>
                                                    <div class="d-block" id="resultPlacehoders">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md">
                                                    <label for="texto" class="text-black">Texto<b style="color: red;">*</b> </label>
                                                    <textarea class="form-control text-black" name="texto" id="texto"></textarea>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="submit" name="enviar" class="btn btn-primary">Salvar</button>
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
        <?php
        // ob_start();

        if (isset($_POST["enviar"])) {

            // set the default timezone to use.
            date_default_timezone_set('UTC');
            $dtz = new DateTimeZone("America/Sao_Paulo");
            $dt = new DateTime("now", $dtz);
            $data = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");
            $user = $_SESSION['useruid'];

            $tipoNotific = addslashes($_POST['tipoNotific']);
            $bd = addslashes($_POST['categoria']);
            $destinatario = addslashes($_POST['destinatario']);

            $template = addslashes($_POST['template']);
            $titulo = addslashes($_POST['titulo']);
            $texto = addslashes($_POST['texto']);
            $texto = htmlspecialchars($texto);

            require_once 'includes/dbh.inc.php';
            require_once 'includes/functions.inc.php';

            if ($tipoNotific == "email") {
                addNotificacaoEmail($conn, $bd, $template, $titulo, $texto, $destinatario, $data, $user);
            } else {

                addNotificacaoWpp($conn, $bd, $template, $titulo, $texto, $destinatario, $data, $user);
            }
        }
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.1/jquery.min.js" defer></script>
        <script>
            $(document).ready(function() {
                $('#tableEmail').DataTable({
                    "lengthMenu": [
                        [20, 40, 80, -1],
                        [20, 40, 80, "Todos"],
                    ],
                    "language": {
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                        "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                        "lengthMenu": "Mostrar _MENU_ itens",
                        "zeroRecords": "Nenhuma proposta encontrada"
                    },
                    "order": [
                        [0, "asc"]
                    ]
                });
                $('#tableWpp').DataTable({
                    "lengthMenu": [
                        [20, 40, 80, -1],
                        [20, 40, 80, "Todos"],
                    ],
                    "language": {
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                        "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                        "lengthMenu": "Mostrar _MENU_ itens",
                        "zeroRecords": "Nenhuma proposta encontrada"
                    },
                    "order": [
                        [0, "asc"]
                    ]
                });
            });
        </script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js" defer></script>
        <script>
            // console.log(document.querySelectorAll('form form'));

            function searchPlaceholders(elem) {
                cleanTags();
                //Recuperar o valor do campo
                var pesquisa = elem.value;

                //Verificar se há algo digitado
                if (pesquisa != '') {
                    var dados = {
                        bd: pesquisa
                    }
                    $.post('proc_pesq_placeholders.php', dados, function(retorna) {
                        //Mostra dentro da ul os resultado obtidos 
                        document.getElementById("resultPlacehoders").insertAdjacentHTML("beforeend", retorna);
                        document.getElementById("rowPlacehoders").hidden = false;
                    });
                }
            }

            function addTag(elem) {
                var tag = elem.innerText;

                var textBefore = tinymce.activeEditor.getContent();
                var textAfter = `${textBefore} ${tag}`;

                tinymce.activeEditor.setContent(textAfter, {
                    format: 'html'
                });

            }

            function cleanTags() {
                document.getElementById("resultPlacehoders").innerHTML = '';
            }
        </script>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>