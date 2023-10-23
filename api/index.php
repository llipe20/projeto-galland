<?php 
    // incluir os arquivos de requisições
    $directory = 'methods/get/';
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
            switch($path) {
                case '/produtos':
                    if(strpos($path, '/usuario/') === 0) {  // Rota para obter um usuário específico
                        $id = intval(substr($path, strlen('/usuario/')));
                        getProdutos($id); 
                    } else {
                        getProdutos('');
                    }
                break;
                case '/pedidos':
                    if(strpos($path, '/pedidos/') === 0) {  
                        $id = intval(substr($path, strlen('/pedidos/')));
                        getPedidos($id); 
                    } else {
                        getPedidos('');
                    }
                break;
                case '/login':
                    if(strpos($path, '/login/') === 0) {  
                        $id = intval(substr($path, strlen('/login/')));
                        getLogin($id); 
                    } else {
                        getLogin('');
                    }
                break;
                default:
                    header("HTTP/1.0 405 Rota não encontrada");
                break;
            }
        break;
        case 'POST':

        break;
        case 'PUT':

        break;
        case 'DELETE':

        break;
        default:

        break;
    }

?>