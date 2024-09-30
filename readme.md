# Projeto de Testes Unitários e de Integração em PHP

## Descrição

Este projeto demonstra a criação e execução de testes unitários e de integração em PHP utilizando o PHPUnit. Ele inclui exemplos de como registrar e autenticar usuários, com testes unitários e de integração correspondentes para verificar a funcionalidade.

## O que é Teste Unitário?

Teste unitário é uma técnica de teste de software onde pequenas partes do código (unidades) são testadas isoladamente para garantir que funcionem corretamente. Os testes unitários são fundamentais para identificar bugs no início do desenvolvimento e garantir que cada parte do código funcione como esperado.

## O que é Teste de Integração?

Teste de integração verifica a interação entre diferentes módulos ou serviços do sistema, garantindo que eles funcionem juntos corretamente.

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
    │   ├── User.php
    │   └── UserController.php
    ├── tests/
    │   ├── UserTest.php
    │   └── UserControllerTest.php
    ├── vendor/
    ├── composer.json
    └── phpunit.xml
    ```

## Executando os Testes

### Testes Unitários

Para executar os testes unitários, use o comando:

```bash
./vendor/bin/phpunit tests/UserTest.php
```

estes de Integração
Para executar os testes de integração, use o comando:
```bash
./vendor/bin/phpunit tests/UserControllerTest.php

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
## Coverage
Code Coverage, ou Cobertura de Código, é uma métrica utilizada no desenvolvimento de software para medir a extensão em que o código-fonte de um programa é executado durante os testes automatizados. Em outras palavras, ele indica quais partes do código foram testadas e quais não foram.
- para funcionar corretamente a geração dos html que são os relatórios é necessarios algumas configurações, uma delas é o aquivo xml "phpunit.xml" na raiz do projeto.

```
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         bootstrap="vendor/autoload.php"
         colors="true"
         processIsolation="false"
         stopOnFailure="false"
         xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/10.4/phpunit.xsd"
         cacheDirectory=".phpunit.cache">

  <coverage>
    <include>
      <directory suffix=".php">src</directory>
    </include>
    <report>
      <html outputDirectory="coverage-report" lowUpperBound="35" highLowerBound="70"/>
    </report>
  </coverage>

  <testsuites>
    <testsuite name="Your Test Suite">
      <directory>tests</directory>
    </testsuite>
  </testsuites>

  <logging/>
</phpunit>


```
e o php.ini configurado com a extensão xdebug, que precisa baixar a versão compativel com php utilizado, https://pecl.php.net/package/xdebug/3.3.2/windows

```
extension=xdebug

[xdebug]
zend_extension ="C:/php/ext/php_xdebug.dll"
xdebug.mode=coverage
xdebug.start_with_request=yes
```


## Contribuindo
Sinta-se à vontade para contribuir com este projeto enviando pull requests. Para grandes mudanças, por favor, abra uma issue primeiro para discutir o que você gostaria de mudar.

Licença
Este projeto está licenciado sob a licença MIT - veja o arquivo LICENSE para mais detalhes.