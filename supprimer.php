<?php
require 'connexion.php';

$id   = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT pseudo FROM users WHERE id = :id");
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable.");
}

if (isset($_POST['confirmer'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo "Utilisateur supprimé.";
    exit;
}
?>

<p>Voulez-vous vraiment supprimer <strong><?= $user['pseudo'] ?></strong> ?</p>

<form method="POST">
    <button type="submit" name="confirmer" style="color:red">Oui, supprimer</button>
    <a href="affichage.php">Annuler</a>
</form>