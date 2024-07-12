<?php
header("Content-Type:application/json");

// $_POST = array(
//     'submission_id' => '5733565867013578927',
//     'formID' => '231493945031051',
//     'ip' => '187.32.26.107',
//     'documento' => '7 Dispensa honorário convênio',
//     'nomedo' => 'Vanessa Teste',
//     'cpf28' => '052.581.961-43',
//     'emailpaciente' => 'vanessa.paiva@fixgrupo.com.br',
//     'convenio' => 'AMIL',
//     'dr' => 'Hugo - DF',
//     'procedimento' => '1 Maxila e mandibula CustomLIFE',
//     'data' => array(
//         'day' => '17',
//         'month' => '10',
//         'year' => '2023'
//     )

// );



function pegarNomeMedico($array)
{

    $medico = $array['dr'];
    $medico = explode(' - ', $medico);

    return $medico[0];
}

function pegarPrimeiroNomePaciente($array)
{

    $paciente = $array['nomedo'];
    $paciente = explode(' ', $paciente);

    return $paciente[0];
}

function pegarUfMedico($array)
{

    $medico = $array['dr'];
    $medico = explode(' - ', $medico);

    return $medico[1];
}

function ajustarData($array)
{
    $dia = $array['data']['day'];
    $mes = $array['data']['month'];
    $ano = $array['data']['year'];

    return $dia . "/" . $mes . "/" . $ano;
}

function pegarNomeCompletoMedico($nomeMedico)
{

    switch ($nomeMedico) {
        case 'Frederico Rodger':
            $nomeMedico = 'Frederico Rodger R. G. Cardoso';
            break;

        case 'Frederico':
            $nomeMedico = 'Frederico Rodger R. G. Cardoso';
            break;

        case 'Hugo':
            $nomeMedico = 'Hugo Santos Cunha';
            break;

        case 'Elder':
            $nomeMedico = 'Elder S. Carneiro';
            break;

        case 'Thiago':
            $nomeMedico = 'Thiago O. Freitas';
            break;

        case 'Elisa':
            $nomeMedico = 'Elisa C. Gomes';
            break;
        default:
            # code...
            break;
    }

    return $nomeMedico;
}

function pegarTipoDocumento($array)
{
    $tipoDocumento = $array['documento'];

    switch ($tipoDocumento) {
        case '7 Dispensa honorário convênio':
            $printable = '
            <div>
            <h2><b>Assunto: </b> Dispensa de cobrança de Honorários Profissionais</h2>
            <br>

            <p class="text-justify">Prezado Senhor(a),

            Venho por meio da presente correspondência, formalizar que os honorários profissionais relacionados à cirurgia da paciente, relacionada aos procedimentos abaixo discriminados, não serão cobrados por mim ou minha equipe, por mera liberalidade.             
            Declaro então que a paciente não precisará pagar mais nada para mim ou minha equipe nem agora e nem após a realização de todo procedimento cirúrgico.</p>

            </div>
            ';
            break;

        case 'Carta de honorário advogado':
            $printable = '
            <div>
            <h2><b>Assunto: </b> Honorários Cirúrgicos </h2>
            <br>

            <p class="text-justify">Obs.: Os Honorários cobrados são referentes aos custos com toda a equipe cirúrgica
            <br>
            02 cirurgiões e 02 auxiliares/Instrumentadores</p>

            </div>
            ';
            break;

        case '8 Termo de interlocutor':
            $printable = '
            <div>
            <h2><b>Assunto: </b> TERMO DE INTERLOCUTOR</h2>
            <br>

            <p class="text-justify">Prezado Senhor(a),

            O termo é um documento utilizado em contextos médicos e de saúde em que EU Sr(a) , portador (a) do CPF nº designo a empresa SmileFIX e sua equipe para serem meus intermediadores e cuidarem das questões relacionadas ao meu tratamento e cuidados da saúde no período inicial de solicitação da cirurgia até a realização da mesma, cirurgia a ser realizada com o Dr(a),  pelo convênio : , como:
            - Abrir reclamações na ANS (Agência Nacional de Saúde);

            - Fazer a gestão do meu processo de solicitação de cirurgia junto ao meu convênio de saúde;

            - Intervir na comunicação junto ao hospital;

            - Receber informações médicas e de saúde em meu nome;

            - Interagir com profissionais de saúde em meu nome com intuito do andamento da minha cirurgia solicitada junto ao Dr(a).</p>

            </div>
            ';
            break;


        default:
            # code...
            break;
    }

    return $printable;
}

