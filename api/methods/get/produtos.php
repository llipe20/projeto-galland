<?php 

    function getProdutos($id) {
        global $conn;

        $sqlProdutos = "SELECT * FROM produtos";
        $sqlAdicionais = "SELECT * FROM adicionais";

        if ($id !== '') {
            $sqlProdutos .= " WHERE id = $id";
            $sqlAdicionais .= " WHERE id = $id";
        }

        // Executa as consultas
        $resultProdutos = mysqli_query($conn, $sqlProdutos);
        $resultAdicionais = mysqli_query($conn, $sqlAdicionais);

        if (!$resultProdutos || !$resultAdicionais) {
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(['error' => 'Erro ao obter produtos e adicionais']);
            return;
        } else {
            $produtos = array(
                'produtos' => array(),
                'adicionais' => array()
            );

            while ($row = mysqli_fetch_assoc($resultProdutos)) {
                $produtos['produtos'][] = $row;
            }

            while ($row = mysqli_fetch_assoc($resultAdicionais)) {
                $produtos['adicionais'][] = $row;
            }

            header('Content-Type: application/json');
            echo json_encode($produtos, JSON_PRETTY_PRINT);
        }
    }
?>