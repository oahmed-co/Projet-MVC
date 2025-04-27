<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Article Complet</title>
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
        p {
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
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
                    echo "<h1>" . htmlspecialchars($article["titre"]) . "</h1>";
                    echo "<p>" . nl2br(htmlspecialchars($article["contenu"])) . "</p>";
                } else {
                    echo "<p class='alert alert-info text-center'>Article introuvable.</p>";
                }
            } else {
                echo "<p class='alert alert-warning text-center'>ID d'article invalide.</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='alert alert-danger'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
         <a href="getArticleLimete.php" class="btn btn-secondary mt-3 w-100">Retour </a>
    </div>
</body>
</html>