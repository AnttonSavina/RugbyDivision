<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/Club.php';
require_once __DIR__ . '/../modele/Stade.php';
require_once __DIR__ . '/../modele/Joueur.php';
require_once __DIR__ . '/../modele/Staff.php';
require_once __DIR__ . '/../modele/MatchRugby.php';
require_once __DIR__ . '/../modele/Oppose.php';

function club_index(): void
{
    $clubModel = new Club();
    $stadeModel = new Stade();
    $joueurModel = new Joueur();
    $staffModel = new Staff();
    $matchModel = new MatchRugby();
    $opposeModel = new Oppose();

    $selectedClub = isset($_GET['club']) ? (int)$_GET['club'] : null;
    $activeClub = null;
    $clubs = $clubModel->findWithStade();
    $joueurs = [];
    $staff = [];
    $matches = [];
    $oppositions = [];

    if ($selectedClub) {
        $activeClub = array_values(array_filter($clubs, fn($c) => (int)$c['idClub'] === $selectedClub))[0] ?? null;
        if ($activeClub) {
            $joueurs = $joueurModel->findByClub($selectedClub);
            $staff = $staffModel->findByClub($selectedClub);
            $matches = $matchModel->findWithDetailsByClub($selectedClub);
            foreach ($matches as $m) {
                $oppositions[$m['idMatch']] = $opposeModel->findByMatch((int)$m['idMatch']);
            }
        }
    }

    $stades = $stadeModel->findAll('nom');
    controller_render('club', [
        'clubs' => $clubs,
        'activeClub' => $activeClub,
        'stades' => $stades,
        'selectedClub' => $selectedClub,
        'joueursClub' => $joueurs,
        'staffClub' => $staff,
        'matchesClub' => $matches,
        'oppositions' => $oppositions,
    ]);
}

function club_store(): void
{
    controller_require_role([ROLE_ADMIN]);
    $data = controller_input($_POST, ['nom', 'ville', 'anneeCreation', 'idStade']);
    (new Club())->create($data);
    controller_redirect('club');
}

function club_update(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (!isset($_POST['idClub'])) {
        controller_redirect('club');
    }
    $data = controller_input($_POST, ['nom', 'ville', 'anneeCreation', 'idStade']);
    (new Club())->update((int)$_POST['idClub'], $data);
    controller_redirect('club');
}

function club_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idClub'])) {
        (new Club())->delete($_POST['idClub']);
    }
    controller_redirect('club');
}
