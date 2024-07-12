<?php ob_start();
include("php/head_index.php");
require_once 'includes/dbh.inc.php';

// $url_array = explode('?', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// $url = $url_array[0];

// require_once 'google-api-php-client/src/Google_Client.php';
// require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
// $client = new Google_Client();

// $client->setHttpClient($guzzle);
// $client->setClientId('148367130103-94h26uah9273q0fnvl74ojpqevim2vrd.apps.googleusercontent.com');
// $client->setClientSecret('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');
// $client->setRedirectUri($url);
// $client->setScopes(array('https://www.googleapis.com/auth/drive'));
// if (isset($_GET['code'])) {
//     $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
//     header('location:' . $url);
//     exit;
// } elseif (!isset($_SESSION['accessToken'])) {
//     $client->authenticate();
// }
// $files = array();
// $dir = dir('files');
// while ($file = $dir->read()) {
//     if ($file != '.' && $file != '..') {
//         $files[] = $file;
//     }
// }
// $dir->close();
// if (!empty($_POST)) {
//     $client->setAccessToken($_SESSION['accessToken']);
//     $service = new Google_DriveService($client);
//     $finfo = finfo_open(FILEINFO_MIME_TYPE);
//     $file = new Google_DriveFile();
//     foreach ($files as $file_name) {
//         $file_path = 'files/' . $file_name;
//         $mime_type = finfo_file($finfo, $file_path);
//         $file->setTitle($file_name);
//         $file->setDescription('This is a ' . $mime_type . ' document');
//         $file->setMimeType($mime_type);
//         $service->files->insert(
//             $file,
//             array(
//                 'data' => file_get_contents($file_path),
//                 'mimeType' => $mime_type
//             )
//         );
//     }
//     finfo_close($finfo);
//     header('location:' . $url);
//     exit;
// }


// $url_array = explode('?', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// $url = $url_array[0];

// require_once 'google-api-php-client/src/Google_Client.php';
// require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
// $client = new Google_Client();


// $client->setClientId('148367130103-94h26uah9273q0fnvl74ojpqevim2vrd.apps.googleusercontent.com');
// $client->setClientSecret('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');
// $client->setRedirectUri($url);
// $client->setScopes(array('https://www.googleapis.com/auth/drive'));
// if (isset($_GET['code'])) {
//     $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
//     header('location:' . $url);
//     exit;
// } elseif (!isset($_SESSION['accessToken'])) {
//     $client->authenticate();
// }
// $files = array();
// $dir = dir('arquivos/signatures');
// while ($file = $dir->read()) {
//     if ($file != '.' && $file != '..') {
//         $files[] = $file;
//     }
// }
// $dir->close();
// if (!empty($_POST)) {
//     $client->setAccessToken($_SESSION['accessToken']);
//     $service = new Google_DriveService($client);
//     $finfo = finfo_open(FILEINFO_MIME_TYPE);
//     $file = new Google_DriveFile();
//     foreach ($files as $file_name) {
//         $file_path = 'arquivos/signatures/' . $file_name;
//         $mime_type = finfo_file($finfo, $file_path);
//         $file->setTitle($file_name);
//         $file->setParents(array("1rle4uAiT8Anp50976sgyFuJra80HF8ha"));
//         $file->setDescription("Arquivo carregado ao Drive");
//         $file->setMimeType($mime_type);
//         $service->files->insert(
//             $file,
//             array(
//                 'data' => file_get_contents($file_path),
//                 'mimeType' => $mime_type
//             )
//         );

//     }
//     finfo_close($finfo);
//     header('location:' . $url);
//     exit;
// }

if (isset($_SESSION["useruid"])) {

?>

    <body class="bg-conecta">

        <?php
        include_once 'php/navbar.php';
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
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Nova Proposta criada</p></div>";
                    } else if ($_GET["error"] == "fileerror") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Erro ao fazer upload do arquivo. Tente novamente!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">

                <div class="col-sm-12 mx-2 justify-content-start">
                    <div class="card">
                        <div class="card-head"></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-1" style="color: #212529;"><?php include_once 'php/back.php';
                                                                                define_button_color('special'); ?></div>
                                <div class="col-sm-4 pt-2 row-padding-2">
                                    <div class="row px-3">
                                        <h4 class="font-weight-semibold">Solicitação de Proposta</h4>
                                        <p style="color: #ee7624; text-align: center;">Atenção! Certifique-se de adicionar a TC <span style="text-decoration: underline; font-weight: bold;">antes</span> de enviar sua proposta!</p>
                                    </div>
                                </div>
                                <div class="col-sm-7 pt-2 row-padding-2">
                                    <!-- <div class="progress">
                                        <div id="formCaseProgress" class="progress-bar progress-bar-striped active progress-bar-animated" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                                    </div> -->

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 mx-2 py-4 justify-content-start">
                    <div class="card">
                        <div class="card-body">
                            <div id="card-new-case"></div>
                            <?php include_once "php/form.casos.php" ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        </div>


        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/setProdutoComplemento.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/menu.js"></script>






    </body>

    </html>


<?php

} else {
    header("location: login");
    exit();
}

?>