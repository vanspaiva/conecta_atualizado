<?php

function countTecnicosCasosGERAL($conn)
{
    $arrayTecnicos = array();

    $sql = "SELECT `pedTecnico` as 'tecnico', usersName as 'nome', COUNT(*) as 'qtd' FROM pedido p INNER JOIN users u ON p.pedTecnico = u.usersUid WHERE NOT `pedStatus` IN ('Arquivado (+90 dias)', 'PROD', 'ENVIADO', 'Retrabalho') GROUP BY pedTecnico;";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            array_push($arrayTecnicos, $row_user);
        }
        return $arrayTecnicos;
    } else {
        return false;
    }
}

function getAllTecnico($conn)
{
    $arrayTecnicos = array();

    $sql = "SELECT `pedTecnico` as 'tecnico' FROM pedido WHERE NOT `pedStatus` IN ('Arquivado (+90 dias)', 'PROD', 'ENVIADO', 'Retrabalho') GROUP BY `pedTecnico`;";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            array_push($arrayTecnicos, $row_user["tecnico"]);
        }
        return $arrayTecnicos;
    } else {
        return false;
    }
}

function getAllStatusFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedTecnico` = '$tecnico' AND NOT `pedStatus` IN ('Arquivado (+90 dias)', 'PROD', 'ENVIADO', 'Retrabalho') GROUP BY `pedStatus`;";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            array_push($arrayPedido, $row_user);
        }

        return $arrayPedido;
    } else {
        return false;
    }
}

function getAllStatusConcluidoFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT 
    `pedStatus` as 'status', 
    COUNT(*) as 'qtd' 
    FROM pedido WHERE `pedTecnico` = '$tecnico' 
    AND `pedStatus` IN ('PROD', 'ENVIADO', 'Retrabalho') 
    GROUP BY `pedStatus`;";

    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            array_push($arrayPedido, $row_user);
        }

        return $arrayPedido;
    } else {
        return false;
    }
}


function getAllArquivados($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('Arquivado (+90 dias)');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllConcluidos($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('PROD', 'ENVIADO', 'Retrabalho');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllPlanejando($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('PLAN', 'PDF', 'PROJ', 'Pré Planejamento', 'Segmentação');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllAfazer($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('Projeto Aceito', 'Solicitação de Alteração', 'CRIADO');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllPendentes($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('Vídeo Agendada', 'VIDEO', 'ACEITE', 'Aguardando info/Docs', 'Avaliar Projeto');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllProjetistaProximo($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('CRIADO');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllPCP($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('PCP');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllArquivadosFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedTecnico` = '$tecnico' AND `pedStatus` IN ('Arquivado (+90 dias)');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}
function getAllConcluidosFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedTecnico` = '$tecnico' AND `pedStatus` IN ('PROD', 'ENVIADO', 'Retrabalho');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}
function getAllPlanejandoFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedTecnico` = '$tecnico' AND `pedStatus` IN ('PLAN', 'PDF', 'PROJ', 'Pré Planejamento', 'Segmentação');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}
function getAllPendentesFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedTecnico` = '$tecnico' AND `pedStatus` IN ('Vídeo Agendada', 'VIDEO', 'ACEITE', 'Aguardando info/Docs', 'Avaliar Projeto');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllAfazerFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedTecnico` = '$tecnico' AND `pedStatus` IN ('Projeto Aceito', 'Solicitação de Alteração', 'CRIADO');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
} 

function getAllProjetistaProximoFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedTecnico` = '$tecnico' AND `pedStatus` IN ('CRIADO');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllPCPFromTecnico($conn, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedTecnico` = '$tecnico' AND `pedStatus` IN ('PCP');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function listarCasosFromTecnico($conn, $status, $tecnico)
{
    $arrayPedido = array();

    $sql = "SELECT `pedNumPedido` as 'numero' FROM pedido WHERE `pedTecnico` = '$tecnico' AND `pedStatus` IN ($status);";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            array_push($arrayPedido, $row_user['numero']);         
        }

        return $arrayPedido;

    } else {

        return false;

    }
}

function listarCasos($conn, $status)
{
    $arrayPedido = array();

    $sql = "SELECT `pedNumPedido` as 'numero' FROM pedido WHERE `pedStatus` IN ($status);";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            array_push($arrayPedido, $row_user['numero']);         
        }

        return $arrayPedido;

    } else {

        return false;

    }
}

