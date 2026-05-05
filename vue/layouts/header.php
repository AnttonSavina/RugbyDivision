<?php
require_once __DIR__ . '/../../controleur/helpers.php';

$pages = [
    'club' => 'Clubs',
    'joueur' => 'Joueurs',
    'matchRugby' => 'Matchs',
    'stade' => 'Stades',
    'staff' => 'Staff',
    'arbitre' => 'Arbitres',
    'transfert' => 'Transferts',
    'statistiques' => 'Statistiques',
    'utilisateurs' => 'Utilisateurs',
];
function canSeeAdmin(array $user = null): bool {
    return $user && (int)$user['droits'] === ROLE_ADMIN;
}
function canSeeStaff(array $user = null): bool {
    return $user && ((int)$user['droits'] === ROLE_STAFF || (int)$user['droits'] === ROLE_ADMIN);
}
function canSeeArbitre(array $user = null): bool {
    return $user && (int)$user['droits'] === ROLE_ARBITRE;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rugby Division</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<header>
    <nav>
        <?php
            // Rôle courant : visiteur = ROLE_USER
            $role = isset($currentUser['droits']) ? (int)$currentUser['droits'] : ROLE_USER;
        ?>
        <?php foreach ($pages as $key => $label): ?>
            <?php
                $isUser = $role === ROLE_USER;
                if ($isUser && !in_array($key, ['club', 'matchRugby', 'transfert'], true)) {
                    continue;
                }
                // Rôle arbitre : n'affiche que matchs et arbitre
                if (canSeeArbitre($currentUser ?? null)) {
                    if (!in_array($key, ['matchRugby', 'arbitre'], true)) {
                        continue;
                    }
                }

                // hide admin-only links when non-admin (except arbitre link which arbitre role can see)
                if (in_array($key, ['utilisateurs', 'arbitre', 'stade', 'staff', 'club', 'joueur']) && !canSeeAdmin($currentUser ?? null)) {
                    // let arbitre role see the arbitre page
                    if ($key === 'arbitre' && canSeeArbitre($currentUser ?? null)) {
                        // ok
                    } elseif (in_array($key, ['club', 'joueur'])) {
                        // public
                    } elseif ($key === 'staff') {
                        // staff listing read is ok
                    } else {
                        continue;
                    }
                }
                if (in_array($key, ['matchRugby', 'transfert', 'statistiques']) && !canSeeStaff($currentUser ?? null)) {
                    // allow viewing anyway; forms inside are guarded
                }
            ?>
            <a href="index.php?page=<?= $key ?>" class="<?= (($_GET['page'] ?? 'club') === $key) ? 'active' : '' ?>"><?= $label ?></a>
        <?php endforeach; ?>
        <?php if ($currentUser ?? null): ?>
            <?php
                $roleLabel = '';
                switch ((int)($currentUser['droits'] ?? -1)) {
                    case ROLE_ADMIN: $roleLabel = 'admin'; break;
                    case ROLE_STAFF: $roleLabel = 'staff'; break;
                    case ROLE_ARBITRE: $roleLabel = 'arbitre'; break;
                    default: $roleLabel = 'user'; break;
                }
            ?>
            <span class="user-info">
                <?= htmlspecialchars(($currentUser['prenom'] ?? '') . ' ' . ($currentUser['nom'] ?? '')) ?> (<?= $roleLabel ?>)
            </span>
            <a class="logout-link" href="index.php?page=auth&action=logout">Deconnexion</a>
        <?php else: ?>
            <a class="auth-link" href="index.php?page=auth">Connexion</a>
            <a class="auth-link" href="index.php?page=auth&action=registerForm">Inscription</a>
        <?php endif; ?>
    </nav>
</header>
<main>
