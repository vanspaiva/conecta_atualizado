<?php
// Require composer autoload
require_once  '../vendor/autoload.php';
require_once 'includes/dbh.inc.php';

// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();


$id = $_GET['id'];



$ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='$id'");
while ($row = mysqli_fetch_array($ret)) {
    $dataEHoraProp = explode(" ", $row['propDataCriacao']);
    $dataProp = $dataEHoraProp[0];

    $total = $row['propValorSomaTotal'];

    $email = $row['propEmailEnvio'];
    $empresa = $row['propEmpresa'];

    $txtReprovada = $row['propTxtReprov'];

    $userCriador = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $row['propUserCriacao'] . "';");
    while ($rowUserCriador = mysqli_fetch_array($userCriador)) {
        // $empresa = $rowUserCriador['usersEmpr'];
        $ufUser = $rowUserCriador['usersUf'];

        if (($ufUser == 'AC') || ($ufUser == 'AP') || ($ufUser == 'AM') || ($ufUser == 'PA') || ($ufUser == 'RO') || ($ufUser == 'RR') || ($ufUser == 'TO') || ($ufUser == 'ES') || ($ufUser == 'RJ') || ($ufUser == 'SP') || ($ufUser == 'PR') || ($ufUser == 'RS') || ($ufUser == 'SC')) {
            $representante = 'Luis';
        } else if (($ufUser == 'AL') || ($ufUser == 'BA') || ($ufUser == 'CE') || ($ufUser == 'MA') || ($ufUser == 'PB') || ($ufUser == 'PI') || ($ufUser == 'PE') || ($ufUser == 'RN') || ($ufUser == 'SE') || ($ufUser == 'MT') || ($ufUser == 'MS') || ($ufUser == 'MG')) {
            $representante = 'Marcela';
        } else if (($ufUser == 'DF') || ($ufUser == 'GO')) {
            $representante = 'Fabiana';
        }
    }
}


// $html = '<bookmark content="Start of the Document" /><div>' . $nome . '</div>';
$html = '<body class="bg-white">

        

        <div class="container">
            <div class="row">
                <div class="col p-3 d-flex">
                    <div class="col-4 d-flex justify-content-start align-items-center">
                        <!-- <h3>Proposta Comercial</h3> -->
                        <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_0906db058ec5ee8cc4bcd93d25503562.png" alt="CPMH Digital" style="width: 20vw;">
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <h6>Proposta Nº ' . $row['propId'] . '</h6>
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <h6>' . $dataProp . '</h6>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col p-3 d-flex">
                    <div class="col-8 d-flex justify-content-start px-2">


                        <h6><b>negocios@cpmh.com.br</b></h6>
                    </div>
                    <div class="col-4 d-flex justify-content-end">
                        <h6><b>Validade:</b> 30 dias</h6>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col p-3 d-flex">
                    <div class="col-3 d-flex justify-content-start">
                        <span><b>E-mail: </b> ' .  $email . '</span>

                    </div>
                    <div class="col-3 d-flex justify-content-start">
                    
                            <span><b>Empresa</b>' . $empresa . '</span>
                        
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <span><b>Repres.</b>' . $representante . '</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col p-3 d-flex">
                    <div class="col-3 d-flex justify-content-start">
                        <span><b>Nome Dr(a)</b>' . $row['propNomeDr'] . '</span>
                    </div>
                    <div class="col-3 d-flex justify-content-start">
                        <span><b>Nome Paciente</b>' . $row['propNomePac'] . '</span>

                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <span><b>Convênio</b>' . $row['propConvenio'] . '</span>
                    </div>
                </div>
            </div>
            <hr>

        </div>

        
        <br>
        <br>


        <div class="container py-3 my-2">
            <table id="tabelaTotal" class="table table-advance">

                <tbody>
                    <tr class="d-flex justify-content-end">
                        <th style="font-weight: bold;">Total</th>
                        <th>' . number_format($valorTotalProp, 2, ',', '.') . '</th>
                    </tr>
                </tbody>
            </table>
        </div>';

// Write some HTML code:
$mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
$mpdf->Output();
