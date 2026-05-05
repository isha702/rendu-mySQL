<?php
require 'connexion.php';
if (isset($_POST['inscription'])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $maison = $_POST['maison'];
    $interets = $_POST['interets'] ?? [];

  
    if (empty($pseudo) || empty($email) || empty($password)) {
        die("Tous les champs sont obligatoires.");
    }

  
    if ($password !== $confirm) {
        die("Les mots de passe ne correspondent pas.");
    }

    
    if (count($interets) < 1) {
        die("Sélectionnez au moins un centre d’intérêt.");
    }

  
    $hash = password_hash($password, PASSWORD_DEFAULT);

    
    $interets_str = implode(", ", $interets);

    
    $sql = "INSERT INTO users (pseudo, email, password, maison, interets)
            VALUES (:pseudo, :email, :password, :maison, :interets)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':pseudo' => $pseudo,
        ':email' => $email,
        ':password' => $hash,
        ':maison' => $maison,
        ':interets' => $interets_str
    ]);

    echo "Inscription réussie ! Bienvenue dans l’univers Harry Potter 🧙‍♂️";
}
?>
