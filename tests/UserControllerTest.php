<?php
namespace App\Testes;

use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase {
    private $userController;

    protected function setUp(): void {
        $user = new User();
        $this->userController = new UserController($user);
    }

    public function testRegistrarUser() {
        $result = $this->userController->registrarUser("integrationUser", "password123");
        $this->assertTrue($result, "Falha ao registrar usuário no teste de integração");
        fwrite(STDOUT, "Função testada: registrarUser - Registro de usuário com sucesso.\n");
    }

    public function testRegistrarUserExistente() {
        $this->userController->registrarUser("integrationUser", "password123");
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("O nome de usuário já existe");
        try {
            $this->userController->registrarUser("integrationUser", "password456");
        } catch (\Exception $e) {
            $this->assertEquals("O nome de usuário já existe", $e->getMessage());
            fwrite(STDOUT, "Função testada: registrarUser - Exceção lançada para usuário existente.\n");
            throw $e;
        }
    }

    public function testLogarCorretamente() {
        $this->userController->registrarUser("integrationUser", "password123");
        $result = $this->userController->logarUser("integrationUser", "password123");
        $this->assertTrue($result, "Falha ao autenticar usuário com credenciais corretas no teste de integração");
        fwrite(STDOUT, "Função testada: logarUser - Autenticação bem-sucedida com credenciais corretas.\n");
    }

    public function testLogarIncorretamente() {
        $this->userController->registrarUser("integrationUser", "password123");
        $result = $this->userController->logarUser("integrationUser", "wrongpassword");
        $this->assertFalse($result, "Autenticação bem-sucedida com credenciais incorretas no teste de integração");
        fwrite(STDOUT, "Função testada: logarUser - Falha na autenticação com credenciais incorretas.\n");
    }

    public function testLogarUserInexistente() {
        $result = $this->userController->logarUser("nonexistentUser", "password123");
        $this->assertFalse($result, "Autenticação bem-sucedida para usuário inexistente no teste de integração");
        fwrite(STDOUT, "Função testada: logarUser - Falha na autenticação para usuário inexistente.\n");
    }
}