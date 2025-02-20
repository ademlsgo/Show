<?php

class SkillController {
    private $skillModel;

    public function __construct() {
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        $this->skillModel = new Skill();
    }

    public function index() {
        $userId = Session::get('user_id');
        $availableSkills = $this->skillModel->getAllSkills();
        $userSkills = [];
        
        $userSkillsData = $this->skillModel->getUserSkills($userId);
        foreach ($userSkillsData as $skill) {
            $userSkills[$skill['id']] = $skill['level'];
        }

        require_once __DIR__ . '/../../views/skills/index.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /skills');
            exit;
        }

        if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
            Session::setFlash('error', 'Token de sécurité invalide');
            header('Location: /skills');
            exit;
        }

        $userId = Session::get('user_id');
        $skills = $_POST['skills'] ?? [];

        foreach ($skills as $skillId => $level) {
            if (!empty($level)) {
                $this->skillModel->updateUserSkill($userId, $skillId, $level);
            }
        }

        Session::setFlash('success', 'Compétences mises à jour avec succès');
        header('Location: /skills');
        exit;
    }

    // Méthodes spécifiques à l'administrateur
    public function admin() {
        if (!Session::isAdmin()) {
            Session::setFlash('error', 'Accès non autorisé');
            header('Location: /');
            exit;
        }

        $skills = $this->skillModel->getAllSkills();
        require_once __DIR__ . '/../../views/admin/skills.php';
    }

    public function addSkill() {
        if (!Session::isAdmin()) {
            Session::setFlash('error', 'Accès non autorisé');
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
                Session::setFlash('error', 'Token de sécurité invalide');
                header('Location: /admin/skills');
                exit;
            }

            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            if (!$name) {
                Session::setFlash('error', 'Le nom de la compétence est requis');
                header('Location: /admin/skills');
                exit;
            }

            if ($this->skillModel->addSkill($name)) {
                Session::setFlash('success', 'Compétence ajoutée avec succès');
            } else {
                Session::setFlash('error', 'Erreur lors de l\'ajout de la compétence');
            }

            header('Location: /admin/skills');
            exit;
        }
    }

    public function deleteSkill($id) {
        if (!Session::isAdmin()) {
            Session::setFlash('error', 'Accès non autorisé');
            header('Location: /');
            exit;
        }

        if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
            Session::setFlash('error', 'Token de sécurité invalide');
            header('Location: /admin/skills');
            exit;
        }

        if ($this->skillModel->deleteSkill($id)) {
            Session::setFlash('success', 'Compétence supprimée avec succès');
        } else {
            Session::setFlash('error', 'Erreur lors de la suppression de la compétence');
        }

        header('Location: /admin/skills');
        exit;
    }
} 