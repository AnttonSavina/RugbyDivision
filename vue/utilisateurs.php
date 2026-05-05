<h1>Utilisateurs</h1>

<form method="post" action="index.php?page=utilisateurs&action=store">
    <div class="grid">
        <label>Nom
            <input type="text" name="nom" required>
        </label>
        <label>Prenom
            <input type="text" name="prenom" required>
        </label>
        <label>Email
            <input type="email" name="mail" required>
        </label>
        <label>Mot de passe
            <input type="password" name="motDePasse" required>
        </label>
        <label>Date d'inscription
            <input type="date" name="dateInscription" required>
        </label>
        <label>Droits (0 user, 1 staff, 2 admin, 3 arbitre)
            <input type="number" name="droits" min="0" max="3" value="0" required>
        </label>
    </div>
    <button type="submit">Creer</button>
</form>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Droits</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($utilisateurs as $user): ?>
        <tr>
            <td><?= $user['idUtilisateur'] ?></td>
            <td><?= $user['nom'] ?></td>
            <td><?= $user['prenom'] ?></td>
            <td><?= $user['mail'] ?></td>
            <td><?= $user['droits'] ?></td>
            <td class="actions">
                <form method="post" action="index.php?page=utilisateurs&action=delete" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                    <input type="hidden" name="idUtilisateur" value="<?= $user['idUtilisateur'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
                <form method="post" action="index.php?page=utilisateurs&action=updateRole" class="mt-6">
                    <input type="hidden" name="idUtilisateur" value="<?= $user['idUtilisateur'] ?>">
                    <select name="droits">
                        <option value="0" <?= $user['droits'] == 0 ? 'selected' : '' ?>>User</option>
                        <option value="1" <?= $user['droits'] == 1 ? 'selected' : '' ?>>Staff</option>
                        <option value="2" <?= $user['droits'] == 2 ? 'selected' : '' ?>>Admin</option>
                        <option value="3" <?= $user['droits'] == 3 ? 'selected' : '' ?>>Arbitre</option>
                    </select>
                    <button type="submit">Role</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

