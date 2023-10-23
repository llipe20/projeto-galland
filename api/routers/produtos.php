<?php 
    include_once 'conexao.php';
    // incluir os arquivos de requisições
    $directory = '../methods/products/';
    $files = glob($directory . '*.php');
    
    foreach ($files as $file) {
        include_once $file;
    }

    // capturando o método e dados da url
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // resposta em relação ao método chamado
    switch($method) {
        case 'GET':
            $parts = explode('/', $path);  // dividi a url pela /
            $id = isset($parts[4]) ? $parts[4] : '';
            getProducts($id);
        break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            createProdutc($data);
        break;
        case 'PUT':

        break;
        case 'DELETE':

        break;
        default:
            header("HTTP/1.0 405 Rota não encontrada");
        break;
    }
?>