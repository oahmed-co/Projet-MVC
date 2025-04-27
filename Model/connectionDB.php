<?php
try {
    $host = 'localhost';
    $dbname = 'blog_mvc';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configurer PDO pour qu'il lance des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion réussie";
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>