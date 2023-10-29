<?php 
    include_once 'conexao.php';
    // incluir os arquivos de requisições
    $directory = '../methods/requests/';
    $files = glob($directory . '*.php');
    
    foreach ($files as $file) {
        include_once $file;
    }

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

    // capturando o método e dados da url
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $method = 'GET';

    // resposta em relação ao método chamado
    switch($method) {
        case 'GET':
            $parts = explode('/', $path);  // dividi a url pela /
            $id = isset($parts[4]) ? $parts[4] : '';
            getRequests($id);
        break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            newRequests($data);
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