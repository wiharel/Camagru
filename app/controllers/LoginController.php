<?php

require_once __DIR__ . '/../models/User.php';

class LoginController {
    public function index() {
        require_once __DIR__ . '/../views/login.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = new User();
            $loggedIn = $user->login($username, $password);

            if ($loggedIn) {
                session_start();
                $_SESSION['user'] = $loggedIn;
                header('Location: /?page=profile');
                exit;
            } else {
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
    }
}
