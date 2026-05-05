<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/FaitObjetDeTransfert.php';
require_once __DIR__ . '/../modele/Joueur.php';
require_once __DIR__ . '/../modele/Club.php';

function transfert_index(): void
{
    $transfertModel = new FaitObjetDeTransfert();
    $joueurModel = new Joueur();
    $clubModel = new Club();

    $selectedClub = isset($_GET['club']) ? (int)$_GET['club'] : null;
    if ($selectedClub) {
        $transferts = $transfertModel->findWithDetailsByClub($selectedClub);
    } else {
        $transferts = $transfertModel->findWithDetails();
    }
    $joueurs = $joueurModel->findAll('nom');
    $clubs = $clubModel->findAll('nom');

    controller_render('transfert', [
        'transferts' => $transferts,
        'joueurs' => $joueurs,
        'clubs' => $clubs,
        'selectedClub' => $selectedClub,
    ]);
}

function transfert_store(): void
{
    controller_require_role([ROLE_STAFF, ROLE_ADMIN]);
    $transfertModel = new FaitObjetDeTransfert();
    $joueurModel = new Joueur();
    $clubModel = new Club();

    $data = controller_input($_POST, ['idJoueur', 'idClub', 'dateTransfert']);
    $validatedDate = transfert_validateDate($data['dateTransfert'] ?? '');
    if ($validatedDate === null) {
        $transferts = $transfertModel->findWithDetails();
        $joueurs = $joueurModel->findAll('nom');
        $clubs = $clubModel->findAll('nom');
        controller_render('transfert', [
            'transferts' => $transferts,
            'joueurs' => $joueurs,
            'clubs' => $clubs,
            'selectedClub' => null,
            'error' => 'Date invalide. Format attendu : 2024-2025 avec annee <= ' . ((int)date('Y') + 1),
        ]);
        return;
    }

    $data['dateTransfert'] = $validatedDate;
    $transfertModel->create($data);

    if (!empty($data['idJoueur']) && !empty($data['idClub'])) {
        $joueurModel->update((int)$data['idJoueur'], ['idClub' => (int)$data['idClub']]);
    }
    controller_redirect('transfert');
}

function transfert_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idTransfert'])) {
        (new FaitObjetDeTransfert())->delete($_POST['idTransfert']);
    }
    controller_redirect('transfert');
}

function transfert_validateDate(string $value): ?string
{
    $value = trim($value);
    if ($value === '') {
        return null;
    }

    if (!preg_match('/^\d{4}(?:-\d{4})?$/', $value)) {
        return null;
    }

    $year1 = (int)substr($value, 0, 4);
    $year2 = strlen($value) > 4 ? (int)substr($value, 5, 4) : null;
    $currentYear = (int)date('Y');

    if ($year1 < 1900 || $year1 > $currentYear + 1) {
        return null;
    }
    if ($year2 !== null) {
        if ($year2 !== $year1 + 1) {
            return null;
        }
        if ($year2 > $currentYear + 1) {
            return null;
        }
    }

    return $value;
}
