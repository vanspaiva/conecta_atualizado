<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Doutor(a)') || ($_SESSION["userperm"] == 'Distribuidor(a)') || ($_SESSION["userperm"] == 'Clínica') || ($_SESSION["userperm"] == 'Residente') || ($_SESSION["userperm"] == 'Paciente') || ($_SESSION["userperm"] == 'Dist. Comercial') || ($_SESSION["userperm"] == 'Representante') || ($_SESSION["userperm"] == 'Financeiro'))) {
    include("php/head_tables.php");

?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Nova Proposta criada com sucesso. Acomapanhe aqui suas solicitações!</p></div>";
                    } else if ($_GET["error"] == "stmfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row row-3">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <!--<h2>Minhas Solicitações</h2>-->

                        <h2 class="text-conecta" style="font-weight: 400;">Minhas <span style="font-weight: 700;">Propostas</span></h2>
                        <p class="text-muted">Acompanhe aqui os status financeiro dos aceites das suas propostas </p>
                        <hr style="border-color: #ee7624;">
                        <br>


                        <div class="card shadow">

                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="tableFin" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr style="text-align: center;">
                                                <th>Nº Proposta</th>
                                                <th>Data Aceite</th>
                                                <th>Forma Pagamento</th>
                                                <th>Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta");

                                            while ($row = mysqli_fetch_array($ret)) {
                                                //cnpj da proposta deve ser igual ao cnpj do usuario
                                                if ($row['apropNomeUsuario'] == $_SESSION["useruid"]) {
                                                    $dataCompleta = $row['apropData'];
                                                    $dataArray = explode(" ", $dataCompleta);
                                                    $data = $dataArray[0];

                                                    $aceiteID = addslashes($row['apropId']);
                                                    // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                    // $encrypted = openssl_encrypt($aceiteID, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                    // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                    // $encrypted = urlencode($encrypted);

                                                    $encrypted = hashItem($aceiteID);
                                            ?>

                                                    <tr style="text-align: center;">
                                                        <td><?php echo $row['apropNumProp']; ?></td>
                                                        <td><?php echo $data; ?></td>
                                                        <td><?php echo $row['apropFormaPgto']; ?></td>
                                                        <td><?php
                                                            if ($row['apropStatus'] == 'Aprovado') {
                                                                echo '<span class="badge bg-success text-white p-2" style="font-size: 1rem;">' . $row['apropStatus'] . '</span>';
                                                            } else if ($row['apropStatus'] == 'Reprovado') {
                                                                echo '<div class="d-flex justify-content-center">';
                                                                echo '<div class="px-2">';
                                                                echo '<span class="badge bg-danger text-white p-2" style="font-size: 1rem;">' . $row['apropStatus'] . '</span>';
                                                                echo '</div>';
                                                                echo '<div class="px-2">';
                                                                echo '<a href="editarfinanceiro?id=' . $encrypted . '"><span class="badge bg-primary text-white p-2" style="font-size: 1rem;"><i class="far fa-edit"></i></span></a>';
                                                                echo '</div>';
                                                                echo '</div>';
                                                            } else {
                                                                echo '<span class="badge bg-secondary text-white p-2" style="font-size: 1rem;">' . $row['apropStatus'] . '</span>';
                                                            }
                                                            ?></td>

                                                    </tr>
                                            <?php

                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>

                </div>

            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#tableFin').DataTable({
                    "lengthMenu": [
                        [20, 40, 80, -1],
                        [20, 40, 80, "Todos"],
                    ],
                    "language": {
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                        "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                        "lengthMenu": "Mostrar _MENU_ itens",
                        "zeroRecords": "Nenhuma proposta encontrada"
                    },
                    "order": [
                        [0, "desc"]
                    ]
                });
            });
        </script>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>