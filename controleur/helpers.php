<?php

const ROLE_USER    = 0;
const ROLE_STAFF   = 1;
const ROLE_ADMIN   = 2;
const ROLE_ARBITRE = 3;

function controller_current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function controller_render(string $view, array $params = []): void
{
    $params['currentUser'] = controller_current_user();
    extract($params);
    $viewPath = __DIR__ . '/../vue/' . $view . '.php';
    require __DIR__ . '/../vue/layouts/header.php';
    require $viewPath;
    require __DIR__ . '/../vue/layouts/footer.php';
}

function controller_redirect(string $page): void
{
    header("Location: index.php?page={$page}");
    exit;
}

function controller_input(array $source, array $fields): array
{
    $data = [];
    foreach ($fields as $field) {
        if (isset($source[$field])) {
            $data[$field] = trim($source[$field]);
        }
    }
    return $data;
}

function controller_require_role(array $allowedRoles): void
{
    $user = controller_current_user();
    if (!$user || !in_array((int)$user['droits'], $allowedRoles, true)) {
        http_response_code(403);
        echo "Acces refuse";
        exit;
    }
}

