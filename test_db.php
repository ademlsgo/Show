<?php
require_once __DIR__ . '/config/database.php';

try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✅ Connexion à la base de données réussie !";
    
    // Test de la requête
    $stmt = $db->query("SELECT COUNT(*) FROM users");
    $count = $stmt->fetchColumn();
    echo "\n📊 Nombre d'utilisateurs dans la base : " . $count;
    
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
} 