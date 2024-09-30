<?php
namespace App\Testes;

require '../vendor/autoload.php';

use App\Testes\UserController;

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

$user = new User();
$userController = new UserController($user);


$response = ['status' => 'error', 'message' => 'Requisição inválida'];

try {
    if ($method === 'POST' && isset($data['action'])) {
        $action = $data['action'];

        if ($action === 'register') {
            if (isset($data['username'], $data['password'])) {
                $username = trim($data['username']);
                $password = $data['password'];

                if (empty($username) || empty($password)) {
                    http_response_code(400);
                    $response['message'] = 'Username e senha não podem ser vazios';
                } else {
                    if ($userController->registrarUser($username, $password)) {
                        http_response_code(201);
                        $response = ['status' => 'success', 'message' => 'Usuário registrado com sucesso'];
                    } else {
                        http_response_code(409);
                        $response['message'] = 'Usuário já existe';
                    }
                }
            } else {
                http_response_code(400);
                $response['message'] = 'Parâmetros username e password são necessários';
            }
        } elseif ($action === 'login') {
            if (isset($data['username'], $data['password'])) {
                $username = trim($data['username']);
                $password = $data['password'];

                if ($userController->logarUser($username, $password)) {
                    http_response_code(200); 
                    $response = ['status' => 'success', 'message' => 'Login bem-sucedido'];
                } else {
                    http_response_code(401); 
                    $response['message'] = 'Credenciais incorretas';
                }
            } else {
                http_response_code(400);
                $response['message'] = 'Parâmetros username e password são necessários';
            }
        } else {
            http_response_code(400);
            $response['message'] = 'Ação inválida';
        }
    } else {
        http_response_code(400);
        $response['message'] = 'Requisição inválida';
    }
} catch (\Exception $e) {
    http_response_code(500);
    $response['message'] = 'Erro interno do servidor';
    error_log($e->getMessage());
}

echo json_encode($response);
