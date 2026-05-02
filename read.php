<?php
include 'config.php';

// tri (par défaut pseudo)
$tri = $_GET['tri'] ?? 'pseudo';

if (!in_array($tri, ['pseudo', 'maison', 'created_at'])) {
    $tri = 'pseudo';
}

$sql = "SELECT * FROM users ORDER BY $tri ASC";
$stmt = $pdo->query($sql);

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des sorciers inscrits 🧙‍♂️</h2>

<a href="?tri=pseudo">Trier par pseudo</a> |
<a href="?tri=maison">Trier par maison</a> |
<a href="?tri=created_at">Trier par date</a>

<?php foreach ($users as $user): ?>

    <div style="border:1px solid #ccc; padding:10px; margin:10px;">

        <h3>🧙 <?= htmlspecialchars($user['pseudo']) ?></h3>

        <p>📧 Email : <?= htmlspecialchars($user['email']) ?></p>

        <p>🏰 Maison : <?= htmlspecialchars($user['maison']) ?></p>

        <p>✨ Centres d’intérêt : <?= htmlspecialchars($user['interets']) ?></p>

        <p>📅 Inscrit le : <?= $user['created_at'] ?></p>

    </div>

<?php endforeach; ?>