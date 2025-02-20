<?php

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            
            if (!$email || !$password) {
                Session::setFlash('error', 'Tous les champs sont requis');
                return false;
            }

            $user = $this->userModel->findByEmail($email);
            
            if ($user && Security::verifyPassword($password, $user['password'])) {
                Session::set('user_id', $user['id']);
                Session::set('user_role', $user['role']);
                Session::setFlash('success', 'Connexion réussie');
                header('Location: /dashboard');
                exit;
            }

            Session::setFlash('error', 'Identifiants invalides');
            return false;
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if (!$username || !$email || !$password) {
                Session::setFlash('error', 'Tous les champs sont requis');
                return false;
            }

            if ($password !== $passwordConfirm) {
                Session::setFlash('error', 'Les mots de passe ne correspondent pas');
                return false;
            }

            if ($this->userModel->findByEmail($email)) {
                Session::setFlash('error', 'Cet email est déjà utilisé');
                return false;
            }

            if ($this->userModel->create($username, $email, $password)) {
                Session::setFlash('success', 'Compte créé avec succès');
                header('Location: /login');
                exit;
            }

            Session::setFlash('error', 'Une erreur est survenue');
            return false;
        }
    }

    public function logout() {
        Session::destroy();
        header('Location: /');
        exit;
    }
} 