<?php 
    function getLogin($id) {
        global $conn;

        if($id == '') {
            header("HTTP/1.0 405 Rota não encontrada");
            echo json_encode(['error' => 'Precisa-se do parametro id do usuario']);
            return;
        }

        $sql = "SELECT * FROM login WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(['error' => 'Erro ao obter dados de login']);
            return;
        } else {
            $login = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $login[] = $row;
            }
            // Enviando dados
            header('Content-Type: application/json');
            echo json_encode($login, JSON_PRETTY_PRINT);
            mysqli_close($conn);
        }
    }
?>