<?php
session_start();
if (isset($_GET["id"])) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';

?>

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';
            ?>

            <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
            <script src="https://cdn.tiny.cloud/1/zjf2h1vx7aqnqpv1gai59eeqiqb64jvhdg2tfv34o6i9i7lm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                tinymce.init({
                    selector: 'textarea',
                    plugin: 'a_tinymce_plugin',
                    a_plugin_option: true,
                    a_configuration_option: 400,
                    height: 400,
                    content_style: "body { color: black; }"
                });
            </script>

            <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
            <div id="main" class="font-montserrat">

                <div class="container-fluid">
                    <div class="row py-4 d-flex justify-content-center">
                        <div class="col-sm-10" id="titulo-pag">
                            <div class="row d-flex justify-content-start">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                        <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-11 pt-2 row-padding-2">
                                    <div class="row px-3">
                                        <h2 class="text-white">Editar Notificação</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- <h2>Informações do Produto</h2> -->
                            <br>
                            <div class="card">

                                <div class="card-body">
                                    <?php
                                    $type = addslashes($_GET['type']);
                                    $id = addslashes($_GET['id']);

                                    if ($type == "email") {
                                        $result = "SELECT * FROM notificacoesexternasemail WHERE ntfEmailId =" . $id . ";";
                                        $resultado = mysqli_query($conn, $result);
                                        if (($resultado) and ($resultado->num_rows != 0)) {
                                            while ($row = mysqli_fetch_assoc($resultado)) {
                                                $id = $row['ntfEmailId'];
                                                $template = $row['ntfEmailNomeTemplate'];
                                                $titulo = $row['ntfEmailAssuntoEmail'];
                                                $texto = $row['ntfEmailTexto'];
                                                $destinatario = $row['ntfEmailDestinatario'];
                                            }
                                        }
                                    } else {
                                        $result = "SELECT * FROM notificacoesexternaswpp WHERE ntfWppId =" . $id . ";";
                                        $resultado = mysqli_query($conn, $result);
                                        if (($resultado) and ($resultado->num_rows != 0)) {
                                            while ($row = mysqli_fetch_assoc($resultado)) {
                                                $id = $row['ntfWppId'];
                                                $template = $row['ntfWppNomeTemplate'];
                                                $titulo = $row['ntfWppTitulo'];
                                                $texto = htmlspecialchars_decode($row['ntfWppTexto']);
                                                $destinatario = $row['ntfWppDestinatario'];
                                            }
                                        }
                                    }
                                    ?>
                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="content-panel">

                                                        <form action="includes/novanotificacao.inc.php" method="POST">
                                                            <div class="form-row p-2 border rou rounded bg-light pt-4" hidden>
                                                                <div class="form-group col-md">
                                                                    <label for="tipoNotific" class="text-black">Tipo <b style="color: red;">*</b> </label>
                                                                    <input type="text" class="form-control" id="tipoNotific" name="tipoNotific" value="<?php echo $type; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-row pt-3" hidden>
                                                                <div class="form-group col-md">
                                                                    <label for="id" class="text-black">ID <b style="color: red;">*</b> </label>
                                                                    <input type="text" class="form-control" id="idUpdate" name="id" value="<?php echo $id; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-row pt-3">
                                                                <div class="form-group col-md">
                                                                    <label for="template" class="text-black">Nome Template <b style="color: red;">*</b> </label>
                                                                    <input type="text" class="form-control" id="templateUpdate" name="template" value="<?php echo $template; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label for="titulo" class="text-black">Assunto / Título <b style="color: red;">*</b> </label>
                                                                    <input type="text" class="form-control" id="tituloUpdate" name="titulo" value="<?php echo $titulo; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md">
                                                                    <label for="destinatario" class="text-black">Destinatário <b style="color: red;">*</b> </label>
                                                                    <input type="text" class="form-control" id="destinatario" name="destinatario" value="<?php echo $destinatario; ?>" required>
                                                                    <small>Utilize alguma tag de tipo [nome] ou [sistema]</small>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md">
                                                                    <label for="texto" class="text-black">Texto<b style="color: red;">*</b> </label>
                                                                    <textarea class="form-control text-black" name="texto" id="textoUpdate"><?php echo $texto; ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" name="update" class="btn btn-primary">Salvar</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </section>

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