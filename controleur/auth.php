<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../modele/Utilisateur.php';

function auth_index(): void
{
    controller_render('login');
}

function auth_login(): void
{
    $utilisateurModel = new Utilisateur();
    $data = controller_input($_POST, ['mail', 'motDePasse']);
    $user = $utilisateurModel->authenticate($data['mail'] ?? '', $data['motDePasse'] ?? '');
    if ($user) {
        $_SESSION['user'] = $user;
        controller_redirect('club');
        return;
    }

    $existing = $utilisateurModel->findAll();
    if (empty($existing) && !empty($data['mail']) && !empty($data['motDePasse'])) {
        $create = [
            'nom' => 'Admin',
            'prenom' => 'ParDefaut',
            'mail' => $data['mail'],
            'motDePasse' => $data['motDePasse'],
            'dateInscription' => date('Y-m-d'),
            'droits' => ROLE_ADMIN,
        ];
        $id = $utilisateurModel->create($create);
        if ($id) {
            $user = $utilisateurModel->findById($id);
            $_SESSION['user'] = $user;
            controller_redirect('club');
            return;
        }
    }

    controller_render('login', ['error' => 'Identifiants invalides']);
}

function auth_registerForm(): void
{
    controller_render('register');
}

function auth_register(): void
{
    $utilisateurModel = new Utilisateur();
    $data = controller_input($_POST, ['nom', 'prenom', 'mail', 'motDePasse']);
    if (empty($data['mail']) || empty($data['motDePasse'])) {
        controller_render('register', ['error' => 'Champs requis manquants']);
        return;
    }
    $data['droits'] = ROLE_USER;
    $data['dateInscription'] = date('Y-m-d');
    $userId = $utilisateurModel->create($data);
    if ($userId) {
        $user = $utilisateurModel->findById($userId);
        $_SESSION['user'] = $user;
        controller_redirect('club');
    } else {
        controller_render('register', ['error' => 'Creation du compte impossible']);
    }
}

function auth_logout(): void
{
    session_destroy();
    controller_redirect('auth');
}
