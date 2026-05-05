<h1>Arbitres</h1>

<?php if (($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
<form method="post" action="index.php?page=arbitre&action=store">
    <div class="grid">
        <label>Nom
            <input type="text" name="nom" required>
        </label>
        <label>Prenom
            <input type="text" name="prenom" required>
        </label>
        <label>Date de naissance
            <input type="date" name="dateNaissance" required>
        </label>
        <label>Nationalite
            <input type="text" name="nationalite" required>
        </label>
        <label>Categorie
            <input type="text" name="categorie" required>
        </label>
    </div>
    <button type="submit">Ajouter</button>
</form>
<?php endif; ?>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Naissance</th>
        <th>Nationalite</th>
        <th>Categorie</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($arbitres as $arbitre): ?>
        <tr>
            <td><?= $arbitre->idArbitre ?></td>
            <td><?= $arbitre->nom ?></td>
            <td><?= $arbitre->prenom ?></td>
            <td><?= $arbitre->dateNaissance ?></td>
            <td><?= $arbitre->nationalite ?></td>
            <td><?= $arbitre->categorie ?></td>
            <td class="actions">
                <?php if (($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
                <form method="post" action="index.php?page=arbitre&action=delete" onsubmit="return confirm('Supprimer cet arbitre ?');">
                    <input type="hidden" name="idArbitre" value="<?= $arbitre->idArbitre ?>">
                    <button type="submit">Supprimer</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

