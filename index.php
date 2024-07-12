<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

if (isset($_SESSION["useruid"])) {
    $user = $_SESSION["useruid"];
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    include("php/head_tables.php");

?>


    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        // include_once 'dashboard/dashComponents/popup.comp.php';
        ?>

        <?php
        if ($_SESSION["userperm"] == 'Administrador') {
            include_once("dashboard/dash-administrador.php");
        } else if ($_SESSION["userperm"] == 'Adm Comercial') {
            include_once("dashboard/dash-administrador.php");
        } else if ($_SESSION["userperm"] == 'Analista Dados') {
            include_once("dashboard/dash-analista.php");
        } else if ($_SESSION["userperm"] == 'Clínica') {
            include_once("dashboard/dash-X.php");
        } else if ($_SESSION["userperm"] == 'Comercial') {
            include_once("dashboard/dash-comercial.php");
        } else if ($_SESSION["userperm"] == 'Distribuidor(a)') {
            include_once 'dashboard/dashComponents/popup.comp.php';
            include_once("dashboard/dash-distribuidor.php");
        } else if ($_SESSION["userperm"] == 'Dist. Comercial') {
            include_once 'dashboard/dashComponents/popup.comp.php';
            include_once("dashboard/dash-distribuidor-comercial.php");
        } else if ($_SESSION["userperm"] == 'Doutor(a)') {
            include_once 'dashboard/dashComponents/popup.comp.php';
            include_once("dashboard/dash-doutor.php");
        } else if ($_SESSION["userperm"] == 'Representante') {
            include_once("dashboard/dash-representante.php");
        } else if ($_SESSION["userperm"] == 'Planejador(a)') {
            include_once("dashboard/dash-planejamento.php");
        } else if ($_SESSION["userperm"] == 'Planej. Ortognática') {
            include_once("dashboard/dash-planejamento-ortog.php");
        } else if ($_SESSION["userperm"] == 'Qualidade') {
            include_once("dashboard/dash-qualidade.php");
        } else if ($_SESSION["userperm"] == 'Marketing') {
            include_once("dashboard/dash-X.php");
        } else if ($_SESSION["userperm"] == 'Financeiro') {
            include_once("dashboard/dash-financeiro.php");
        } else if ($_SESSION["userperm"] == 'Residente') {
            include_once("dashboard/dash-X.php");
        } else if ($_SESSION["userperm"] == 'Paciente') {
            include_once("dashboard/dash-X.php");
        } else if ($_SESSION["userperm"] == 'Fábrica') {
            include_once("dashboard/dash-fabrica.php");
        } else {
            include_once("dashboard/dash-X.php");
        }

        ?>


    </body>


    <!-- GetButton.io widget -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
    <script type="text/javascript">
        (function() {
            var options = {
                whatsapp: "+55 61 99965-8880", // WhatsApp number
                call_to_action: "Enviar uma mensagem", // Call to action
                position: "right", // Position may be 'right' or 'left'
                pre_filled_message: "Olá! Vim do Conecta 2.0, estou precisando de ajuda", // WhatsApp pre-filled message
            };
            var proto = document.location.protocol,
                host = "getbutton.io",
                url = proto + "//static." + host;
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url + '/widget-send-button/js/init.js';
            s.onload = function() {
                WhWidgetSendButton.init(host, proto, options);
            };
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        })();

        $(document).ready(function() {
            document.getElementById("mySidenav").style.width = "200px";
        });
    </script>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous" defer></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous" defer></script>
    <!-- <script src="assets/demo/datatables-demo.js"></script> -->
    <?php include_once 'php/footer_index.php' ?>
<?php
} else {
    header("location: login");
    exit();
}
?>