<?php

// tests/UserTest.php
namespace App\Testes;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    private $user;

    protected function setUp(): void {
        $this->user = new User();
    }

    public function testRegistrarUsuario() {
        $result = $this->user->register("testuser", "password123");
        $this->assertTrue($result, "Registro de usuário falhou");
        fwrite(STDOUT, "Função testada: register - Registro de usuário com sucesso.\n");
    }

    public function testRegistrarUsuarioExistente() {
        $this->user->register("testuser", "password123");
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("O nome de usuário já existe");
        try {
            $this->user->register("testuser", "password456");
        } catch (\Exception $e) {
            $this->assertEquals("O nome de usuário já existe", $e->getMessage());
            fwrite(STDOUT, "Função testada: register - Exceção lançada para usuário existente.\n");
            throw $e;
        }
    }

    public function testLoginCorreto() {
        $this->user->register("testuser", "password123");
        $result = $this->user->login("testuser", "password123");
        $this->assertTrue($result, "Login falhou com credenciais corretas");
        fwrite(STDOUT, "Função testada: login - Login bem-sucedido com credenciais corretas.\n");
    }

    public function testLoginIncorreto() {
        $this->user->register("testuser", "password123");
        $result = $this->user->login("testuser", "wrongpassword");
        $this->assertFalse($result, "Login bem-sucedido com credenciais incorretas");
        fwrite(STDOUT, "Função testada: login - Falha no login com credenciais incorretas.\n");
    }

    public function testLoginUsuarioInexistente() {
        $result = $this->user->login("nonexistentuser", "password123");
        $this->assertFalse($result, "Login bem-sucedido com usuário inexistente");
        fwrite(STDOUT, "Função testada: login - Falha no login com usuário inexistente.\n");
    }
}