function pegarNomeTipoDocumento($array)
{
    $tipoDocumento = $array['documento'];

    switch ($tipoDocumento) {
        case '7 Dispensa honorário convênio':
            $printable = 'Dispensa de cobrança de Honorários Profissionais';
            break;

        case 'Carta de honorário advogado':
            $printable = 'Honorários Cirúrgicos';
            break;

        case '8 Termo de interlocutor':
            $printable = 'Termo de Interlocutor';
            break;


        default:
            # code...
            break;
    }

    return $printable;
}

function pegarEndTipoDocumento($array)
{
    $tipoDocumento = $array['documento'];

    switch ($tipoDocumento) {
        case '7 Dispensa honorário convênio':
            $printable = '
            <div>

            <p class="text-justify">Na oportunidade, coloco-me à disposição para eventuais esclarecimentos que se façam necessários.
            <br>
            Atenciosamente,</p>

            </div>
            ';
            break;

        case 'Carta de honorário advogado':
            $printable = '
            <div>

            <p class="text-justify">
            DADOS BANCÁRIOS PARA PAGAMENTO:
            BRB -Banco Regional de Brasília Nº.: 070
            Agência: 043
            Conta Corrente: 051571-5
            Pix telefone: 61996632631


            CNPJ: 283689950001-67

            RENOVARI ODONTOLOGIA E ESTÉTICA FACIAL - LTDA
            Na oportunidade, coloco-me à disposição para eventuais esclarecimentos que se façam necessários.
            <br>
            Atenciosamente,</p>

            </div>
            ';
            break;

        case '8 Termo de interlocutor':
            $printable = '
            <div>

            <p class="text-justify">Na oportunidade, coloco-me à disposição para eventuais esclarecimentos que se façam necessários.
            <br>
            Atenciosamente,</p>

            </div>
            ';
            break;


        default:
            # code...
            break;
    }

    return $printable;
}

