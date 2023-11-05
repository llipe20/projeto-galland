function copy (idA, idB, e) {
    const conteudo = document.getElementById(`${idA}`)  // conteúdo a ser copiado
    const pai = document.getElementById(`${idB}`)  // box pai
    const textarea = document.createElement('textarea');
    const tag = e.target  // elemento de disparo

    textarea.value = conteudo.innerText;
    document.body.appendChild(textarea);

    // Seleciona o texto na área de texto temporário
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);

    tag.classList.add("w-0", "h-0")
    pai.innerText = 'copiado'
    pai.classList.add("text-base")

    setInterval(() => {
        tag.classList.remove("w-0", "h-0")
        tag.classList.add("flex")
        pai.innerText = ''
    }, 3000)
}

async function newRequest() {
    const data = 
        {
            "id_login":"Int", // id do usuário
            "pedido_valor": "Float", // valor da compra
            "pedido_pagamento": "String", // forma de pagamento
            "pedido_situacao": "String", 
            "pedido_obs": "String", 
            "pedido_delivery": "Boolean", // delivery ou retirada,
            "cliente_id": 2, // id do cliente
            "cliente_nome": "String",  
            "cliente_email": "String",
            "cliente_fone": "String",
            "cliente_rua": "String",
            "cliente_bairro": "String",
            "cliente_casa": "String",
            "cliente_referencia": "String",
            "produtos": [
                {
                    "produto_id": "Int", // id do produto que está consumindo
                    "quantidade_produto": "Int"
                }
            ],
            "adicionais": [
                {
                    "adicional_id": "Int", // id do adicional que está consumindo
                    "quantidade_adicional": "Int",
                }
            ]
        }

        
        const url = 'http://localhost/api/routers/pedidos.php'

        req = await fetch(url, {
            method: 'POST',
            headers: 
            { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
    })
        const res = await req.json()
        console.log(res)

}

async function newUser() {
    const data = 
        {
            "nome" : "String",
            "email" : "String",
            "senha" : "String"
        }

        const url = 'http://localhost/api/routers/login.php'

        req = await fetch(url, {
            method: 'POST',
            headers: 
            { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
    })
        const res = await req.json()
        console.log(res)
}

async function newProdut() {
    const data = 
        {
            "nome" : "String",
            "tipo" : "produto", // 'produto' ou 'adicional'
            "imagem" : "String",
            "valor" : 10, // valor da unidade
            "estoque" : 66
        }

        const url = 'http://localhost/api/routers/produtos.php'

        req = await fetch(url, {
            method: 'POST',
            headers: 
            { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
    })
        const res = await req.json()
        console.log(res)
}

