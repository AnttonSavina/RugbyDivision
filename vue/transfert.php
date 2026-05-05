<h1>Transferts</h1>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="transfert">
    <label>Choisir un club (destination)
        <select name="club" onchange="this.form.submit()">
            <option value="">-- Tous --</option>
            <?php foreach ($clubs as $club): ?>
                <option value="<?= $club['idClub'] ?>" <?= ($selectedClub ?? null) == $club['idClub'] ? 'selected' : '' ?>>
                    <?= $club['nom'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
</form>

<?php if (($currentUser['droits'] ?? null) === ROLE_STAFF || ($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
<?php if (!empty($error)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>
<form method="post" action="index.php?page=transfert&action=store">
    <div class="grid">
        <label>Joueur
            <select name="idJoueur" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($joueurs as $joueur): ?>
                    <option value="<?= $joueur['idJoueur'] ?>"><?= $joueur['nom'] . ' ' . $joueur['prenom'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Club destination
            <select name="idClub" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= $club['idClub'] ?>"><?= $club['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Date de transfert (ex: 2024-2025)
            <input type="text" name="dateTransfert" pattern="[0-9]{4}(-[0-9]{4})?" placeholder="2024-2025" required>
        </label>
    </div>
    <button type="submit">Enregistrer</button>
</form>
<?php endif; ?>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Joueur</th>
        <th>Club</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($transferts as $transfert): ?>
        <tr>
            <td><?= $transfert['idTransfert'] ?></td>
            <td><?= $transfert['joueurNom'] . ' ' . $transfert['joueurPrenom'] ?></td>
            <td><?= $transfert['clubNom'] ?></td>
            <td><?= $transfert['dateTransfert'] ?></td>
            <td class="actions">
                <?php if (($currentUser['droits'] ?? null) === ROLE_STAFF || ($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
                <form method="post" action="index.php?page=transfert&action=delete" onsubmit="return confirm('Supprimer ce transfert ?');">
                    <input type="hidden" name="idTransfert" value="<?= $transfert['idTransfert'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

