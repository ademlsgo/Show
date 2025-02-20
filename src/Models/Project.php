<?php

class Project {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($userId, $title, $description, $imagePath = null, $externalLink = null) {
        $query = "INSERT INTO projects (user_id, title, description, image_path, external_link) 
                 VALUES (:user_id, :title, :description, :image_path, :external_link)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'image_path' => $imagePath,
            'external_link' => $externalLink
        ]);
    }

    public function getUserProjects($userId) {
        $query = "SELECT * FROM projects WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function update($id, $data) {
        $query = "UPDATE projects 
                 SET title = :title, description = :description, 
                     image_path = :image_path, external_link = :external_link 
                 WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'image_path' => $data['image_path'],
            'external_link' => $data['external_link']
        ]);
    }

    public function delete($id, $userId) {
        $query = "DELETE FROM projects WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'user_id' => $userId
        ]);
    }
} 