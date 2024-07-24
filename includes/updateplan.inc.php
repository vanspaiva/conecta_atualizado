<?php

/* echo "<pre>";
print_r($_POST);
echo "</pre>";
exit(); */

if (isset($_POST["update"])) {

    $statustc = addslashes($_POST['statustc']);
    $id = addslashes($_POST['propid']);

    if (empty($_POST["textReprov"])) {
        $textReprov = null;
    } else {
        $textReprov = addslashes($_POST['textReprov']);
    }

    if (empty($_POST["projetista"])) {
        $projetista = null;
    } else {
        $projetista = addslashes($_POST['projetista']);
    }

    $filename1 = addslashes($_POST["filename1"]);
    $cdnurl1 = addslashes($_POST["cdnurl1"]);

    $filename2 = addslashes($_POST["filename2"]);
    $cdnurl2 = addslashes($_POST["cdnurl2"]);

    $arquivos = array();

    if (!empty($_POST["tcCheck"])) {
        $tcCheck = addslashes($_POST["tcCheck"]);
        array_push($arquivos, $tcCheck);
    } else {
        $tcCheck = null;
    }

    if (!empty($_POST["laudoCheck"])) {
        $laudoCheck = addslashes($_POST["laudoCheck"]);
        array_push($arquivos, $laudoCheck);
    } else {
        $laudoCheck = null;
    }

    if (!empty($_POST["modeloCheck"])) {
        $modeloCheck = addslashes($_POST["modeloCheck"]);
        array_push($arquivos, $modeloCheck);
    } else {
        $modeloCheck = null;
    }

    if (!empty($_POST["imagemCheck"])) {
        $imagemCheck = addslashes($_POST["imagemCheck"]);
        array_push($arquivos, $imagemCheck);
    } else {
        $imagemCheck = null;
    }


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if($textReprov != null){

        $nprop = addslashes($_POST["nprop2"]);
        $user = addslashes($_POST["user2"]);
        addComentProp($conn, $textReprov, $nprop, $user);


      /*   function getUserName($conn,$user){
            $searchUserName = mysqli_query($conn, "SELECT * FROM `users` WHERE usersUid = $user;");
            while ($row = mysqli_fetch_array($searchUserName)) {
                $user = $row['usersUid'];
            }
        
            return $user;
        }

        $userName = getUserName($conn,$user);


        $url = 'https://webhooks.integrately.com/a/webhooks/2588bdf5b0b44c1e8a144366f688d28d';

        $data = array(
            'Num Projeto' => $nprop,
            'Usuário' => $userName,
            'comentário' => $textReprov
        );
    
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { 
            
        } */
    
    }

    //uploadArquivoRefTC($conn, $tnameA, $pnameA, $tnameB, $pnameB, $id);

    editPropPlan($conn, $id, $statustc, $textReprov, $projetista, $filename1, $cdnurl1, $filename2, $cdnurl2, $arquivos);
} else {
    header("location: ../planejamento");
    exit();
}
