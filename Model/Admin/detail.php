<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Complet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 20px;
        }
        .article-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .article-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        .article-header {
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 20px;
        }
        .article-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }
        .article-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 2.2rem;
        }
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--dark-color);
            text-align: justify;
            padding: 0 10px;
        }
        .article-content p {
            margin-bottom: 1.5rem;
        }
        .article-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 30px;
            text-align: center;
        }
        .alert-message {
            border-radius: 10px;
            text-align: center;
            padding: 15px;
            margin: 20px 0;
        }
        .btn-back {
            width: 100%;
            margin-top: 40px;
            padding: 12px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(108, 117, 125, 0.3);
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }
        .action-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .action-btn i {
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <div class="article-container">
        <?php
        try {
            // Connexion à la base de données
            $conn = new PDO("mysql:host=localhost;dbname=blog_mvc", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérification de l'ID de l'article
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($id > 0) {
                // Requête pour récupérer l'article
                $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
                $stmt->execute([$id]);
                $article = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($article) {
                    echo '<div class="article-header">';
                    echo '<h1 class="article-title">' . htmlspecialchars($article["titre"]) . '</h1>';
                    
                    // Ajout de métadonnées fictives (à remplacer par vos vraies données si disponibles)
                    echo '<div class="article-meta">';
                    echo '<span><i class="bi bi-calendar"></i> Publié le: ' . date('d/m/Y', strtotime($article["date_publication"] ?? 'now')) . '</span>';
                    echo ' <span class="mx-2">•</span> ';
                    echo '<span><i class="bi bi-clock"></i> Temps de lecture: 3 min</span>';
                    echo '</div>';
                    
                    echo '</div>';
                    
                    echo '<div class="article-content">';
                    echo nl2br(htmlspecialchars($article["contenu"]));
                    echo '</div>';
                    
                    // Boutons d'action
                    echo '<div class="action-buttons">';
                    echo '<a href="updateArticle.php?id=' . $id . '" class="btn btn-primary action-btn">';
                    echo '<i class="bi bi-pencil"></i> Modifier</a>';
                    echo '<a href="deleteArticle.php?id=' . $id . '" class="btn btn-danger action-btn" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet article ?\')">';
                    echo '<i class="bi bi-trash"></i> Supprimer</a>';
                    echo '</div>';
                } else {
                    echo '<div class="alert alert-info alert-message">Article introuvable.</div>';
                }
            } else {
                echo '<div class="alert alert-warning alert-message">ID d\'article invalide.</div>';
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger alert-message">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
        
        <a href="Article.php" class="btn btn-secondary btn-back">
            <i class="bi bi-arrow-left"></i> Retour à la liste des articles
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>