<?php    
    function newRequests($data) {
        global $conn;

        // inseri o cliente se não houver cadastro e pega id
        if($data['cliente_id'] == '') {
            $cliente = [
                'nome' => $data['cliente_nome'],
                'email' => $data['cliente_email'],
                'fone' => $data['cliente_fone'],
                'rua' => $data['cliente_rua'],
                'bairro' => $data['cliente_bairro'],
                'casa' => $data['cliente_casa'],
                'ref' => $data['cliente_referencia'],
                'user' => $data['login_user']
            ];
            $idCliente = insertCliente($cliente, $conn);
        } else {
            $idCliente = $data['cliente_id'];
        }

         // inseri o pedido e pega id
        $pedido = [
            'cliente' => $idCliente,
            'valor' => $data['pedido_valor'],
            'pag' => $data['pedido_pagamento'],
            'status' => $data['pedido_situacao'],
            'obs' => $data['pedido_obs'],
            'delivery' => $data['pedido_delivery']
        ];

        $idPedido = insertPedido($pedido, $conn);

        // Inserir produtos do pedido
        foreach ($data['produtos'] as $product) {
            insertProdutosPedidos($idPedido, $product, $conn);
        }

        // Inserir adicionais do pedido
        foreach ($data['adicionais'] as $additional) {
            insertAdicionaisPedidos($idPedido, $additional, $conn);
        }
        mysqli_close($conn);
        
        $response = array('message' => 'Pedido adiconado com sucesso.');
        http_response_code(201); 
        echo json_encode($response);
    }

    // Inserir dados na tabela 'cliente'
    function insertCliente($data, $conn) {

        $nome = mysqli_escape_string($conn, $data['nome']);
        $email = mysqli_escape_string($conn, $data['email']);
        $fone = mysqli_escape_string($conn, $data['fone']);
        $rua = mysqli_escape_string($conn, $data['rua']);
        $bairro = mysqli_escape_string($conn, $data['bairro']);
        $casa = mysqli_escape_string($conn, $data['casa']);
        $ref = mysqli_escape_string($conn, $data['ref']);
        $user = mysqli_escape_string($conn, $data['user']);

        $sql = "INSERT INTO clientes VALUES (DEFAULT, '$nome', '$email', '$fone', '$rua', '$bairro', '$casa', '$ref', '$user')";

        if(mysqli_query($conn, $sql)) {
            return mysqli_insert_id($conn); // Retorna o ID do cliente recém-inserido
        } else {
            die("Erro ao inserir cliente: " . mysqli_error($conn));
        }
    }

    // Inserir dados na tabela 'pedidos'
    function insertPedido($data, $conn) {
        $cliente = mysqli_escape_string($conn, $data['cliente']);
        $valor = mysqli_escape_string($conn, $data['valor']);
        $pag = mysqli_escape_string($conn, $data['pag']);
        $situacao = mysqli_escape_string($conn, $data['situacao']);
        $obs = mysqli_escape_string($conn, $data['obs']);
        $delivery = mysqli_escape_string($conn, $data['delivery']);

        $sql = "INSERT INTO pedidos VALUES (DEFAULT, '$cliente', '$valor', '$pag', '$situacao', '$obs', '$delivery')";

        if (mysqli_query($conn, $sql)) {
            return mysqli_insert_id($conn); // Retorna o ID do pedido recém-inserido
        } else {
            die("Erro ao inserir pedido: " . mysqli_error($conn));
        }
    }

    // Inserir dados na tabela 'produtos_pedidos'
    function insertProdutosPedidos($pedido, $produto, $conn) {
        $id = $produto['produto_id'];
        $quant = $produto['quantidade_produto'];

        $sql = "INSERT INTO produtos_pedidos VALUES (DEFAULT, '$pedido', '$id', '$quant')";

        if (!mysqli_query($conn, $sql)) {
            die("Erro ao inserir produto_pedido: " . mysqli_error($conn));
        }
    }

    // Inserir dados na tabela 'adicionais_pedidos'
    function insertAdicionaisPedidos($pedido, $additional, $conn) {
        $id = $additional['adicional_id'];
        $quant = $additional['quantidade_adicional'];

        $sql = "INSERT INTO adicionais_pedidos VALUES (DEFAULT, '$pedido', '$id', '$quant')";

        if (!mysqli_query($conn, $sql)) {
            die("Erro ao inserir adicional_pedido: " . mysqli_error($conn));
        }
    }
?>

