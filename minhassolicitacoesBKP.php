<?php
session_start();

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Doutor(a)'))) {
    include("php/head_tables.php");
?>
    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        include_once 'includes/functions.inc.php';
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
                    } else if ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Novos arquivos foram enviados com sucesso!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10" id="titulo-pag">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="text-conecta" style="font-weight: 400;">Minhas <span style="font-weight: 700;">Solicitações</span></h2>
                                <p class="text-muted">Propostas comerciais relacionadas o seu usuário</p>
                            </div>
                            <a href="solicitacao"><button class="btn btn-conecta shadow"><i class="fas fa-plus"></i> Proposta</button></a>
                        </div>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="tableProp" class="table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nº</th>
                                                <th>Data Envio</th>
                                                <th>TC</th>
                                                <th>Status</th>
                                                <th>Nome Dr</th>
                                                <th>Paciente</th>
                                                <th>Produto</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        if ($_SESSION["userperm"] == 'Distribuidor(a)') {
                                            $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
                                            while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
                                                $cnpjUser = $rowCnpj['usersCnpj'];
                                            }
                                        ?>
                                            <tbody>
                                                <?php
                                                require_once 'includes/dbh.inc.php';
                                                $ret = mysqli_query($conn, "SELECT * FROM propostas ORDER BY propId DESC");

                                                while ($row = mysqli_fetch_array($ret)) {
                                                    //cnpj da proposta deve ser igual ao cnpj do usuario
                                                    if ($row['propCnpjCpf'] == $cnpjUser) {
                                                        $dataCompleta = $row['propDataCriacao'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];
                                                        $statustc = $row['propStatusTC'];
                                                        $needle = 'REPROVADA';

                                                        $numProp = "Prop-" . $row['propId'];
                                                ?>

                                                        <tr>
                                                            <td><?php echo $numProp; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo $row['propStatusTC']; ?></td>
                                                            <td><?php echo $row['propStatus']; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>
                                                            <td>
                                                                <?php
                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                // $encrypted = urlencode($encrypted);
                                                                $encrypted = hashItemNatural($row['propId']);

                                                                if ($row['propStatus'] == 'PROP. ENVIADA') {
                                                                ?>
                                                                    <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>

                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($row['propStatus'] == 'APROVADO') {
                                                                ?>
                                                                    <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-success btn-xs"><i class="bi bi-check-lg"></i></button></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                    <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>

                                                            </td>
                                                        </tr>
                                                <?php

                                                    }
                                                }
                                                ?>

                                            </tbody>
                                        <?php } else { ?>
                                            <tbody>
                                                <?php
                                                require_once 'includes/dbh.inc.php';
                                                $ret = mysqli_query($conn, "SELECT * FROM propostas ORDER BY propId DESC");

                                                while ($row = mysqli_fetch_array($ret)) {
                                                    if ($row['propUserCriacao'] == $_SESSION["useruid"]) {
                                                        $dataCompleta = $row['propDataCriacao'];
                                                        $dataArray = explode(" ", $dataCompleta);
                                                        $data = $dataArray[0];

                                                        $statustc = $row['propStatusTC'];
                                                        $needle = 'REPROVADA';

                                                        $numProp = $row['propId'];
                                                ?>

                                                        <tr>
                                                            <td><?php echo $numProp; ?></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo $row['propStatusTC']; ?></td>
                                                            <td><?php echo $row['propStatus']; ?></td>
                                                            <td><?php echo $row['propNomeDr']; ?></td>
                                                            <td><?php echo $row['propNomePac']; ?></td>
                                                            <td><?php echo $row['propTipoProd']; ?></td>

                                                            <td>
                                                                <?php
                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                // $encrypted = urlencode($encrypted);

                                                                $encrypted = hashItemNatural($row['propId']);

                                                                if ($row['propStatus'] == 'PROP. ENVIADA') {

                                                                ?>
                                                                    <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($row['propStatus'] == 'APROVADO') {
                                                                ?>
                                                                    <a href="minhaproposta?id=<?php echo $encrypted; ?>">
                                                                        <button class="btn text-success btn-xs"><i class="bi bi-check-lg"></i></button></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                    <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>


                                                            </td>
                                                        </tr>
                                                <?php

                                                    }
                                                }
                                                ?>

                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#tableProp').DataTable({
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
    header("Location: index");
    exit();
}

    ?>