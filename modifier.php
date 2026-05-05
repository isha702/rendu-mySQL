<?php
require 'connexion.php';

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable.");
}

$erreurs = [];
if (isset($_POST['modifier'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $maison = $_POST['maison'];
    $interets = $_POST['interets'] ?? [];

    if (empty($pseudo))
        $erreurs[] = "Le pseudo est obligatoire.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $erreurs[] = "Email invalide.";
    if (count($interets) < 1)
        $erreurs[] = "Sélectionnez au moins un intérêt.";

    if (empty($erreurs)) {
        $interets_str = implode(", ", $interets);

        $sql = "UPDATE users SET pseudo = :pseudo, email = :email, maison = :maison, interets = :interets WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':pseudo' => $pseudo,
            ':email' => $email,
            ':maison' => $maison,
            ':interets' => $interets_str,
            ':id' => $id
        ]);
        echo "Modification enregistrée !";
    }
}

$interets_actuels = explode(", ", $user['interets']);
?>

<?php foreach ($erreurs as $e): ?>
    <p style="color:red"><?= $e ?></p>
<?php endforeach; ?>

<form method="POST">
    <input type="text" name="pseudo" value="<?= $user['pseudo'] ?>" required>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>

    <select name="maison">
        <?php foreach (['gryffondor', 'serpentard', 'serdaigle', 'poufsouffle'] as $m): ?>
            <option value="<?= $m ?>" <?= $user['maison'] === $m ? 'selected' : '' ?>>
                <?= ucfirst($m) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php foreach (['Quidditch', 'Potions', 'Défense', 'Astronomie', 'Herbologie'] as $interet): ?>
        <label>
            <input type="checkbox" name="interets[]" value="<?= $interet ?>" <?= in_array($interet, $interets_actuels) ? 'checked' : '' ?>>
            <?= ucfirst($interet) ?>
        </label>
    <?php endforeach; ?>

    <button type="submit" name="modifier">Modifier</button>
</form>

