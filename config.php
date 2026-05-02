<?php
require "config.php";

$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

$sql = "SELECT * FROM utilisateurs WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);

$user = $stmt->fetch();

if ($user) {
    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        echo "Connexion réussie 👍";
    } else {
        echo "Mot de passe incorrect ❌";
    }
} else {
    echo "Email introuvable ❌";
}
?>