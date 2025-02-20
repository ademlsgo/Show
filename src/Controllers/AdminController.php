<?php

class AdminController {
    private $userModel;
    private $projectModel;
    private $skillModel;

    public function __construct() {
        // Vérification des droits d'administration
        if (!Session::isLoggedIn() || !Session::isAdmin()) {
            Session::setFlash('error', 'Accès non autorisé');
            header('Location: /');
            exit;
        }

        $this->userModel = new User();
        $this->projectModel = new Project();
        $this->skillModel = new Skill();
    }

    public function dashboard() {
        // Récupération des statistiques
        $stats = $this->getStats();
        
        // Variables disponibles dans la vue
        $userCount = $stats['userCount'];
        $projectCount = $stats['projectCount'];
        $skillCount = $stats['skillCount'];

        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    private function getStats() {
        try {
            $db = Database::getInstance()->getConnection();
            
            // Nombre d'utilisateurs
            $userCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
            
            // Nombre de projets
            $projectCount = $db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
            
            // Nombre de compétences
            $skillCount = $db->query("SELECT COUNT(*) FROM skills")->fetchColumn();

            return [
                'userCount' => $userCount,
                'projectCount' => $projectCount,
                'skillCount' => $skillCount
            ];
        } catch (PDOException $e) {
            // En cas d'erreur, retourner des valeurs par défaut
            return [
                'userCount' => 0,
                'projectCount' => 0,
                'skillCount' => 0
            ];
        }
    }

    public function editSkill() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/skills');
            exit;
        }

        if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
            Session::setFlash('error', 'Token de sécurité invalide');
            header('Location: /admin/skills');
            exit;
        }

        $skillId = filter_input(INPUT_POST, 'skill_id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

        if (!$skillId || !$name) {
            Session::setFlash('error', 'Données invalides');
            header('Location: /admin/skills');
            exit;
        }

        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE skills SET name = :name WHERE id = :id");
            $stmt->execute(['name' => $name, 'id' => $skillId]);

            Session::setFlash('success', 'Compétence mise à jour avec succès');
        } catch (PDOException $e) {
            Session::setFlash('error', 'Erreur lors de la mise à jour de la compétence');
        }

        header('Location: /admin/skills');
        exit;
    }

    public function deleteSkill($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/skills');
            exit;
        }

        if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
            Session::setFlash('error', 'Token de sécurité invalide');
            header('Location: /admin/skills');
            exit;
        }

        try {
            $db = Database::getInstance()->getConnection();
            
            // Supprimer d'abord les relations dans user_skills
            $stmt = $db->prepare("DELETE FROM user_skills WHERE skill_id = :id");
            $stmt->execute(['id' => $id]);
            
            // Puis supprimer la compétence
            $stmt = $db->prepare("DELETE FROM skills WHERE id = :id");
            $stmt->execute(['id' => $id]);

            Session::setFlash('success', 'Compétence supprimée avec succès');
        } catch (PDOException $e) {
            Session::setFlash('error', 'Erreur lors de la suppression de la compétence');
        }

        header('Location: /admin/skills');
        exit;
    }

    public function users() {
        try {
            $db = Database::getInstance()->getConnection();
            $users = $db->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
            require_once __DIR__ . '/../../views/admin/users.php';
        } catch (PDOException $e) {
            Session::setFlash('error', 'Erreur lors de la récupération des utilisateurs');
            header('Location: /admin/dashboard');
            exit;
        }
    }

    public function updateUserRole() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/users');
            exit;
        }

        if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
            Session::setFlash('error', 'Token de sécurité invalide');
            header('Location: /admin/users');
            exit;
        }

        $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        if (!$userId || !in_array($role, ['user', 'admin'])) {
            Session::setFlash('error', 'Données invalides');
            header('Location: /admin/users');
            exit;
        }

        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE users SET role = :role WHERE id = :id");
            $stmt->execute(['role' => $role, 'id' => $userId]);

            Session::setFlash('success', 'Rôle de l\'utilisateur mis à jour avec succès');
        } catch (PDOException $e) {
            Session::setFlash('error', 'Erreur lors de la mise à jour du rôle');
        }

        header('Location: /admin/users');
        exit;
    }
} 