# Projeto de Testes Unitários em PHP

## Descrição

Este projeto demonstra a criação e execução de testes unitários em PHP utilizando o PHPUnit. Ele inclui exemplos de como registrar e autenticar usuários, com testes unitários correspondentes para verificar a funcionalidade.

## O que é Teste Unitário?

Teste unitário é uma técnica de teste de software onde pequenas partes do código (unidades) são testadas isoladamente para garantir que funcionem corretamente. Os testes unitários são fundamentais para identificar bugs no início do desenvolvimento e garantir que cada parte do código funcione como esperado.

## Pré-requisitos

- PHP >= 8.0
- Composer

## Instalação

Siga os passos abaixo para configurar o projeto em sua máquina local.

1. **Clone o repositório**:

    ```bash
    git clone https://github.com/faustinopsy/testes-unitarios.git
    cd testes-unitarios
    ```

2. **Instale as dependências do projeto**:

    ```bash
    composer install
    ```

3. **Estrutura de Diretórios**:

    ```
    ├── src/
    │   └── User.php
    ├── tests/
    │   └── UserTest.php
    ├── vendor/
    ├── composer.json
    └── phpunit.xml
    ```

## Executando os Testes

Após instalar as dependências, você pode executar os testes unitários utilizando o PHPUnit. Para isso, utilize o seguinte comando:

```bash
./vendor/bin/phpunit tests/UserTest.php
```


## Exemplos de Código
- Classe User
A classe User permite registrar e logar usuários. Aqui está um exemplo simples:

```
namespace App\Testes;

class User {
    private $users = [];

    public function register($username, $password) {
        if (isset($this->users[$username])) {
            throw new \Exception("O nome de usuário já existe");
        }
        $this->users[$username] = password_hash($password, PASSWORD_DEFAULT);
        return true;
    }

    public function login($username, $password) {
        if (!isset($this->users[$username])) {
            return false;
        }
        return password_verify($password, $this->users[$username]);
    }
}
```
Testes Unitários para a Classe User
Aqui estão alguns exemplos de testes unitários para a classe User:

```
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

```
## Contribuindo
Sinta-se à vontade para contribuir com este projeto enviando pull requests. Para grandes mudanças, por favor, abra uma issue primeiro para discutir o que você gostaria de mudar.

Licença
Este projeto está licenciado sob a licença MIT - veja o arquivo LICENSE para mais detalhes.