<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/Joueur.php';
require_once __DIR__ . '/../modele/Club.php';

function joueur_index(): void
{
    $joueurModel = new Joueur();
    $clubModel = new Club();

    $selectedClub = isset($_GET['club']) ? (int)$_GET['club'] : null;
    if ($selectedClub) {
        $joueurs = $joueurModel->findByClub($selectedClub);
    } else {
        $joueurs = $joueurModel->findWithClub();
    }
    $clubs = $clubModel->findAll('nom');

    controller_render('joueur', [
        'joueurs' => $joueurs,
        'clubs' => $clubs,
        'selectedClub' => $selectedClub,
    ]);
}

function joueur_store(): void
{
    controller_require_role([ROLE_ADMIN]);
    $data = controller_input($_POST, ['nom', 'prenom', 'dateNaissance', 'poste', 'nationalite', 'idClub']);
    (new Joueur())->create($data);
    controller_redirect('joueur');
}

function joueur_update(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (!isset($_POST['idJoueur'])) {
        controller_redirect('joueur');
    }
    $data = controller_input($_POST, ['nom', 'prenom', 'dateNaissance', 'poste', 'nationalite', 'idClub']);
    (new Joueur())->update((int)$_POST['idJoueur'], $data);
    controller_redirect('joueur');
}

function joueur_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idJoueur'])) {
        (new Joueur())->delete($_POST['idJoueur']);
    }
    controller_redirect('joueur');
}
