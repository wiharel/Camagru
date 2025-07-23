<?php

require_once __DIR__ . '/../models/User.php';

class VerifyController {
    public function index() {
        if (!isset($_GET['token'])) {
            echo "Lien invalide.";
            return;
        }

        $token = $_GET['token'];
        $user = new User();
        if ($user->verifyToken($token)) {
            echo "Compte vérifié avec succès.";
        } else {
            echo "Token invalide ou déjà utilisé.";
        }
    }
}
