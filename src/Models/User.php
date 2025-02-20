<?php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function create($username, $email, $password, $role = 'user') {
        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => Security::hashPassword($password),
            'role' => $role
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'username' => $data['username'],
            'email' => $data['email']
        ]);
    }

    public function findById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
} 