function toji(id,data) {
    const element = document.getElementById(`${id}`)
    element.textContent = data
}

async function mahoraga() {
    const data = 
        {
            "id_login":"2",
            "pedido_valor": 20,
            "pedido_pagamento": "debito",
            "pedido_situacao": "Finalizado",
            "pedido_obs": "sem cebola",
            "pedido_delivery": false,
            "cliente_id": "",
            "cliente_nome": "Gih maia",
            "cliente_email": "fs2284511@mail.com",
            "cliente_fone": "(99) 98447-0567",
            "cliente_rua": "Vinte e um de abril",
            "cliente_bairro": "Volta Redonda",
            "cliente_casa": "1279",
            "cliente_referencia": "Prox a escoila",
            "produtos": [
                {
                    "produto_id": "1",
                    "quantidade_produto": "1"
                },
                {
                    "produto_id": "2",
                    "quantidade_produto": "4"
                },
                {
                    "produto_id": "3",
                    "quantidade_produto": "2"
                }
            ],
            "adicionais": [
                {
                    "adicional_id": "1",
                    "quantidade_adicional": "1",
                },
                {
                    "adicional_id": "2",
                    "quantidade_adicional": "2",
                }
            ]
        }

        const url = 'http://localhost/api/routers/pedidos.php'

        req = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })

    console.log(req)
}
