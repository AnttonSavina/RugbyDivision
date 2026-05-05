<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/Arbitre.php';

function arbitre_index(): void
{
    $model = new Arbitre();
    $arbitres = $model->findAll('nom');
    controller_render('arbitre', ['arbitres' => $arbitres]);
}

function arbitre_store(): void
{
    controller_require_role([ROLE_ADMIN]);
    $data = controller_input($_POST, ['nom', 'prenom', 'dateNaissance', 'nationalite', 'categorie']);
    (new Arbitre())->create($data);
    controller_redirect('arbitre');
}

function arbitre_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idArbitre'])) {
        (new Arbitre())->delete($_POST['idArbitre']);
    }
    controller_redirect('arbitre');
}

