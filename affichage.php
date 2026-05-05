<?php
require 'connexion.php';

$colonnes_autorisees = ['pseudo', 'email', 'maison', 'interets'];
$tri   = in_array($_GET['tri'] ?? '', $colonnes_autorisees) ? $_GET['tri'] : 'pseudo';
$ordre = ($_GET['ordre'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

$stmt  = $pdo->query("SELECT id, pseudo, email, maison, interets FROM users ORDER BY $tri $ordre");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<a href="?tri=pseudo&ordre=ASC">Trier par Pseudo</a> |
<a href="?tri=maison&ordre=ASC">Trier par Maison</a> |
<a href="?tri=email&ordre=ASC">Trier par Email</a>

<table border="1">
    <tr>
        <th>Pseudo</th>
        <th>Email</th>
        <th>Maison</th>
        <th>Intérêts</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['pseudo'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['maison'] ?></td>
        <td><?= $user['interets'] ?></td>
        <td>
            <a href="modifier.php?id=<?= $user['id'] ?>">✏️ Modifier</a>
            <a href="supprimer.php?id=<?= $user['id'] ?>">🗑️ Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>