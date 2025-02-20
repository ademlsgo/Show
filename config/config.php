<?php

// Configuration de l'application
define('APP_NAME', 'Show Portfolio');
define('APP_ENV', 'development'); // 'development' ou 'production'
define('APP_URL', 'http://show.local');

// Configuration des uploads
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Configuration de la sécurité
define('CSRF_TOKEN_TIME', 3600); // Durée de validité du token CSRF (1 heure)
define('PASSWORD_MIN_LENGTH', 8);
define('SESSION_LIFETIME', 7200); // Durée de la session (2 heures)

// Messages d'erreur
define('ERROR_MESSAGES', [
    'invalid_credentials' => 'Email ou mot de passe incorrect',
    'email_exists' => 'Cet email est déjà utilisé',
    'username_exists' => 'Ce nom d\'utilisateur est déjà utilisé',
    'password_too_short' => 'Le mot de passe doit contenir au moins ' . PASSWORD_MIN_LENGTH . ' caractères',
    'passwords_dont_match' => 'Les mots de passe ne correspondent pas',
    'invalid_file_type' => 'Type de fichier non autorisé',
    'file_too_large' => 'Le fichier est trop volumineux (max ' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB)',
    'upload_failed' => 'Échec de l\'upload du fichier',
    'not_authorized' => 'Vous n\'êtes pas autorisé à effectuer cette action',
    'invalid_token' => 'Token de sécurité invalide'
]);

// Configuration des routes protégées
define('PROTECTED_ROUTES', [
    'profile',
    'projects',
    'skills'
]);

// Configuration des routes d'administration
define('ADMIN_ROUTES', [
    'admin',
    'admin/users',
    'admin/skills'
]);

// Initialisation de la session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', APP_ENV === 'production' ? 1 : 0);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
session_set_cookie_params(SESSION_LIFETIME);

// Configuration des en-têtes de sécurité
if (APP_ENV === 'production') {
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: same-origin');
    header('Content-Security-Policy: default-src \'self\'; img-src \'self\' data: https:; style-src \'self\' \'unsafe-inline\';');
}

// Gestion des erreurs
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Fonction d'autoload personnalisée
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../src/Controllers/',
        __DIR__ . '/../src/Models/',
        __DIR__ . '/../src/Services/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
}); 