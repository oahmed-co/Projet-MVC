
<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=blog_mvc", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT COUNT(*) AS total FROM articles");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$conn = null;
?>
        <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #2e59d9;
            --accent-color: #1cc88a;
            --light-bg: #f8f9fc;
        }
        
        body {
            background: linear-gradient(135deg, var(--light-bg), #ffffff);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            padding: 2rem;
        }
        
        .stats-container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stats-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.12);
        }
        
        .stats-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .stats-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 1.5rem 0;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: #5a5c69;
            margin-bottom: 2rem;
        }
        
        .btn-back {
            width: 100%;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.35rem;
            transition: all 0.3s ease;
            background-color: var(--primary-color);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-back:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(78, 115, 223, 0.25);
        }
        
        .divider {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.1);
            margin: 1.5rem 0;
        }
    </style>
</head>
<body>
    <div class="stats-container">
        <div class="stats-header">
            <h1 class="stats-title"><i class="bi bi-bar-chart"></i> Statistiques</h1>
            <p class="stat-label">Vue d'ensemble des publications</p>
        </div>
        
        <div class="stat-value">
           
        </div>
        <p class="stat-label">articles publiés</p>
        
 <?php
        try {
            $conn = new PDO("mysql:host=localhost;dbname=blog_mvc", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->query("SELECT COUNT(*) AS total FROM articles");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<p>Nombre total d'articles : <strong>" . htmlspecialchars($row['total']) . "</strong></p>";
        } catch(PDOException $e) {
            echo "<p class='text-danger'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        $conn = null;
        ?>
        <div class="divider">
            
        </div>
        
        <a href="Article.php" class="btn btn-back text-white">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>