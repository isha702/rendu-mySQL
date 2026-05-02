<?php
if (isset($_POST['inscription'])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $maison = $_POST['maison'];
    $interets = $_POST['interets'] ?? [];

    // 🔒 Vérification champs
    if (empty($pseudo) || empty($email) || empty($password)) {
        die("Tous les champs sont obligatoires.");
    }

    // 🔒 Vérification mot de passe
    if ($password !== $confirm) {
        die("Les mots de passe ne correspondent pas.");
    }

    // 🔒 Vérifier au moins 1 intérêt
    if (count($interets) < 1) {
        die("Sélectionnez au moins un centre d’intérêt.");
    }

    // 🔐 Hash du mot de passe
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // transformation tableau → string
    $interets_str = implode(", ", $interets);

    // 🧩 INSERT PDO sécurisé
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