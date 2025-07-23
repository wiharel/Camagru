<?php

class ProfileController {
    public function index() {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /?page=login');
            exit;
        }

        $user = $_SESSION['user'];
        require_once __DIR__ . '/../views/profile.php';
    }

    public function logout() {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_destroy();
        header('Location: /?page=login');
        exit;
    } else {
        header('Location: /?page=profile');
        exit;
    }
}
}

