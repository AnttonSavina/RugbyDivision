<h1>Stades</h1>

<?php if (($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
<form method="post" action="index.php?page=stade&action=store">
    <div class="grid">
        <label>Nom
            <input type="text" name="nom" required>
        </label>
        <label>Ville
            <input type="text" name="ville" required>
        </label>
        <label>Capacite
            <input type="number" name="capacite" min="0" required>
        </label>
    </div>
    <button type="submit">Ajouter</button>
</form>
<?php endif; ?>

<table>
    <thead>
    <tr>
        <th>Nom</th>
        <th>Ville</th>
        <th>Capacite</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stades as $stade): ?>
        <tr>
            <td><?= $stade['nom'] ?></td>
            <td><?= $stade['ville'] ?></td>
            <td><?= $stade['capacite'] ?></td>
            <td class="actions">
                <?php if (in_array($currentUser['droits'] ?? -1, [ROLE_STAFF, ROLE_ADMIN], true)): ?>
                <details>
                    <summary>Modifier</summary>
                    <form method="post" action="index.php?page=stade&action=update">
                        <input type="hidden" name="idStade" value="<?= $stade['idStade'] ?>">
                        <label>Nom
                            <input type="text" name="nom" value="<?= htmlspecialchars($stade['nom']) ?>" required>
                        </label>
                        <label>Ville
                            <input type="text" name="ville" value="<?= htmlspecialchars($stade['ville']) ?>" required>
                        </label>
                        <label>Capacite
                            <input type="number" name="capacite" min="0" value="<?= htmlspecialchars($stade['capacite']) ?>" required>
                        </label>
                        <button type="submit">Sauvegarder</button>
                    </form>
                </details>
                <?php endif; ?>
                <?php if (($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
                <form method="post" action="index.php?page=stade&action=delete" onsubmit="return confirm('Supprimer ce stade ?');">
                    <input type="hidden" name="idStade" value="<?= $stade['idStade'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

