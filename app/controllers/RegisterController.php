<?php

require_once __DIR__ . '/../models/User.php';

class RegisterController {
    public function index() {
        require_once __DIR__ . '/../views/register.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $user = new User();
            $user->register($username, $email, $password);
        }
    }
}
