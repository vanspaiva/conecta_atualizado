<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Qualidade'))) {
    include("php/head_tables.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center py-4">

                    <div class="col-sm-10 justify-content-start">
                        <h2 class="text-conecta" style="font-weight: 400;">Histórico de <span style="font-weight: 700;">Aceites</span></h2>
                        <small class="text-muted">todos aceites de proposta</small>
                        <br>
                        <hr style="border: 1px solid #ee7624">
                        <div class="card shadow" style="overflow: scroll;">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="table" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>N° Prop</th>
                                                <th>Dr</th>
                                                <th>Pac</th>
                                                <th>Data/Hora</th>
                                                <th>Dist</th>
                                                <th>Usuário</th>
                                                <th>Rep</th>
                                                <th>Prod</th>
                                                <th>Forma Pgto</th>
                                                <th>IP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/dbh.inc.php';
                                            require_once 'includes/functions.inc.php';

                                            //     $query = "SELECT
                                            //     a.apropId AS id, 
                                            //     a.apropNumProp AS nprop, 
                                            //     p.propNomeDr AS nomeDr,
                                            //     p.propNomePac AS nomePac,
                                            //     a.apropData AS datahora, 
                                            //     u.usersName AS nomeDist,
                                            //     a.apropNomeUsuario AS user,
                                            //     p.propRepresentante AS nomeRep,
                                            //     p.propTipoProd AS produto,
                                            //     a.apropFormaPgto AS formaPgto,
                                            //     a.apropIp AS ip
                                            // FROM 
                                            //     aceiteproposta a
                                            // INNER JOIN 
                                            //     propostas p ON a.apropNumProp = p.propId
                                            // INNER JOIN 
                                            //     users u ON a.apropNomeUsuario = u.usersUid;";
                                            $query = "SELECT 
                                                    a.apropId AS id, 
                                                    a.apropNumProp AS nprop, 
                                                    p.propNomeDr AS nomeDr,
                                                    p.propNomePac AS nomePac,
                                                    MAX(a.apropData) AS datahora, 
                                                    u.usersName AS nomeDist,
                                                    a.apropNomeUsuario AS user,
                                                    p.propRepresentante AS nomeRep,
                                                    p.propTipoProd AS produto,
                                                    a.apropFormaPgto AS formaPgto,
                                                    a.apropIp AS ip
                                                FROM 
                                                    aceiteproposta a
                                                INNER JOIN 
                                                    propostas p ON a.apropNumProp = p.propId
                                                INNER JOIN 
                                                    users u ON a.apropNomeUsuario = u.usersUid
                                                GROUP BY 
                                                    a.apropNumProp;";

                                            $ret = mysqli_query($conn, $query);

                                            while ($row = mysqli_fetch_array($ret)) {

                                                $idref = $row["id"];
                                                $nprop = $row['nprop'];
                                                $nomeDr = $row['nomeDr'];
                                                $nomePac = $row['nomePac'];
                                                $datahora = $row['datahora'];
                                                $nomeDist = $row['nomeDist'];
                                                $user = $row['user'];
                                                $nomeRep = $row['nomeRep'];
                                                $produto = $row['produto'];
                                                $formaPgto = $row["formaPgto"];
                                                $ip = $row["ip"];

                                            ?>

                                                <tr>
                                                    <td><?php echo $idref; ?></td>
                                                    <td class="d-flex align-items-center">
                                                        <b><?php echo $nprop; ?></b>
                                                        <a class="mx-1" href="proposta?id=<?php echo $nprop; ?>">
                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                    </td>
                                                    <td><?php echo $nomeDr; ?></td>
                                                    <td><?php echo $nomePac; ?></td>
                                                    <td><?php echo $datahora; ?></td>
                                                    <td><?php echo $nomeDist; ?></td>
                                                    <td><?php echo $user; ?></td>
                                                    <td><?php echo $nomeRep; ?></td>
                                                    <td><?php echo $produto; ?></td>
                                                    <td><?php echo $formaPgto; ?></td>
                                                    <td><?php echo $ip; ?></td>

                                                </tr>
                                            <?php
                                            } ?>

                                        </tbody>
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
                $('#table').DataTable({
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