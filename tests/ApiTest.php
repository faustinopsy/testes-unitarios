<?php
namespace App\Testes;

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase {
    private $url = 'http://localhost:8080/src/Api.php';

    private function fazRequisicao(array $postData): array {
        $ch = curl_init($this->url);
    
        $payload = json_encode($postData);
    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);
    
        $result = curl_exec($ch);
    
        if ($result === false) {
            $error = curl_error($ch);
            curl_close($ch);
            $this->fail('Falha na requisição HTTP: ' . $error);
        }
    
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if ($httpStatusCode >= 400) {
            $this->fail('Erro HTTP: Código ' . $httpStatusCode . '. Resposta: ' . $result);
        }
    
        $response = json_decode($result, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->fail('Falha ao decodificar o JSON: ' . json_last_error_msg() . '. Resposta: ' . $result);
        }
    
        return $response;
    }
    

    public function testRegisterUserIntegration() {
        $username = 'user_' . uniqid();
        $postData = ['action' => 'register', 'username' => $username, 'password' => 'senha123'];

        fwrite(STDOUT, "Função testada: registro de usuário - Iniciando teste de registro para o usuário '$username'.\n");

        $response = $this->fazRequisicao($postData);

        $this->assertEquals('success', $response['status'], "Falha ao registrar o usuário");
        $this->assertEquals('Usuário registrado com sucesso', $response['message'], "Mensagem de resposta incorreta");

        fwrite(STDOUT, "Usuário '$username' registrado com sucesso.\n");
    }

    public function testLoginUserIntegration() {
        $username = 'user_' . uniqid();
        $password = 'senha123';

        fwrite(STDOUT, "Função testada: login de usuário - Iniciando teste de login para o usuário '$username'.\n");

        $postData = ['action' => 'register', 'username' => $username, 'password' => $password];
        $response = $this->fazRequisicao($postData);

        $this->assertEquals('success', $response['status'], "Falha ao registrar o usuário");
        $this->assertEquals('Usuário registrado com sucesso', $response['message'], "Mensagem de resposta incorreta");

        fwrite(STDOUT, "Usuário '$username' registrado com sucesso para o teste de login.\n");

        // Testar o login
        $postData = ['action' => 'login', 'username' => $username, 'password' => $password];
        $response = $this->fazRequisicao($postData);

        $this->assertEquals('success', $response['status'], "Falha ao logar o usuário");
        $this->assertEquals('Login bem-sucedido', $response['message'], "Mensagem de resposta incorreta");

        fwrite(STDOUT, "Login do usuário '$username' realizado com sucesso.\n");
    }
}
