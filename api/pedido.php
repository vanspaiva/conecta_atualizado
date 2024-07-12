<?php
require_once("../includes/dbh.inc.php");

// Verifica qual endpoint foi requisitado
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['r']) && $_GET['r'] === 'all') {
        // Retorna todos os pedidos
        // $query = "SELECT `pedId`, `pedNumPedido`, `pedPropRef`, `pedUserCriador`, `pedRep`, `pedSharedUsers`, `pedNomeDr`, `pedNomePac`, `pedCrmDr`, `pedProduto`, `pedTipoProduto`, `pedStatus`, `pedPosicaoFluxo`, `pedDtCriacaoPed`, `pedAbaAgenda`, `pedAbaVisualizacao`, `pedAbaAceite`, `pedAbaRelatorio`, `pedAbaDocumentos`, `pedAndamento`, `pedCpfCnpj`, `pedTecnico`, `pedObservacao`, `pedDocsFaltantes`, `loteop` FROM `pedido`";
        $query = "SELECT p.pedId, p.pedNumPedido, p.pedPropRef, p.pedUserCriador, p.pedRep, p.pedSharedUsers, p.pedNomeDr, p.pedNomePac, p.pedCrmDr, p.pedProduto, p.pedTipoProduto, p.pedStatus, p.pedPosicaoFluxo, p.pedDtCriacaoPed, p.pedAbaAgenda, p.pedAbaVisualizacao, p.pedAbaAceite, p.pedAbaRelatorio, p.pedAbaDocumentos, p.pedAndamento, p.pedCpfCnpj, p.pedTecnico, p.pedObservacao, p.pedDocsFaltantes, p.loteop, s.stpedId, s.stpedNome, s.stpedIndiceFluxo, s.stpedValue, s.stpedPosicao, s.stpedAndamento, s.stpedCalcularDtPrazo, s.stpedCorBg, s.stpedCorTexto FROM pedido p JOIN statuspedido s ON p.pedStatus = s.stpedValue";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            // Fetch all rows as an associative array
            $pedidos = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            // Handle the error
            echo "Error: " . mysqli_error($conn);
        }

        header('Content-Type: application/json');
        echo json_encode($pedidos);
        exit;
    } elseif ((isset($_GET['r']) && $_GET['r'] === 'numpedido') && (isset($_GET['id']))) {
        // Retorna um pedido específico
        $id = $_GET['id'];
        // $query = "SELECT `pedId`, `pedNumPedido`, `pedPropRef`, `pedUserCriador`, `pedRep`, `pedSharedUsers`, `pedNomeDr`, `pedNomePac`, `pedCrmDr`, `pedProduto`, `pedTipoProduto`, `pedStatus`, `pedPosicaoFluxo`, `pedDtCriacaoPed`, `pedAbaAgenda`, `pedAbaVisualizacao`, `pedAbaAceite`, `pedAbaRelatorio`, `pedAbaDocumentos`, `pedAndamento`, `pedCpfCnpj`, `pedTecnico`, `pedObservacao`, `pedDocsFaltantes`, `loteop` FROM `pedido` WHERE `pedNumPedido` = $id";
        $query = "SELECT p.pedId, p.pedNumPedido, p.pedPropRef, p.pedUserCriador, p.pedRep, p.pedSharedUsers, p.pedNomeDr, p.pedNomePac, p.pedCrmDr, p.pedProduto, p.pedTipoProduto, p.pedStatus, p.pedPosicaoFluxo, p.pedDtCriacaoPed, p.pedAbaAgenda, p.pedAbaVisualizacao, p.pedAbaAceite, p.pedAbaRelatorio, p.pedAbaDocumentos, p.pedAndamento, p.pedCpfCnpj, p.pedTecnico, p.pedObservacao, p.pedDocsFaltantes, p.loteop, s.stpedId, s.stpedNome, s.stpedIndiceFluxo, s.stpedValue, s.stpedPosicao, s.stpedAndamento, s.stpedCalcularDtPrazo, s.stpedCorBg, s.stpedCorTexto FROM pedido p JOIN statuspedido s ON p.pedStatus = s.stpedValue WHERE `pedNumPedido` = $id";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            // Fetch all rows as an associative array
            $pedido = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            // Handle the error
            echo "Error: " . mysqli_error($conn);
        }

        if (!$pedido) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Pedido não encontrado']);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode($pedido);
        exit;
    } elseif (isset($_GET['pedido']) && $_GET['pedido'] === 'prz' && isset($_GET['id'])) {
        // Retorna o prazo calculado
        $numPedOG = $_GET['id'];
        $dataPrazoContada = "-"; // Valor padrão caso algo dê errado

        $retPrzStatus = mysqli_query($conn, "SELECT *, DATEDIFF(now(),`przData`) as dataContada FROM prazoproposta WHERE przNumProposta='" . $numPedOG . "'  AND przStatus='Projeto Aceito' ORDER BY przId DESC LIMIT 1;");

        if ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
            // Verifique se as chaves existem antes de usá-las
            if (isset($rowPrzStatus["przStatus"]) && isset($rowPrzStatus["przData"])) {
                $przStatus = $rowPrzStatus["przStatus"];
                $przData = $rowPrzStatus["przData"];
                $dataCalculada = strtotime($przData . "+ 20 weekdays");
                $dataCalculada = date("d/m/Y", $dataCalculada);

                $ret = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$przStatus'");
                if ($row = mysqli_fetch_array($ret)) {
                    if (isset($row["stpedCalcularDtPrazo"])) {
                        $calc = $row["stpedCalcularDtPrazo"];
                        if ($calc == true) {
                            $dataPrazoContada = $dataCalculada;
                        }
                    }
                }
            }
        }

        // Retorna a resposta como JSON
        header('Content-Type: application/json');
        echo json_encode(['dataPrazoContada' => $dataPrazoContada]);
        exit;
    } elseif (isset($_GET['id'])) {
        // Retorna um pedido específico
        $id = $_GET['id'];
        $query = "SELECT `pedId`, `pedNumPedido`, `pedPropRef`, `pedUserCriador`, `pedRep`, `pedSharedUsers`, `pedNomeDr`, `pedNomePac`, `pedCrmDr`, `pedProduto`, `pedTipoProduto`, `pedStatus`, `pedPosicaoFluxo`, `pedDtCriacaoPed`, `pedAbaAgenda`, `pedAbaVisualizacao`, `pedAbaAceite`, `pedAbaRelatorio`, `pedAbaDocumentos`, `pedAndamento`, `pedCpfCnpj`, `pedTecnico`, `pedObservacao`, `pedDocsFaltantes`, `loteop` FROM `pedido` WHERE `pedId` = $id";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            // Fetch all rows as an associative array
            $pedido = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            // Handle the error
            echo "Error: " . mysqli_error($conn);
        }

        if (!$pedido) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Pedido não encontrado']);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode($pedido);
        exit;
    }
}

// Se o endpoint de atualização foi chamado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['r']) && $_GET['r'] === 'update' && isset($_GET['id'])) {
        $id = $_GET['id'];
        // Aqui você deve processar a atualização do pedido com o ID fornecido
        // Isso é apenas um exemplo
        header('Content-Type: application/json');
        echo json_encode(['message' => "Pedido com ID $id atualizado com sucesso"]);
        exit;
    }
}

// Se nenhum endpoint válido foi chamado
header('Content-Type: application/json');
echo json_encode(['error' => 'Endpoint inválido']);
