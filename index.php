<?php

// Debug temporaire : affiche les erreurs PHP au lieu d'une page blanche.
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/controleur/helpers.php';

$routes = [
    // page => fichier contrôleur procédural (sans extension)
    'club' => 'club',
    'joueur' => 'joueur',
    'matchRugby' => 'matchRugby',
    'stade' => 'stade',
    'staff' => 'staff',
    'utilisateurs' => 'utilisateurs',
    'arbitre' => 'arbitre',
    'transfert' => 'transfert',
    'statistiques' => 'statistiques',
    'auth' => 'auth',
];

$page = $_GET['page'] ?? 'club';
$action = $_GET['action'] ?? 'index';

$user = $_SESSION['user'] ?? null;
// Applique les restrictions : un visiteur non connecte est traite comme ROLE_USER
$role = $user['droits'] ?? ROLE_USER;
if ($role === ROLE_USER) {
    $allowed = ['club', 'matchRugby', 'transfert', 'auth'];
    if (!in_array($page, $allowed, true)) {
        $page = 'club';
        $action = 'index';
    }
}
if ($role === ROLE_ARBITRE) {
    $allowed = ['matchRugby', 'arbitre', 'auth'];
    if (!in_array($page, $allowed, true)) {
        $page = 'matchRugby';
        $action = 'index';
    }
}

if (!array_key_exists($page, $routes)) {
    http_response_code(404);
    echo "Page {$page} inconnue";
    exit;
}

require_once __DIR__ . '/controleur/' . $routes[$page] . '.php';

$fn = $page . '_' . $action; // ex: arbitre_index
if (!function_exists($fn)) {
    $fn = $page . '_index';
}
$fn();
