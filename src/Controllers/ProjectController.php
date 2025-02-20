<?php

class ProjectController {
    private $projectModel;

    public function __construct() {
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        $this->projectModel = new Project();
    }

    public function index() {
        $userId = Session::get('user_id');
        $projects = $this->projectModel->getUserProjects($userId);
        require_once __DIR__ . '/../../views/projects/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
                Session::setFlash('error', 'Token de sécurité invalide');
                header('Location: /projects/create');
                exit;
            }

            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $externalLink = filter_input(INPUT_POST, 'external_link', FILTER_SANITIZE_URL);

            if (!$title || !$description) {
                Session::setFlash('error', 'Le titre et la description sont requis');
                header('Location: /projects/create');
                exit;
            }

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
                if (!$imagePath) {
                    Session::setFlash('error', 'Erreur lors de l\'upload de l\'image');
                    header('Location: /projects/create');
                    exit;
                }
            }

            if ($this->projectModel->create(Session::get('user_id'), $title, $description, $imagePath, $externalLink)) {
                Session::setFlash('success', 'Projet créé avec succès');
                header('Location: /projects');
                exit;
            }

            Session::setFlash('error', 'Erreur lors de la création du projet');
            header('Location: /projects/create');
            exit;
        }

        require_once __DIR__ . '/../../views/projects/create.php';
    }

    private function handleImageUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $uploadDir = __DIR__ . '/../../public/uploads/projects/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return '/uploads/projects/' . $fileName;
        }

        return false;
    }

    public function edit($id) {
        $userId = Session::get('user_id');
        $project = $this->projectModel->getProject($id);

        if (!$project || $project['user_id'] !== $userId) {
            Session::setFlash('error', 'Projet non trouvé');
            header('Location: /projects');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Logique similaire à create() pour la mise à jour
            // À implémenter selon vos besoins
        }

        require_once __DIR__ . '/../../views/projects/edit.php';
    }

    public function delete($id) {
        if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
            Session::setFlash('error', 'Token de sécurité invalide');
            header('Location: /projects');
            exit;
        }

        $userId = Session::get('user_id');
        if ($this->projectModel->delete($id, $userId)) {
            Session::setFlash('success', 'Projet supprimé avec succès');
        } else {
            Session::setFlash('error', 'Erreur lors de la suppression du projet');
        }

        header('Location: /projects');
        exit;
    }
} 