function pegarDescricaoProcedimento($array)
{
    $rawProcedimento = $array['procedimento'];
    $nomePaciente = $array['nomedo'];

    switch ($rawProcedimento) {
        case '1 Maxila e mandibula CustomLIFE':
            $printable = '
            <div>
            <h5><b>Maxila e Mandíbula</b></h5>
            
            <p class="text-justify">Os procedimentos cirúrgico indicados para Sr(a) ' . $nomePaciente . '
            <br>
            Código TUSS- ROL ANS Nº 465/2021

            <br> 30208033 Osteotomias alvéolo-palatinas
            <br> 30208041 Osteotomias Segmentares da maxila
            <br> 30208084 Osteotomias Crânio-maxilares complexas 
            <br> 30209021 Osteoplastias de mandíbula
            <br> 30208106 Reconstrução parcial da mandíbula com enxerto ósseo
            <br><br>
            TOTAL: R$ 50.000,00</p>

            </div>
            ';
            break;

        case '2 Maxila CustomLIFE':
            $printable = '
            <div>
            <h5><b>Maxila</b></h5>
            
            <p class="text-justify">Os procedimentos cirúrgico indicados para Sr(a) ' . $nomePaciente . '
            <br>
            Código TUSS- ROL ANS Nº 465/2021

            <br> 30208033 Osteotomias alvéolo-palatinas (1x) = 10.000,00
            <br> 30208041 Osteotomias Segmentares da maxila (1x) = 20.000,00
            <br> 30208084 Osteotomias Crânio-maxilares complexas (1x) = 20.000,00
            
            <br><br>
            TOTAL: R$ 50.000,00</p>

            </div>
            ';
            break;

        case '3 Mandibula CustomLIFE':
            $printable = '
            <div>
            <h5><b>Mandíbula</b></h5>
            
            <p class="text-justify">Os procedimentos cirúrgico indicados para Sr(a) ' . $nomePaciente . '
            <br>
            Código TUSS- ROL ANS Nº 465/2021

            <br> 30208084 Osteotomias Crânio-maxilares complexas
            <br> 30209021 Osteoplastias de mandíbula
            <br> 30208106 Reconstrução parcial da mandíbula com enxerto ósseo
            
            <br><br>
            TOTAL: R$ 50.000,00</p>

            </div>
            ';
            break;

        case '4 Enxerto ósseo Maxila':
            $printable = '
            <div>
            <h5><b>Enxerto Maxila</b></h5>
            
            <p class="text-justify">Os procedimentos cirúrgico indicados para Sr(a) ' . $nomePaciente . '
            <br>
            Código TUSS- ROL ANS Nº 465/2021

            <br> 30208033 Osteotomias alvéolo-palatinas (1x) = 10.000,00
            <br> 30208041 Osteotomias Segmentares da maxila (1x) = 20.000,00
            <br> 30208084 Osteotomias Crânio-maxilares complexas (1x) = 20.000,00
            
            <br><br>
            TOTAL: R$ 50.000,00</p>

            </div>
            ';
            break;

        case '5 Enxerto ósseo mandíbula':
            $printable = '
            <div>
            <h5><b>Enxerto Mandíbula</b></h5>
            
            <p class="text-justify">Os procedimentos cirúrgico indicados para Sr(a) ' . $nomePaciente . '
            <br>
            Código TUSS- ROL ANS Nº 465/2021

            <br> 30208033 Osteotomias alvéolo-palatinas (1x) = 10.000,00
            <br> 30208041 Osteotomias Segmentares da maxila (1x) = 20.000,00
            <br> 30208084 Osteotomias Crânio-maxilares complexas (1x) = 20.000,00
            
            <br><br>
            TOTAL: R$ 50.000,00</p>

            </div>
            ';
            break;

        case '6 Enxerto Max e Mandíbula':
            $printable = '
            <div>
            <h5><b>Enxerto Maxila e Mandíbula</b></h5>
            
            <p class="text-justify">Os procedimentos cirúrgico indicados para Sr(a) ' . $nomePaciente . '
            <br>
            Código TUSS- ROL ANS Nº 465/2021

            <br> 30208033 Osteotomias alvéolo-palatinas (1x) = 10.000,00
            <br> 30208041 Osteotomias Segmentares da maxila (1x) = 20.000,00
            <br> 30208084 Osteotomias Crânio-maxilares complexas (1x) = 20.000,00
            
            <br><br>
            TOTAL: R$ 50.000,00</p>

            </div>
            ';
            break;

        case '7 Ortognática completa':
            $printable = '
            <div>
            <h5><b>Ortognática Maxila, Mandíbula e Mento</b></h5>
            
            <p class="text-justify">Os procedimentos cirúrgico indicados para Sr(a) ' . $nomePaciente . '
            <br>
            Código TUSS- ROL ANS Nº 465/2021

            <br> 30208025 Osteoplastia para prognatismo, micrognatismo ou laterognatismo
            <br> 30208041 Osteotomias segmentares da maxila ou malar
            <br> 30208050 Osteotomia tipo Lefort I
            <br> 30208021 Osteplastia de mandíbula
            
            <br><br>
            TOTAL: R$ 40.000,00</p>

            </div>
            ';
            break;

        case '8 Levantamento de Seio Maxilar':
            $printable = '
            <div>
            <h5><b>LSM</b></h5>
            
            <p class="text-justify">Os procedimentos cirúrgico indicados para Sr(a) ' . $nomePaciente . '
            <br>
            Código TUSS- ROL ANS Nº 465/2021

            <br> Enxerto Ósseo – (3073202-6) x1
            <br> Osteotomias alvéolo-palatinas – (3020803-3) x1
            
            <br><br>
            TOTAL: R$ 30.000,00</p>

            </div>
            ';
            break;


        default:
            # code...
            break;
    }



    return $printable;
}

function pegarRefAssinaturaMedico($array)
{
    // Frederico Rodger - CRO/DF 
    // Hugo - DF
    // Elder - DF
    // Hugo - SP 
    // Frederico - SP 
    // Thiago - SP
    // Elisa - SP
    // Hugo - RJ 

    $medico = $array['dr'];

    switch ($medico) {
        case 'Frederico Rodger - CRO/DF ':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/Carimbo-Dr-Frederico-DF.png';
            break;

        case 'Frederico - SP':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/Carimbo-Dr-Frederico-SP.png';
            break;

        case 'Frederico - RJ':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/Carimbo-Dr-Frederico-RJ.png';
            break;

        case 'Hugo - SP':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/Carimbo-Hugo-SP.png';
            break;

        case 'Hugo - RJ':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/Carimb-Hugo-RJ.png';
            break;

        case 'Hugo - DF':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/Carimbo-Hugo-DF.png';
            break;

        case 'Elder - DF':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/Carimbo-Dr-Elder-DF.png';
            break;

        case 'Thiago - SP':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/Carimbo-Thiago-SP.png';
            break;

        case 'Elisa - SP':
            $urlAssMedico = 'https://www.cpmhdigital.com.br/wp-content/uploads/2023/10/elisa-SP-.png';
            break;


        default:
            # code...
            break;
    }

    return $urlAssMedico;
}

//Construindo o Documento
// $_POST = $_POST;


