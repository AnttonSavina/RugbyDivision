<h1>Inscription</h1>

<?php if (!empty($error)): ?>
    <div class="error-text"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="index.php?page=auth&action=register">
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
    <button type="submit">Créer le compte</button>
</form>

<p>Deja un compte ? <a href="index.php?page=auth">Connexion</a></p>

