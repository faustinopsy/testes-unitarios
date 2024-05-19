<?php
namespace App\Testes;

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase {
    private $url = 'http://localhost/src/Api.php';

    public function testRegisterUserIntegration() {
        $postData = ['action' => 'register', 'username' => 'admin', 'password' => 'admin123'];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($postData),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);
        $response = json_decode($result, true);

        $this->assertEquals('success', $response['status'], "Falha ao registrar usuário na integração");
        $this->assertEquals('Usuário registrado com sucesso', $response['message'], "Mensagem de resposta incorreta");
    }

    public function testLoginUserIntegration() {
        $postData = ['action' => 'register', 'username' => 'admin', 'password' => 'admin123'];
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($postData),
            ],
        ];
        $context  = stream_context_create($options);
        file_get_contents($this->url, false, $context);

        $postData = ['action' => 'login', 'username' => 'admin', 'password' => 'admin123'];
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($postData),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);
        $response = json_decode($result, true);

        $this->assertEquals('success', $response['status'], "Falha ao logar usuário na integração");
        $this->assertEquals('Login bem-sucedido', $response['message'], "Mensagem de resposta incorreta");
    }
}