//Dados do Documento
$nomeMedico = pegarNomeMedico($_POST); //$_POST
$nomeCompletoMedico = pegarNomeCompletoMedico($nomeMedico);
$ufMedico = pegarUfMedico($_POST); //$_POST
$nomeDocumento = pegarNomeTipoDocumento($_POST); //$_POST
$paciente = pegarPrimeiroNomePaciente($_POST); //$_POST
$data = ajustarData($_POST); //$_POST

//Printables
$printableTipoDocumento = pegarTipoDocumento($_POST); //$_POST
$printableDescricaoProcedimento = pegarDescricaoProcedimento($_POST); //$_POST
$printableEndDocumento = pegarEndTipoDocumento($_POST); //$_POST
$printableRefAssinaturaMedico = pegarRefAssinaturaMedico($_POST); //$_POST

$cpf = $_POST['cpf28'];
$convenio = $_POST['convenio'];
$emailpaciente = $_POST['emailpaciente'];


$documentohtml = '<table class="tg">
                <thead style="background-color: gray; border: none;">
                <tr>
                    <th class="tg-f7v4">Paciente: ' . $paciente  . ' </th>
                    <th class="tg-f7v4">CPF: ' . $cpf  . '</th>
                </tr>
                <tr>
                    <td class="tg-f7v4">E-mail: ' . $emailpaciente  . '</td>
                    <td class="tg-f7v4">Convênio: ' . $convenio  . '</td>
                </tr>
                <tr>
                    <td class="tg-f7v4" colspan="2">Dr(a): ' . $nomeCompletoMedico  . '</td>
                </tr>
                </thead>
            </table>
        ' . $printableTipoDocumento  . '
        ' . $printableDescricaoProcedimento  . '
        ' . $printableEndDocumento  . '    
        <img style="width: auto; height: 100px;" src="' . $printableRefAssinaturaMedico  . '  " />
        ' . $nomeCompletoMedico  . '
        <br>
        ' . $data;


$url = 'https://hooks.zapier.com/hooks/catch/8414821/3sp7fqq/';

// $url = '';

$printableRefAssinaturaMedicoHTML = '<div class="d-flex justify-content-center">
<img style="width: auto; height: 100px;" src="' . $printableRefAssinaturaMedico  . '  " />
</div>';


//Link localhost API
$sendArray = array(
    'htmlPDF' => $documentohtml,
    'paciente' => $paciente,
    'emailpaciente' => $emailpaciente,
    'Documento' => $nomeDocumento,
    'Dr' => $nomeCompletoMedico,
    'printableTipoDocumento' => $printableTipoDocumento,
    'printableDescricaoProcedimento' => $printableDescricaoProcedimento,
    'printableEndDocumento' => $printableEndDocumento,
    'printableRefAssinaturaMedico' => $printableRefAssinaturaMedico,
    'printableRefAssinaturaMedicoHTML' => $printableRefAssinaturaMedicoHTML,
    'nomeCompletoMedico' => $nomeCompletoMedico,
    'data' => $data,
    '_POST' => $_POST

);


// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($sendArray)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */
}

// print_r($documentohtml);

// $documentohtml = '<!DOCTYPE html>
// <html lang="pt-br">

// <head>
//     <meta charset="utf-8" />
//     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
//     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
//     <meta name="description" content="" />
//     <meta name="author" content="" />
//     <title>' . $nomeDocumento . ' - ' . $paciente . '</title>
//     <!-- Bootstrap -->
//     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
//     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

//     <script src="https://kit.fontawesome.com/fc80289fa3.js" crossorigin="anonymous"></script>

// </head>

// <body class="container-fluid p-4">
//     <div class="row d-flex justify-content-center">
//         ' . $printableTipoDocumento  . '
//     </div>

//     <div class="row d-flex justify-content-center">
//         ' . $printableDescricaoProcedimento  . '
//     </div>

//     <div class="row d-flex justify-content-center">
//         ' . $printableEndDocumento  . '    
//     </div>

//     <div class="row d-flex justify-content-center">
//         <img style="width: auto; height: 100px;" src="' . $printableRefAssinaturaMedico  . '  " />
//     </div>

//     <div class="row d-flex justify-content-center">
//         <p class="py-2" style="text-align: center;">
//             ' . $nomeCompletoMedico  . '
//             <br>
//             ' . $data  . '
            
//         </p>
//     </div>
    
// </body>



// <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
// <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
// <script src="js/scripts.js"></script>
// <script src="js/standart.js"></script>

// <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
// <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
// <script src="assets/demo/datatables-demo.js"></script>
// </body>

// </html>';
