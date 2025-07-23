<?php

require_once dirname(__DIR__) . '/config/database.php';

class User {
    public function register($username, $email, $password) {
        $db = new Database();
        $conn = $db->getConnection();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(16));

        $sql = "INSERT INTO users (username, email, password, verification_token)
                VALUES (:username, :email, :password, :token)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':token' => $token
        ]);

        echo "Inscription réussie. Un email de confirmation devrait être envoyé.";
    }

    public function login($username, $password) {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
        ];
    }

    return false;
}

}
