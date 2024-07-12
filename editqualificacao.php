<?php

session_start();
if (isset($_GET["id"])) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Qualidade'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        $id = addslashes($_GET['id']);
        $id = deshashItemNatural($id);

        $item = $id;
        $itemname = "id";
        $table = "qualificacao";

        $data = getItemFromTable($conn, $item, $itemname, $table);

        $item = $data["cnpj"];
        $itemname = "usersCnpj";
        $table = "users";
        $dataEmpresa = getItemFromTable($conn, $item, $itemname, $table);

        // print_r($dataEmpresa);
?>

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
                        if ($_GET["error"] == "stmtfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                        } else if ($_GET["error"] == "none") {
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto editado com sucesso!</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="container-fluid">
                    <div class="row py-4">
                        <div class="col">
                            <a href="qualificacaocliente" class="text-conecta" style="text-decoration: none;">
                                <i class="fa-solid fa-arrow-left"></i> Voltar a lista
                            </a>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Informações da Empresa</h4>
                                </div>

                                <div class="card-body">
                                    <?php
                                    foreach ($dataEmpresa as $key => $value) {
                                        ${$key} = $value;
                                    }
                                    ?>
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label class="form-label text-black font-weight-bold" for="usersCnpj">CNPJ</label>
                                            <div class="py-2"><?php echo $usersCnpj . " - " . $usersUf; ?></div>
                                        </div>
                                        <div class="form-group col-md">
                                            <label class="form-label text-black font-weight-bold" for="usersEmpr">Nome Empresa</label>
                                            <div class="py-2"><?php echo $usersEmpr; ?></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label class="form-label text-black font-weight-bold" for="usersEmailEmpresa">E-mail Empresa</label>
                                            <div class="py-2"><?php echo $usersEmailEmpresa; ?></div>
                                        </div>
                                        <div class="form-group col-md">
                                            <label class="form-label text-black font-weight-bold" for="usersFone">Tel Empresa</label>
                                            <div class="py-2"><?php echo $usersFone; ?></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label class="form-label text-black font-weight-bold" for="usersName">Nome Responsável</label>
                                            <div class="py-2"><?php echo $usersName; ?></div>
                                        </div>
                                        <div class="form-group col-md">
                                            <label class="form-label text-black font-weight-bold" for="usersEmail">E-mail Responsável</label>
                                            <div class="py-2"><?php echo $usersEmail; ?></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label class="form-label text-black font-weight-bold" for="usersUid">UID Responsável</label>
                                            <div class="py-2"><?php echo $usersUid; ?></div>
                                        </div>
                                        <div class="form-group col-md">
                                            <label class="form-label text-black font-weight-bold" for="usersCel">Celular Responsável</label>
                                            <div class="py-2"><?php echo $usersCel; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="card">
                                <div class="card-header">
                                    <h4>Atualizar Datas</h4>
                                </div>

                                <div class="card-body">
                                    <?php
                                    foreach ($data as $key => $value) {
                                        ${$key} = $value;
                                    }
                                    $statusgeral = transformStatusGeralQualificacao2($statusgeral);

                                    //statusDatas
                                    $stLicencafuncionamento = getStatusFromData($licencafuncionamento);
                                    $stLicencasanitaria = getStatusFromData($licencasanitaria);
                                    $stCrt = getStatusFromData($crt);
                                    ?>

                                    <form action="includes/qualificacao.inc.php" method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="id">ID</label>
                                                <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>" required readonly>
                                                <small class="text-muted">ID não é editável</small>
                                            </div>
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="statusgeral">Status Geral</label>
                                                <br>
                                                <div class="py-2"><?php echo $statusgeral; ?></div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="cnpj">CNPJ</label>
                                                <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?php echo $cnpj; ?>" required readonly>
                                            </div>
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="situacao">Situação</label>
                                                <input type="text" class="form-control" id="situacao" name="situacao" value="<?php echo $situacao; ?>">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="cartadistribuicao">Carta Distribuição</label>
                                                <input type="text" class="form-control" id="cartadistribuicao" name="cartadistribuicao" value="<?php echo $cartadistribuicao; ?>">
                                            </div>
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="dataenvioformqualificacao">Dt. Envio Form</label>
                                                <input type="date" class="form-control" id="dataenvioformqualificacao" name="dataenvioformqualificacao" value="<?php echo $dataenvioformqualificacao; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="licencafuncionamento">Licença funcionamento</label>
                                                <input type="date" class="form-control" id="licencafuncionamento" name="licencafuncionamento" value="<?php echo $licencafuncionamento; ?>">
                                            </div>
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold">Status Licença funcionamento</label>
                                                <br>
                                                <div class="py-1"><?php echo $stLicencafuncionamento; ?></div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="licencasanitaria">Licença Sanitária</label>
                                                <input type="date" class="form-control" id="licencasanitaria" name="licencasanitaria" value="<?php echo $licencasanitaria; ?>">
                                            </div>
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold">Status Licença Sanitária</label>
                                                <br>
                                                <div class="py-1"><?php echo $stLicencasanitaria; ?></div>
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="crt">CRT</label>
                                                <input type="date" class="form-control" id="crt" name="crt" value="<?php echo $crt; ?>">
                                            </div>
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold">Status CRT</label>
                                                <br>
                                                <div class="py-1"><?php echo $stCrt; ?></div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="afe">AFE</label>
                                                <input type="text" class="form-control" id="afe" name="afe" value="<?php echo $afe; ?>">
                                            </div>
                                            <div class="form-group col-md">
                                                <label class="form-label text-black font-weight-bold" for="cbpfcbpad">CBPF/CBPAD</label>
                                                <input type="date" class="form-control" id="cbpfcbpad" name="cbpfcbpad" value="<?php echo $cbpfcbpad; ?>">
                                            </div>
                                        </div>


                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Histórico Observações</h4>
                                </div>

                                <div class="card-body">

                                    <div class="row d-flex">
                                        <div class="col-md">

                                            <div id="coment-box" class="rounded" style="overflow-x: hidden; overflow-y: scroll; max-height: 60vh;">

                                                <?php
                                                $retMsg = mysqli_query($conn, "SELECT * FROM comentariosqualificacao WHERE comentRef='$id' ORDER BY comentId ASC");


                                                while ($rowMsg = mysqli_fetch_array($retMsg)) {
                                                    $msg = $rowMsg['comentText'];
                                                    $owner = $rowMsg['comentUser'];
                                                    $timer = $rowMsg['comentHorario'];
                                                    $tipoUsuario = $rowMsg['comentTipoUser'];

                                                    $timer = explode(" ", $timer);
                                                    $data = $timer[0];
                                                    // $dataAmericana = explode("-", $date);
                                                    // $ano = str_split($dataAmericana[0]);
                                                    // $ano = $ano[0] . $ano[1];
                                                    // $data = $dataAmericana[2] . '/' . $dataAmericana[1] . '/' . $ano;


                                                    $hora = $timer[1];
                                                    // $horaEnvio = explode(":", $hour);
                                                    // $hora = 'às ' . $horaEnvio[0] . ':' . $horaEnvio[1];
                                                    $horario = $data . ' às ' . $hora;


                                                    switch ($tipoUsuario) {
                                                        case 'Administrador':
                                                            $ownerColor = 'darkred';
                                                            $hourColor = "#fff";
                                                            break;

                                                        case 'Representante':
                                                            $ownerColor = 'darkpink';
                                                            $hourColor = "#fff";
                                                            break;

                                                        case 'Comercial':
                                                            $ownerColor = 'darkblue';
                                                            $hourColor = "#fff";
                                                            break;

                                                        case 'Planejador(a)':
                                                            $ownerColor = 'darkpurple';
                                                            $hourColor = "#fff";
                                                            break;

                                                        case 'Financeiro':
                                                            $ownerColor = 'darkgreen';
                                                            $hourColor = "#fff";
                                                            break;

                                                        case 'Qualidade ':
                                                            $ownerColor = 'brown';
                                                            $hourColor = "#fff";
                                                            break;

                                                        default:
                                                            $ownerColor = 'orange';
                                                            $hourColor = "#874214";
                                                            break;
                                                    }

                                                ?>
                                                    <?php
                                                    if ($_SESSION['useruid'] == $owner) {


                                                    ?>
                                                        <div class="row py-1">
                                                            <div class="col d-flex justify-content-end w-50">
                                                                <div class="bg-secondary bg-gradient text-white rounded rounded-3 px-2 py-1">
                                                                    <div style="font-size: 1rem; color: #323236;"><b><?php echo $owner; ?></b>:</div>
                                                                    <p class="text-white text-wrap" style="font-size: 1.3rem; max-width: 200px;"><?php echo $msg; ?></p>
                                                                    <small style="color: #323236;"><?php echo $horario; ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="row py-1">
                                                            <div class="col d-flex justify-content-start w-50">
                                                                <div class="bg-<?php echo $ownerColor; ?>-conecta text-white rounded rounded-3 px-2 py-1">
                                                                    <div style="font-size: 1rem; color: <?php echo $hourColor; ?>;"><b><?php echo $owner; ?></b>:</div>
                                                                    <p class="text-white text-wrap" style="font-size: 1.3rem; max-width: 300px;"><?php echo $msg; ?></p>
                                                                    <small style="color: <?php echo $hourColor; ?>;"><?php echo $horario; ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>

                                            <div class="row d-flex justify-content-center">
                                                <div class="col-sm px-2 py-3">
                                                    <form action="includes/qualificacao.inc.php" method="post">
                                                        <div class="container" hidden>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label for="idref">ID Ref</label>
                                                                    <input type="text" class="form-control" name="idref" id="idref" value="<?php echo $id; ?>" readonly>
                                                                </div>
                                                                <div class="col">
                                                                    <label for="user">Usuário</label>
                                                                    <input type="text" class="form-control" name="user" id="user" value="<?php echo $_SESSION['useruid']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col d-flex justify-content-around align-items-start">
                                                                    <div class="p-1">
                                                                        <textarea class="form-control color-bg-dark color-txt-wh" style="font-size: 0.8rem;" name="coment" id="coment" rows="1" onkeyup="limite_textarea(this.value)" maxlength="300"></textarea><br><br>
                                                                        <div class="row d-flex justify-content-start p-0 m-0">
                                                                            <small class="pl-2 text-muted" style="margin-top: -30px !important;"><small class="text-muted" id="cont">300</small> Caracteres restantes</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="p-1">
                                                                        <button type="submit" name="submitcoment" class="btn btn-primary" style="font-size: small;"> <i class="fa fa-paper-plane" aria-hidden="true"></i> </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <script>
                                                $(document).ready(function() {
                                                    limite_textarea(document.getElementById("coment").value);
                                                });

                                                function limite_textarea(valor) {
                                                    quant = 300;
                                                    total = valor.length;
                                                    if (total <= quant) {
                                                        resto = quant - total;
                                                        document.getElementById('cont').innerHTML = resto;
                                                    } else {
                                                        document.getElementById('coment').value = valor.substr(0, quant);
                                                    }
                                                }

                                                // JavaScript para rolar para o final da div
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    var conteudoDiv = document.getElementById("coment-box");
                                                    conteudoDiv.scrollTop = conteudoDiv.scrollHeight;
                                                });
                                            </script>

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
        header("location: index");
        exit();
    }
} else {
    header("location: index");
    exit();
}


    ?>