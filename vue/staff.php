<h1>Staff</h1>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="staff">
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
<form method="post" action="index.php?page=staff&action=store">
    <div class="grid">
        <label>Nom
            <input type="text" name="nom" required>
        </label>
        <label>Prenom
            <input type="text" name="prenom" required>
        </label>
        <label>Date de naissance
            <input type="date" name="dateNaissanceStaff" required>
        </label>
        <label>Specialite
            <input type="text" name="specialite" required>
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
    <button type="submit">Ajouter</button>
</form>
<?php endif; ?>

<?php $canAdmin = ($currentUser['droits'] ?? null) === ROLE_ADMIN; ?>
<table>
    <thead>
    <tr>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Naissance</th>
        <th>Specialite</th>
        <th>Nationalite</th>
        <th>Club</th>
        <?php if ($canAdmin): ?>
            <th>Actions</th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($staff as $personne): ?>
        <tr>
            <td><?= $personne['nom'] ?></td>
            <td><?= $personne['prenom'] ?></td>
            <td><?= $personne['dateNaissanceStaff'] ?></td>
            <td><?= $personne['specialite'] ?></td>
            <td><?= $personne['nationalite'] ?></td>
            <td><?= $personne['clubNom'] ?? '' ?></td>
            <?php if ($canAdmin): ?>
            <td class="actions">
                <details>
                    <summary>Modifier</summary>
                    <form method="post" action="index.php?page=staff&action=update">
                        <input type="hidden" name="idStaff" value="<?= $personne['idStaff'] ?>">
                        <label>Nom
                            <input type="text" name="nom" value="<?= htmlspecialchars($personne['nom']) ?>" required>
                        </label>
                        <label>Prenom
                            <input type="text" name="prenom" value="<?= htmlspecialchars($personne['prenom']) ?>" required>
                        </label>
                        <label>Date de naissance
                            <input type="date" name="dateNaissanceStaff" value="<?= htmlspecialchars($personne['dateNaissanceStaff']) ?>" required>
                        </label>
                        <label>Specialite
                            <input type="text" name="specialite" value="<?= htmlspecialchars($personne['specialite']) ?>" required>
                        </label>
                        <label>Nationalite
                            <input type="text" name="nationalite" value="<?= htmlspecialchars($personne['nationalite']) ?>" required>
                        </label>
                        <label>Club
                            <select name="idClub" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($clubs as $club): ?>
                                    <option value="<?= $club['idClub'] ?>" <?= ($personne['idClub'] ?? null) == $club['idClub'] ? 'selected' : '' ?>><?= $club['nom'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button type="submit">Sauvegarder</button>
                    </form>
                </details>
                <form method="post" action="index.php?page=staff&action=delete" onsubmit="return confirm('Supprimer ce membre du staff ?');">
                    <input type="hidden" name="idStaff" value="<?= $personne['idStaff'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

