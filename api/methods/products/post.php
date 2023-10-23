<?php 
    function createProdutc($data) {
        global $conn;

        $nome = mysqli_escape_string($conn, $data['nome']);
        $tipo = mysqli_escape_string($conn, $data['tipo']);
        $valor = mysqli_escape_string($conn, $data['valor']);
        $estoque = mysqli_escape_string($conn, $data['estoque']);
        $imagem = mysqli_escape_string($conn, $data['imagem']);

        if($data['table'] == 'produtos') {
            $sql = "INSERT INTO produtos VALUES (DEFAULT, '$nome', '$tipo', '$imagem', $valor, $estoque)";
        } else {
            $sql = "INSERT INTO adicionais VALUES (DEFAULT, '$nome', '$tipo', '$imagem', '$valor','$estoque')";
        }

        if (mysqli_query($conn, $sql)) {
            $response = array('message' => 'Produto adiconado com sucesso.');
            http_response_code(201); 
        } else {
            $response = array('error' => 'Erro ao adicionar o produto: ' . mysqli_error($conn));
            http_response_code(500); 
        }

        echo json_encode($response);
        mysqli_close($conn);
    }
?>