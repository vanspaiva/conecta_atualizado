<?php
session_start();

if (!empty($_GET)) {
    include("php/head_prop.php");
    require_once 'includes/dbh.inc.php';
    $idProp = addslashes($_GET['id']);

    // // decrypt to get again $plaintext
    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    // $parts = explode(':', $idProp);
    // $idProp = openssl_decrypt($parts[0], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, base64_decode($parts[1]));

    $idProp = deshashItem($idProp);

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $data_criacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    $localIP = getHostByName(getHostName());

    $userAceite = $_SESSION["useruid"];
    $dataAceite = $data_criacao;
    $ipAceite = $localIP;


    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idProp . "';");

    while ($row = mysqli_fetch_array($ret)) {
        $user = $row['propUserCriacao'];
        $status = $row['propStatus'];

        $cnpjcpf = $row['propCnpjCpf'];
    }

    if (($_SESSION["userperm"] == 'Distribuidor(a)') ||  ($_SESSION["userperm"] == 'Dist. Comercial')) {
        $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
        while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
            $cnpjUser = $rowCnpj['usersCnpj'];
        }
    } else {
        $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
        while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
            $cnpjUser = $rowCnpj['usersCpf'];
        }
    }

    if (($cnpjUser == $cnpjcpf) && (($status == "PROP. ENVIADA"))) {

        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idProp . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $dataEHoraProp = explode(" ", $row['propDataCriacao']);
            $dataProp = $dataEHoraProp[0];

            $email = $row['propEmailEnvio'];



            $userCriador = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $row['propUserCriacao'] . "';");
            while ($rowUserCriador = mysqli_fetch_array($userCriador)) {
                $empresa = $rowUserCriador['usersEmpr'];
                $ufUser = $rowUserCriador['usersUf'];
                $solicitante = $rowUserCriador['usersName'];

                $rep = $row['propRepresentante'];

                $retRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $rep . "';");
                while ($rowRep = mysqli_fetch_array($retRep)) {
                    $representante = $rowRep['usersName'];
                    $representante = explode(" ", $representante);
                    $representante = $representante[0];
                    $representanteFone = $rowRep['usersCel'];
                }
            }

            $solicitante = explode(" ", $solicitante);
            $solicitante = $solicitante[0];

