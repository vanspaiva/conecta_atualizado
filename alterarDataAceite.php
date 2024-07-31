<?php

    if(isset($_GET)){

        require "includes/dbh.inc.php";
        require "includes/functions.inc.php";
    
        $numPed = $_GET['numeroPedido'];
        $dataAceite = $_GET['dataAceite'];
        $idPedido = $_GET['idPedido'];

        /* echo "<pre>";
        print_r($_GET);
        echo "</pre>"; */
        // Conectar ao banco de dados

        // Preparar a consulta SQL
        $sql = "UPDATE `prazoproposta` SET `przData` = ? WHERE `przNumProposta` = ?";

        // Inicializar a declaração
        $stmt = mysqli_prepare($conn, $sql);

        // Verificar se a declaração foi inicializada corretamente
        if ($stmt === false) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        // Vincular parâmetros
        mysqli_stmt_bind_param($stmt, 'ss', $dataAceite, $numPed);  // 'ss' indica que ambos são strings

        // Executar a declaração
        if (mysqli_stmt_execute($stmt)) {
            echo "Registro atualizado com sucesso!";
            header("location: update-caso?id=$idPedido");
        } else {
            echo "Erro ao atualizar registro: " . mysqli_stmt_error($stmt);
        }

        // Fechar a declaração e a conexão
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }

