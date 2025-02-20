<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Services/Database.php';
require_once __DIR__ . '/../src/Services/Security.php';
require_once __DIR__ . '/../src/Services/Session.php';

// Chargement automatique des classes
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../src/Controllers/',
        __DIR__ . '/../src/Models/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Récupération de l'URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Routes
try {
    switch ($uri) {
        case '':
            require __DIR__ . '/../views/home.php';
            break;

        case 'login':
            $controller = new AuthController();
            $controller->login();
            break;

        case 'register':
            $controller = new AuthController();
            $controller->register();
            break;

        case 'logout':
            $controller = new AuthController();
            $controller->logout();
            break;

        case 'profile':
            if (!Session::isLoggedIn()) {
                header('Location: /login');
                exit;
            }
            require __DIR__ . '/../views/profile/index.php';
            break;

        case 'profile/edit':
            if (!Session::isLoggedIn()) {
                header('Location: /login');
                exit;
            }
            require __DIR__ . '/../views/profile/edit.php';
            break;

        case 'projects':
            $controller = new ProjectController();
            $controller->index();
            break;

        case 'projects/create':
            $controller = new ProjectController();
            $controller->create();
            break;

        case 'skills':
            $controller = new SkillController();
            $controller->index();
            break;

        // Routes d'administration
        case 'admin':
            $controller = new AdminController();
            $controller->dashboard();
            break;

        case 'admin/skills':
            $controller = new AdminController();
            $controller->skills();
            break;

        case 'admin/users':
            $controller = new AdminController();
            $controller->users();
            break;

        default:
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            break;
    }
} catch (Exception $e) {
    // Log de l'erreur
    error_log($e->getMessage());
    
    // Redirection vers une page d'erreur
    http_response_code(500);
    require __DIR__ . '/../views/error.php';
} 