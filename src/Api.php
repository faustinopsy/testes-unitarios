<?php
namespace App\Testes;

require '../vendor/autoload.php';

use App\Testes\User;
use App\Testes\UserService;

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

$user = new User();
$userService = new UserService($user);

$response = ['status' => 'error', 'message' => 'Requisição inválida'];

if ($method === 'POST' && isset($data['action']) && isset($data['username']) && isset($data['password'])) {
    $action = $data['action'];
    
    try {
        if ($action === 'register') {
            $userService->registrarUser($data['username'], $data['password']);
            $response = ['status' => 'success', 'message' => 'Usuário registrado com sucesso'];
        } elseif ($action === 'login') {
            if ($userService->logarUser($data['username'], $data['password'])) {
                $response = ['status' => 'success', 'message' => 'Login bem-sucedido'];
            } else {
                $response = ['status' => 'error', 'message' => 'Credenciais incorretas'];
            }
        }
    } catch (\Exception $e) {
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
}

echo json_encode($response);