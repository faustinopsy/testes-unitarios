<?php
namespace App\Testes;
use Exception;
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