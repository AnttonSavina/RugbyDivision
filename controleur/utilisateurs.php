<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/Utilisateur.php';

function utilisateurs_index(): void
{
    controller_require_role([ROLE_ADMIN]);
    $utilisateurs = (new Utilisateur())->findAll('nom');
    controller_render('utilisateurs', ['utilisateurs' => $utilisateurs]);
}

function utilisateurs_store(): void
{
    controller_require_role([ROLE_ADMIN]);
    $data = controller_input($_POST, ['nom', 'prenom', 'mail', 'motDePasse', 'dateInscription', 'droits']);
    (new Utilisateur())->create($data);
    controller_redirect('utilisateurs');
}

function utilisateurs_updateRole(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idUtilisateur'], $_POST['droits'])) {
        (new Utilisateur())->updateRole((int)$_POST['idUtilisateur'], (int)$_POST['droits']);
    }
    controller_redirect('utilisateurs');
}

function utilisateurs_delete(): void
{
    controller_require_role([ROLE_ADMIN]);
    if (isset($_POST['idUtilisateur'])) {
        (new Utilisateur())->delete($_POST['idUtilisateur']);
    }
    controller_redirect('utilisateurs');
}
