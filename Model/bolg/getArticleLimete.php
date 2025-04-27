<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e3eafc, #ffffff);
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        h1 {
            color: #0056b3;
            text-align: center;
            font-weight: bold;
        }
        .article {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            background: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .article h2 {
            font-size: 20px;
            color: #0056b3;
            font-weight: bold;
        }
        .article p {
            font-size: 16px;
            color: #333;
        }
        .article a {
            text-decoration: none;
            color: #0056b3;
            font-weight: bold;
        }
        .article a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Articles</h1>
        <?php
        try {
            // Connexion à la base de données
            $conn = new PDO("mysql:host=localhost;dbname=blog_mvc", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour limiter les articles à 5
           
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Vérifier et afficher les articles
            if (count($articles) > 0) {
                foreach ($articles as $article) {
                    echo "<div class='article'>";
                    echo "<h2>" . htmlspecialchars($article["titre"]) . "</h2>";
                    echo "<p>" . htmlspecialchars(substr($article["contenu"], 0, 100)) . "... ";
                    echo "<a href='getArticle.php?id=" . $article["id"] . "'>Lire la suite</a></p>";
                    echo "</div>";
                }
            } else {
                echo "<p class='alert alert-info text-center'>Aucun article disponible.</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='alert alert-danger'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
</body>
</html>