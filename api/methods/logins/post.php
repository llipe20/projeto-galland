<?php 
    function createLogin($data) {
        global $conn;

        $nome = mysqli_escape_string($conn, $data['nome']);
        $email = mysqli_escape_string($conn, $data['email']);
        $senha = mysqli_escape_string($conn, $data['senha']);

        $sql = "INSERT INTO login VALUES (DEFAULT, '$nome', '$email', '$senha')";

        if (mysqli_query($conn, $sql)) {
            $response = array('message' => 'Usuario criado com sucesso.');
            http_response_code(201); 
        } else {
            $response = array('error' => 'Erro ao criar usuario: ' . mysqli_error($conn));
            http_response_code(500); 
        }

        echo json_encode($response);
        mysqli_close($conn);
    }
?>