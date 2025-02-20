<?php

class Skill {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllSkills() {
        $query = "SELECT * FROM skills ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserSkills($userId) {
        $query = "SELECT s.*, us.level 
                 FROM skills s 
                 INNER JOIN user_skills us ON s.id = us.skill_id 
                 WHERE us.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function addSkill($name) {
        $query = "INSERT INTO skills (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['name' => $name]);
    }

    public function updateUserSkill($userId, $skillId, $level) {
        $query = "INSERT INTO user_skills (user_id, skill_id, level) 
                 VALUES (:user_id, :skill_id, :level)
                 ON DUPLICATE KEY UPDATE level = :level";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'user_id' => $userId,
            'skill_id' => $skillId,
            'level' => $level
        ]);
    }

    public function deleteSkill($id) {
        $query = "DELETE FROM skills WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
} 