
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nombre total d'articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e3eafc, #ffffff);
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #0056b3;
            font-weight: bold;
        }
        p {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Statistiques des Articles</h1>
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
          <a href="getArticleLimete.php" class="btn btn-secondary mt-3 w-100">Retour </a>
    </div>
</body>
</html>