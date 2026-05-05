<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/MatchRugby.php';
require_once __DIR__ . '/../modele/Oppose.php';
require_once __DIR__ . '/../modele/Club.php';
require_once __DIR__ . '/../modele/Stade.php';
require_once __DIR__ . '/../modele/Arbitre.php';

function matchRugby_index(): void
{
    $matchModel = new MatchRugby();
    $opposeModel = new Oppose();
    $clubModel = new Club();
    $stadeModel = new Stade();
    $arbitreModel = new Arbitre();

    $selectedDate = $_GET['date'] ?? null;
    if ($selectedDate) {
        $matches = $matchModel->findWithDetailsByDate($selectedDate);
    } else {
        $matches = $matchModel->findWithDetails();
    }
    $clubs = $clubModel->findAll('nom');
    $stades = $stadeModel->findAll('nom');
    $arbitres = $arbitreModel->findAll('nom');

    $currentArbitre = null;
    $user = controller_current_user();
    if ($user && (int)($user['droits'] ?? -1) === ROLE_ARBITRE) {
        $currentArbitre = $arbitreModel->findByFullName($user['nom'] ?? '', $user['prenom'] ?? '');
    }

    $withOppositions = [];
    foreach ($matches as $match) {
        $withOppositions[$match['idMatch']] = $opposeModel->findByMatch((int)$match['idMatch']);
    }

    controller_render('matchRugby', [
        'matches' => $matches,
        'clubs' => $clubs,
        'stades' => $stades,
        'arbitres' => $arbitres,
        'oppositions' => $withOppositions,
        'selectedDate' => $selectedDate,
        'currentArbitre' => $currentArbitre,
    ]);
}

function matchRugby_store(): void
{
    controller_require_role([ROLE_STAFF, ROLE_ADMIN]);
    $matchModel = new MatchRugby();
    $opposeModel = new Oppose();

    $data = controller_input($_POST, ['dateMatch', 'heure', 'scoreDomicile', 'scoreExterieur', 'annee', 'division', 'idStade', 'idArbitre']);
    if (!empty($data['annee']) && !empty($data['division'])) {
        $matchModel->ensureSaisonExists($data['annee'], $data['division']);
    }
    $matchId = $matchModel->create($data);

    if ($matchId) {
        $domicile = $_POST['clubDomicile'] ?? null;
        $exterieur = $_POST['clubExterieur'] ?? null;
        if ($domicile) {
            $opposeModel->addClubToMatch((int)$matchId, (int)$domicile, 'domicile');
        }
        if ($exterieur) {
            $opposeModel->addClubToMatch((int)$matchId, (int)$exterieur, 'exterieur');
        }
    }

    controller_redirect('matchRugby');
}

function matchRugby_update(): void
{
    controller_require_role([ROLE_STAFF, ROLE_ADMIN, ROLE_ARBITRE]);
    if (!isset($_POST['idMatch'])) {
        controller_redirect('matchRugby');
    }

    $matchId = (int)$_POST['idMatch'];
    $matchModel = new MatchRugby();
    $opposeModel = new Oppose();
    $role = (int)(controller_current_user()['droits'] ?? -1);
    $isArbitre = ($role === ROLE_ARBITRE);

    if ($isArbitre) {
        $user = controller_current_user();
        $arbitre = (new Arbitre())->findByFullName($user['nom'] ?? '', $user['prenom'] ?? '');
        if ($arbitre) {
            $matchModel->update($matchId, ['idArbitre' => $arbitre->idArbitre]);
        }
    } else {
        $data = controller_input($_POST, ['dateMatch', 'heure', 'scoreDomicile', 'scoreExterieur', 'annee', 'division', 'idStade', 'idArbitre']);
        if (!empty($data['annee']) && !empty($data['division'])) {
            $matchModel->ensureSaisonExists($data['annee'], $data['division']);
        }
        $matchModel->update($matchId, $data);

        $domicile = $_POST['clubDomicile'] ?? null;
        $exterieur = $_POST['clubExterieur'] ?? null;
        if ($domicile || $exterieur) {
            $opposeModel->deleteByMatch($matchId);
            if ($domicile) {
                $opposeModel->addClubToMatch($matchId, (int)$domicile, 'domicile');
            }
            if ($exterieur) {
                $opposeModel->addClubToMatch($matchId, (int)$exterieur, 'exterieur');
            }
        }
    }

    controller_redirect('matchRugby');
}

function matchRugby_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idMatch'])) {
        $matchId = (int)$_POST['idMatch'];
        $opposeModel = new Oppose();
        $opposeModel->deleteByMatch($matchId);
        (new MatchRugby())->delete($matchId);
    }
    controller_redirect('matchRugby');
}
