CREATE DATABASE galland;
USE galland;
CREATE TABLE login (
	id INT AUTO_INCREMENT,
    usuario VARCHAR(100),
    senha VARCHAR(100),
    PRIMARY KEY(id)
);

CREATE TABLE clientes (
	id INT AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100),
    fone VARCHAR(100),
    rua VARCHAR(100),
    bairro VARCHAR(100),
    casa VARCHAR(100),
    referencia VARCHAR(100),
    login INT,
    PRIMARY KEY(id),
    FOREIGN KEY (login) REFERENCES login(id)
);

CREATE TABLE produtos (
	id INT AUTO_INCREMENT,
    nome VARCHAR(100),
    tipo VARCHAR(100),
    imagem VARCHAR(100),
    valor DECIMAL(10,2),
    estoque INT,
    PRIMARY KEY (id)
);

CREATE TABLE adicionais (
	id INT AUTO_INCREMENT,
    nome VARCHAR(100),
    tipo VARCHAR(100),
    imagem VARCHAR(100),
    valor DECIMAL(10,2),
    estoque INT,
    PRIMARY KEY(id)
);

CREATE TABLE pedidos (
	id INT AUTO_INCREMENT,
    cliente INT,
    valor DECIMAL(10,2),
    pagamento VARCHAR(100),
    situacao VARCHAR(100),
    obs VARCHAR(200),
    delivery BOOLEAN,
    PRIMARY KEY(id),
    FOREIGN KEY(cliente) REFERENCES clientes(id)
);

CREATE TABLE produtos_pedidos (
    id INT AUTO_INCREMENT,
    pedido INT,
    produto INT,
    quantidade INT,
    PRIMARY KEY(id),
    FOREIGN KEY(pedido) REFERENCES pedidos(id),
    FOREIGN KEY(produto) REFERENCES produtos(id)
);

CREATE TABLE adicionais_pedidos (
    id INT AUTO_INCREMENT,
    pedido INT,
    adicional INT,
    quantidade INT,
    PRIMARY KEY(id),
    FOREIGN KEY(pedido) REFERENCES pedidos(id),
    FOREIGN KEY(adicional) REFERENCES adicionais(id)
);

SELECT
    pedidos.id as pedido_id,
    pedidos.valor as pedido_valor,
    pedidos.pagamento as pedido_pagamento,
    pedidos.situacao as pedido_situacao,
    pedidos.obs as pedido_obs,
    clientes.id as cliente_id,
    clientes.nome as cliente_nome,
    clientes.email as cliente_email,
    clientes.fone as cliente_fone,
    clientes.rua as cliente_rua,
    clientes.bairro as cliente_bairro,
    clientes.casa as cliente_casa,
    clientes.referencia as cliente_referencia,
    produtos_pedidos.quantidade as quantidade_produto,
    produtos.id as produto_id,
    produtos.nome as produto_nome,
    produtos.tipo as produto_tipo,
    produtos.imagem as produto_imagem,
    produtos.valor as produto_valor,
    adicionais_pedidos.quantidade as quantidade_adicional,
    adicionais.id as adicional_id,
    adicionais.nome as adicional_nome,
    adicionais.tipo as adicional_tipo,
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
    adicionais ON adicionais_pedidos.adicional = adicionais.id;
