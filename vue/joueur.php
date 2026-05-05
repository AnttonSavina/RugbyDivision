<h1>Joueurs</h1>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="joueur">
    <label>Choisir un club
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

<?php if (($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
<form method="post" action="index.php?page=joueur&action=store">
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
        <label>Poste
            <input type="text" name="poste" required>
        </label>
        <label>Nationalite
            <input type="text" name="nationalite" required>
        </label>
        <label>Club
            <select name="idClub" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= $club['idClub'] ?>"><?= $club['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <button type="submit">Enregistrer</button>
</form>
<?php endif; ?>

<table>
    <thead>
    <tr>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Naissance</th>
        <th>Poste</th>
        <th>Nationalite</th>
        <th>Club</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($joueurs as $joueur): ?>
        <tr>
            <td><?= $joueur['nom'] ?></td>
            <td><?= $joueur['prenom'] ?></td>
            <td><?= $joueur['dateNaissance'] ?></td>
            <td><?= $joueur['poste'] ?></td>
            <td><?= $joueur['nationalite'] ?></td>
            <td><?= $joueur['clubNom'] ?? '' ?></td>
            <td class="actions">
                <?php if (($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
                <details>
                    <summary>Modifier</summary>
                    <form method="post" action="index.php?page=joueur&action=update">
                        <input type="hidden" name="idJoueur" value="<?= $joueur['idJoueur'] ?>">
                        <label>Nom
                            <input type="text" name="nom" value="<?= htmlspecialchars($joueur['nom']) ?>" required>
                        </label>
                        <label>Prenom
                            <input type="text" name="prenom" value="<?= htmlspecialchars($joueur['prenom']) ?>" required>
                        </label>
                        <label>Date de naissance
                            <input type="date" name="dateNaissance" value="<?= htmlspecialchars($joueur['dateNaissance']) ?>" required>
                        </label>
                        <label>Poste
                            <input type="text" name="poste" value="<?= htmlspecialchars($joueur['poste']) ?>" required>
                        </label>
                        <label>Nationalite
                            <input type="text" name="nationalite" value="<?= htmlspecialchars($joueur['nationalite']) ?>" required>
                        </label>
                        <label>Club
                            <select name="idClub" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($clubs as $club): ?>
                                    <option value="<?= $club['idClub'] ?>" <?= ($joueur['idClub'] ?? null) == $club['idClub'] ? 'selected' : '' ?>><?= $club['nom'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button type="submit">Sauvegarder</button>
                    </form>
                </details>
                <?php endif; ?>
                <?php if (($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
                <form method="post" action="index.php?page=joueur&action=delete" onsubmit="return confirm('Supprimer ce joueur ?');">
                    <input type="hidden" name="idJoueur" value="<?= $joueur['idJoueur'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

