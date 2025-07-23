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
        $this->sendVerificationEmail($email, $token);
        echo "Lien de confirmation : http://localhost:8000/?page=verify&token=$token";


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
    if ($user['verified']) {
        return [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
        ];
    } else {
        echo "Compte non vérifié. Vérifie ta boîte mail.";
        return false;
    }
}

    return false;
}

  public function sendVerificationEmail($email, $token) {
    $subject = "Confirme ton inscription à Camagru";
    $link = "http://localhost:8000/?page=verify&token=$token";
    $message = "Clique sur ce lien pour confirmer ton compte : $link";
    $headers = "From: no-reply@camagru.local";
    mail($email, $subject, $message, $headers);
    echo "<br>Ton lien de vérification : ";
    echo "<a href='http://localhost:8000/?page=verify&token=$token'>Clique ici pour confirmer ton compte</a>";
  }

  public function verifyToken($token) {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM users WHERE verification_token = :token AND verified = 0");
    $stmt->execute([':token' => $token]);

    if ($stmt->rowCount() === 1) {
        $stmt = $conn->prepare("UPDATE users SET verified = 1, verification_token = NULL WHERE verification_token = :token");
        return $stmt->execute([':token' => $token]);
    }

    return false;
}


}
