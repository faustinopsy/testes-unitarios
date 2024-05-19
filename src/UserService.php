<?php
namespace App\Testes;

class UserService {
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function registrarUser($username, $password) {
        return $this->user->register($username, $password);
    }

    public function logarUser($username, $password) {
        return $this->user->login($username, $password);
    }
}