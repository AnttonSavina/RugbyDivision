<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/Staff.php';
require_once __DIR__ . '/../modele/Club.php';

function staff_index(): void
{
    $staffModel = new Staff();
    $clubModel = new Club();

    $selectedClub = isset($_GET['club']) ? (int)$_GET['club'] : null;
    if ($selectedClub) {
        $staff = $staffModel->findByClub($selectedClub);
    } else {
        $staff = $staffModel->findWithClub();
    }
    $clubs = $clubModel->findAll('nom');

    controller_render('staff', [
        'staff' => $staff,
        'clubs' => $clubs,
        'selectedClub' => $selectedClub,
    ]);
}

function staff_store(): void
{
    controller_require_role([ROLE_ADMIN]);
    $data = controller_input($_POST, ['nom', 'prenom', 'dateNaissanceStaff', 'specialite', 'nationalite', 'idClub']);
    (new Staff())->create($data);
    controller_redirect('staff');
}

function staff_update(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (!isset($_POST['idStaff'])) {
        controller_redirect('staff');
    }
    $data = controller_input($_POST, ['nom', 'prenom', 'dateNaissanceStaff', 'specialite', 'nationalite', 'idClub']);
    (new Staff())->update((int)$_POST['idStaff'], $data);
    controller_redirect('staff');
}

function staff_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idStaff'])) {
        (new Staff())->delete($_POST['idStaff']);
    }
    controller_redirect('staff');
}
