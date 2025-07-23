<?php
echo "<h1>Bienvenue, " . htmlspecialchars($user['username']) . " !</h1>";
echo "<p>Email : " . htmlspecialchars($user['email']) . "</p>";
?>

<form action="/?page=profile&action=logout" method="post">
    <button type="submit">Se déconnecter</button>
</form>
