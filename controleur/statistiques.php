<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/Produit_Stat.php';
require_once __DIR__ . '/../modele/Joueur.php';
require_once __DIR__ . '/../modele/MatchRugby.php';
require_once __DIR__ . '/../modele/Oppose.php';

function statistiques_index(): void
{
    $statModel = new Produit_Stat();
    $joueurModel = new Joueur();
    $matchModel = new MatchRugby();
    $opposeModel = new Oppose();

    $matches = $matchModel->findAll('dateMatch DESC');
    $selectedMatch = isset($_GET['match']) ? (int)$_GET['match'] : null;
    $joueurs = $selectedMatch ? $joueurModel->findByMatch($selectedMatch) : [];

    $statsByMatch = [];
    $oppositions = [];
    foreach ($matches as $match) {
        $statsByMatch[$match['idMatch']] = $statModel->findByMatch((int)$match['idMatch']);
        $oppositions[$match['idMatch']] = $opposeModel->findByMatch((int)$match['idMatch']);
    }

    controller_render('statistiques', [
        'matches' => $matches,
        'joueurs' => $joueurs,
        'statsByMatch' => $statsByMatch,
        'selectedMatch' => $selectedMatch,
        'oppositions' => $oppositions,
    ]);
}

function statistiques_store(): void
{
    controller_require_role([ROLE_STAFF, ROLE_ADMIN]);
    $statModel = new Produit_Stat();
    $joueurModel = new Joueur();

    $data = controller_input($_POST, [
        'idJoueur',
        'idMatch',
        'points',
        'essais',
        'transformations',
        'drops',
        'cartonsJaunes',
        'cartonsRouges',
    ]);

    if (empty($data['idMatch']) || empty($data['idJoueur']) || !statistiques_playerInMatch($joueurModel, (int)$data['idJoueur'], (int)$data['idMatch'])) {
        controller_redirect('statistiques');
        return;
    }

    $statModel->upsert($data);
    controller_redirect('statistiques');
}

function statistiques_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idJoueur'], $_POST['idMatch'])) {
        (new Produit_Stat())->deleteByKeys((int)$_POST['idJoueur'], (int)$_POST['idMatch']);
    }
    controller_redirect('statistiques');
}

function statistiques_playerInMatch(Joueur $joueurModel, int $playerId, int $matchId): bool
{
    $players = $joueurModel->findByMatch($matchId);
    foreach ($players as $p) {
        if ((int)$p['idJoueur'] === $playerId) {
            return true;
        }
    }
    return false;
}
