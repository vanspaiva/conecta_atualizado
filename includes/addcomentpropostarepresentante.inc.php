<?php
if (isset($_POST["submit"])) {

    $propid = addslashes($_POST["propid"]);
    $comentario = addslashes($_POST["comentario"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    adicionarComentarioPropostaRepresentante($conn, $propid, $comentario);

} else {
    header("location: ../solicitacoes");
    exit();
}
