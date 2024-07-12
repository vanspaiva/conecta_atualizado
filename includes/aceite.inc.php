<?php
// if (isset($_POST["aceitar"])) {

//     $opAceite = addslashes($_POST['op-aceite']);
//     $projeto = addslashes($_POST['projeto']);
    
//     if (empty($_POST["coment-txt-aceite"])) {
//         $coment = null;
//     } else { 
//         $coment = addslashes($_POST['coment-txt-aceite']);
//     }

//     switch ($opAceite) {
//         case '1':
//             $respAceite = 'Aceito';
//             break;

//         case '0':
//             $respAceite = 'Não Aceito';
//             break;

//         default:
//         $respAceite = 'undefined';
//         break;
//             break;
//     }


//     require_once 'dbh.inc.php';
//     require_once 'functions.inc.php';

//     updateAceite($conn, $projeto, $respAceite, $coment);

// } else{
//     header("location: ../casos");
//     exit();
// } 

 session_start();
if (isset($_POST["aceitar"])) {

    $opAceite = addslashes($_POST['op-aceite']);
    $projeto = addslashes($_POST['projeto']);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $id = deshashItemNatural($projeto);

    if (empty($_POST["coment-txt-aceite"])) {
        $coment = null;
    } else {
        $coment = addslashes($_POST['coment-txt-aceite']);
    }

    switch ($opAceite) {
        case '1':
            $respAceite = 'Projeto Aceito';
            
            $abaAberta = 'liberado';
            $abaFechada = 'fechado';

            $casoId = getIdFromPed($conn, $id);

            $abas = array(
                'casoId' => $casoId,
                'numped' => $id,
                'documentos' => $abaAberta,
                'agendar' => $abaFechada,
                'aceite' => $abaFechada,
                'relatorios' => $abaFechada,
                'visualizacao' => $abaAberta
            );

            liberarAbas($conn, $abas);
            break;

        case '0':
            $respAceite = 'Solicitação de Alteração';
            
            $abaAberta = 'liberado';
            $abaFechada = 'fechado';

            $casoId = getIdFromPed($conn, $id);

            $abas = array(
                'casoId' => $casoId,
                'numped' => $id,
                'documentos' => $abaAberta,
                'agendar' => $abaFechada,
                'aceite' => $abaAberta,
                'relatorios' => $abaFechada,
                'visualizacao' => $abaAberta
            );

            liberarAbas($conn, $abas);
            break;

        default:
           $urlid = hashItemNatural($id);
            $respAceite = 'undefined';
            header("location: ../unit?id=" . $urlid . "&error=formundefined");
            exit();
            break;
    }


    updateAceite($conn, $id, $respAceite, $coment);
} else {
    header("location: ../casos");
    exit();
}
