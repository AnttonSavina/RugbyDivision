<h1>Connexion</h1>

<?php if (!empty($error)): ?>
    <div class="error-text"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="index.php?page=auth&action=login">
    <label>Email
        <input type="email" name="mail" required>
    </label>
    <label>Mot de passe
        <input type="password" name="motDePasse" required>
    </label>
    <button type="submit">Se connecter</button>
</form>

<p>Pas de compte ? <a href="index.php?page=auth&action=registerForm">Inscription</a></p>

