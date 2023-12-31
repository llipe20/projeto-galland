<?php 
function getRequests($id) {
    global $conn;

    // Selecione todos os dados relacionados a pedidos
    $sql = "SELECT
        pedidos.id as pedido_id,
        pedidos.valor as pedido_valor,
        pedidos.pagamento as pedido_pagamento,
        pedidos.situacao as pedido_situacao,
        pedidos.obs as pedido_obs,
        pedidos.delivery as pedido_delivery,
        clientes.id as cliente_id,
        clientes.nome as cliente_nome,
        clientes.email as cliente_email,
        clientes.fone as cliente_fone,
        clientes.rua as cliente_rua,
        clientes.bairro as cliente_bairro,
        clientes.casa as cliente_casa,
        clientes.referencia as cliente_referencia,
        produtos.id as produto_id,
        produtos.nome as produto_nome,
        produtos.tipo as produto_tipo,
        produtos_pedidos.quantidade as quantidade_produto,
        produtos.imagem as produto_imagem,
        produtos.valor as produto_valor,
        adicionais.id as adicional_id,
        adicionais.nome as adicional_nome,
        adicionais.tipo as adicional_tipo,
        adicionais_pedidos.quantidade as quantidade_adicional,
        adicionais.imagem as adicional_imagem,
        adicionais.valor as adicional_valor
        FROM
            pedidos
        JOIN
            clientes ON pedidos.cliente = clientes.id
        LEFT JOIN
            produtos_pedidos ON pedidos.id = produtos_pedidos.pedido
        LEFT JOIN
            produtos ON produtos_pedidos.produto = produtos.id
        LEFT JOIN
            adicionais_pedidos ON pedidos.id = adicionais_pedidos.pedido
        LEFT JOIN
            adicionais ON adicionais_pedidos.adicional = adicionais.id";
    
    // Verifique se a consulta é específica
    if ($id !== '') {
        $sql .= " WHERE pedidos.cliente = $id";
    }
    
    $result = mysqli_query($conn, $sql);
    
    // Responda se não encontrar nada
    if (!$result) {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(['error' => 'Erro ao obter pedido']);
        return;
    } else {
        $pedidos = array();

        while ($row = mysqli_fetch_assoc($result)) {
            // Encontre o índice do pedido no array, se existir
            $pedidoIndex = array_search($row['pedido_id'], array_column($pedidos, 'pedido_id'));

            if ($pedidoIndex !== false) {
                // Se o pedido já existe no array, adicione produtos e adicionais diretamente
                $produto = [
                    'produto_id' => $row['produto_id'],
                    'produto_nome' => $row['produto_nome'],
                    'produto_tipo' => $row['produto_tipo'],
                    'quantidade_produto' => $row['quantidade_produto'],
                    'produto_imagem' => $row['produto_imagem'],
                    'produto_valor' => $row['produto_valor']
                ];

                if (!in_array($produto, $pedidos[$pedidoIndex]['produtos'], true)) {
                    $pedidos[$pedidoIndex]['produtos'][] = $produto;
                }

                $adicional = [
                    'adicional_id' => $row['adicional_id'],
                    'adicional_nome' => $row['adicional_nome'],
                    'adicional_tipo' => $row['adicional_tipo'],
                    'quantidade_adicional' => $row['quantidade_adicional'],
                    'adicional_imagem' => $row['adicional_imagem'],
                    'adicional_valor' => $row['adicional_valor']
                ];

                if (!in_array($adicional, $pedidos[$pedidoIndex]['adicionais'], true)) {
                    $pedidos[$pedidoIndex]['adicionais'][] = $adicional;
                }
            } else {
                // Se o pedido não existe no array, adiciona-o
                $pedido = [
                    'pedido_id' => $row['pedido_id'],
                    'pedido_valor' => $row['pedido_valor'],
                    'pedido_pagamento' => $row['pedido_pagamento'],
                    'pedido_situacao' => $row['pedido_situacao'],
                    'pedido_obs' => $row['pedido_obs'],
                    'pedido_delivery' => $row['pedido_delivery'],
                    'cliente_id' => $row['cliente_id'],
                    'cliente_nome' => $row['cliente_nome'],
                    'cliente_email' => $row['cliente_email'],
                    'cliente_fone' => $row['cliente_fone'],
                    'cliente_rua' => $row['cliente_rua'],
                    'cliente_bairro' => $row['cliente_bairro'],
                    'cliente_casa' => $row['cliente_casa'],
                    'cliente_referencia' => $row['cliente_referencia'],
                    'produtos' => [],
                    'adicionais' => []
                ];

                // Adiciona o produto ao pedido, verificando a existência
                $produto = [
                    'produto_id' => $row['produto_id'],
                    'produto_nome' => $row['produto_nome'],
                    'produto_tipo' => $row['produto_tipo'],
                    'quantidade_produto' => $row['quantidade_produto'],
                    'produto_imagem' => $row['produto_imagem'],
                    'produto_valor' => $row['produto_valor']
                ];

                if (!in_array($produto, $pedido['produtos'], true)) {
                    $pedido['produtos'][] = $produto;
                }

                // Adiciona o adicional ao pedido, verificando a existência
                $adicional = [
                    'adicional_id' => $row['adicional_id'],
                    'adicional_nome' => $row['adicional_nome'],
                    'adicional_tipo' => $row['adicional_tipo'],
                    'quantidade_adicional' => $row['quantidade_adicional'],
                    'adicional_imagem' => $row['adicional_imagem'],
                    'adicional_valor' => $row['adicional_valor']
                ];

                if (!in_array($adicional, $pedido['adicionais'], true)) {
                    $pedido['adicionais'][] = $adicional;
                }

                $pedidos[] = $pedido;
            }
        }

        // Envia dados 
        header('Content-Type: application/json');
        echo json_encode($pedidos, JSON_PRETTY_PRINT);
        mysqli_close($conn);
    }
}
?>