?>
            <style media="print">
                @page {
                    size: auto;
                    margin: 0;
                }
            </style>

            <style>
                #printOnly {
                    display: none;
                }

                @media print {
                    #printOnly {
                        display: block;
                    }

                    * {
                        -webkit-print-color-adjust: exact !important;
                        color-adjust: exact !important;
                    }
                }

                .conecta-icon {

                    background-image: url("https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_f8c738a66e66454b52c58395991cf3f1.png");
                    background-repeat: no-repeat;
                    background-size: 70vh;
                    background-position: center;
                }
            </style>

            <body class="bg-white" style="overflow-x: hidden;">

                <div class="faixaRoxa d-print-none py-2">
                    <div class="conatiner">
                        <div class="row d-flex">
                            <div class="col d-flex justify-content-center">
                                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                    <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="conatiner">
                    <div class="row p-4">
                        <div class="col py-4">
                            <h3 style="text-align: center;"><b>Aceite da Proposta</b></h3>
                            <hr>
                            <p style="text-align: center;">Prezado cliente, para darmos continuidade no seu pedido é necessario sua aprovação com o envio do comprovante conforme a forma de pagamento descrita em sua proposta.</p>
                            <p style="text-align: center;"><b>Atenção!</b> Antes de enviar certifique-se de que todos os dados estão corretos.</p>
                            <p style="text-align: center;">Após o envio nossa equipe do financeiro realizará o processamento e você será notificado.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 style="text-align: center;"><b> Dados da Proposta</b></h5>
                                    <hr>
                                    <div class="container">
                                        <div class="row p-4">
                                            <div class="col">
                                                <h6 style="text-align: center;">ID Proposta:</h6>
                                                <p style="text-align: center;"><?php echo $idProp; ?></p>
                                            </div>
                                            <div class="col">
                                                <h6 style="text-align: center;">CPF/CNPJ:</h6>
                                                <p style="text-align: center;"><?php echo $cnpjcpf; ?></p>
                                            </div>
                                            <div class="col">
                                                <h6 style="text-align: center;">Solicitante:</h6>
                                                <p style="text-align: center;"><?php echo $solicitante; ?></p>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <div class="content-panel">
                                                    <form class="form-horizontal style-form" name="form1" action="includes/propaceite.inc.php" method="post" enctype="multipart/form-data">
                                                        <div class="form-row" hidden>
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="propid">Prop ID</label>
                                                                <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
                                                                <small class="text-muted">ID não é editável</small>
                                                            </div>

                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="useruid">User</label>
                                                                <input type="text" class="form-control" id="useruid" name="useruid" value="<?php echo $_SESSION["useruid"]; ?>" required readonly>
                                                            </div>

                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="userip">IP</label>
                                                                <input type="text" class="form-control" id="userip" name="userip" value="<?php echo $localIP; ?>" required readonly>
                                                            </div>

                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="datacriacao">Data</label>
                                                                <input type="text" class="form-control" id="datacriacao" name="datacriacao" value="<?php echo $dataAceite; ?>" required readonly>
                                                            </div>
                                                        </div>


                                                        <div class="d-flex d-block justify-content-around align-items-top">
                                                            <div class="col-md form-group">
                                                                <label class="form-label text-black" for="pgto">Forma de Pagamento <b style="color: red;">*</b></label>
                                                                <select class="form-control" id="pgto" name="pgto">
                                                                    <option value="null">Escolha uma opção</option>
                                                                    <?php
                                                                    $retPgto = mysqli_query($conn, "SELECT * FROM formapagamento ORDER BY pgtoNome ASC;");
                                                                    while ($rowPgto = mysqli_fetch_array($retPgto)) {
                                                                    ?>
                                                                        <option value="<?php echo $rowPgto['pgtoNome']; ?>"> <?php echo $rowPgto['pgtoNome']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </select>

                                                            </div>
                                                            <div class="col-md form-group ">
                                                                <label class='control-label text-black'>Anexe aqui o seu comprovante de pagamento <b style="color: red;">*</b></label>
                                                                <div class="d-flex justify-content-center p-2 border rounded bg-light">
                                                                    <div>
                                                                        <label class="d-block" for="finfile" style="text-align: center;"><i class="fas fa-upload fa-3x hovericon"></i></label>
                                                                        <small class="d-block" id="file-name" style="text-align: center; color: #ee7624;"></small>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control" type="file" id="finfile" name="finfile" onchange="javascript:updateList()" accept="image/jpeg,image/png,application/pdf" hidden>
                                                                <small class="text-muted">Imagens ou PDF</small>
                                                                <script>
                                                                    updateList = function() {
                                                                        var input = document.getElementById('finfile');
                                                                        var output = document.getElementById('file-name');

                                                                        output.innerHTML = '';
                                                                        for (var i = 0; i < input.files.length; ++i) {
                                                                            output.innerHTML += input.files.item(i).name;
                                                                        }
                                                                    }
                                                                </script>
                                                                <style>
                                                                    .hovericon {
                                                                        transition: ease all 0.2s;
                                                                    }

                                                                    .hovericon:hover {
                                                                        transform: scale(0.9);
                                                                        cursor: pointer;
                                                                    }
                                                                </style>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex justify-content-center pt-3">
                                                            <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
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




                <br>

                <!--<div class="d-print-none d-flex justify-content-center">
                <?php
                if ($status == "PROP. ENVIADA") {
                ?>
                    <a href="propaceite.php?id=<?php echo $idProp; ?>&user=<?php echo $userAceite; ?>&data=<?php echo $dataAceite; ?>&ip=<?php echo $ipAceite; ?>">
                        <button class="btn btn-success m-2" onClick="return confirm('Eu declaro aceitar a proposta listada aqui!');">ENVIAR </button>
                    </a>
                <?php
                }
                ?>

            </div>-->
    <?php
        }

        include_once 'php/footer_index.php';
    } else {
        header("location: ../minhassolicitacoes");
        exit();
    }
} else {
    header("location: index");
    exit();
}
    ?>