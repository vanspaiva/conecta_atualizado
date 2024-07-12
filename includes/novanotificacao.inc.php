<?php
ob_start();

// if (isset($_POST["enviar"])) {

//     // set the default timezone to use.
//     date_default_timezone_set('UTC');
//     $dtz = new DateTimeZone("America/Sao_Paulo");
//     $dt = new DateTime("now", $dtz);
//     $data = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");
//     $user = $_SESSION['useruid'];

//     $tipoNotific = addslashes($_POST['tipoNotific']);

//     $template = addslashes($_POST['template']);
//     $titulo = addslashes($_POST['titulo']);
//     $texto = addslashes($_POST['texto']);
//     $texto = htmlspecialchars($texto);

//     require_once 'dbh.inc.php';
//     require_once 'functions.inc.php';

//     if ($tipoNotific == "email") {
//         addNotificacaoEmail($conn, $template, $titulo, $texto, $data, $user);
//     } else {

//         addNotificacaoWpp($conn, $template, $titulo, $texto, $data, $user);
//     }
// } else 
if (isset($_POST["update"])) {

    $id = addslashes($_POST['id']);

    // set the default timezone to use.
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $data = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");
    $user = $_SESSION['useruid'];

    $tipoNotific = addslashes($_POST['tipoNotific']);

    $template = addslashes($_POST['template']);
    $titulo = addslashes($_POST['titulo']);
    $destinatario = addslashes($_POST['destinatario']);
    $texto = addslashes($_POST['texto']);
    $texto = htmlspecialchars($texto);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if ($tipoNotific == "email") {
        updateNotificacaoEmail($conn, $id, $template, $titulo, $destinatario, $texto, $data, $user);
    } else {

        updateNotificacaoWpp($conn, $id, $template, $titulo, $destinatario, $texto, $data, $user);
    }
} else if (isset($_POST["novobanco"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addBancoNotificacao($conn, $nome);

} else if (isset($_POST["novomarcador"])) {

    $banco = addslashes($_POST['banco']);
    $nome = addslashes($_POST['nome']);
    $variavel = addslashes($_POST['variavel']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addMarcadorNotificacao($conn, $banco, $nome, $variavel);
    
} 