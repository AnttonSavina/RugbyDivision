<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/Stade.php';

function stade_index(): void
{
    $stades = (new Stade())->findAll('nom');
    controller_render('stade', ['stades' => $stades]);
}

function stade_store(): void
{
    controller_require_role([ROLE_ADMIN]);
    $data = controller_input($_POST, ['nom', 'ville', 'capacite']);
    (new Stade())->create($data);
    controller_redirect('stade');
}

function stade_update(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (!isset($_POST['idStade'])) {
        controller_redirect('stade');
    }
    $data = controller_input($_POST, ['nom', 'ville','capacite']);
    (new Stade())->update((int)$_POST['idStade'], $data);
    controller_redirect('stade');
}

function stade_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idStade'])) {
        (new Stade())->delete($_POST['idStade']);
    }
    controller_redirect('stade');
}
