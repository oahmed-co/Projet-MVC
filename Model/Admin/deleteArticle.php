<?php
// Connexion à la base de données avec PDO
try {
    $conn = new PDO("mysql:host=localhost;dbname=blog_mvc", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<div class='alert alert-danger text-center'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</div>");
}

// Gestion de la suppression d'article
$deleteMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $articleId = intval($_POST['delete_id']);

    // Vérifier si l'article existe avant suppression
    $checkQuery = $conn->prepare("SELECT id, titre FROM articles WHERE id = ?");
    $checkQuery->execute([$articleId]);
    $article = $checkQuery->fetch(PDO::FETCH_ASSOC);

    if ($article) {
        // Supprimer l'article
        $deleteQuery = $conn->prepare("DELETE FROM articles WHERE id = ?");
        if ($deleteQuery->execute([$articleId])) {
            $deleteMessage = "<div class='alert alert-success text-center'>L'article <strong>\"".htmlspecialchars($article['titre'])."\"</strong> (ID: ".htmlspecialchars($article['id']).") a été supprimé avec succès.</div>";
        } else {
            $deleteMessage = "<div class='alert alert-danger text-center'>Erreur lors de la suppression de l'article.</div>";
        }
    } else {
        $deleteMessage = "<div class='alert alert-warning text-center'>L'article avec l'ID spécifié n'existe pas.</div>";
    }
}

// Récupérer les articles
try {
    $stmt = $conn->query("SELECT id, titre FROM articles ORDER BY id DESC");
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div class='alert alert-danger text-center'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression d'Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 20px;
        }
        .delete-container {
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 900px;
        }
        .delete-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        .delete-header {
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }
        .delete-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--danger-color);
            border-radius: 2px;
        }
        .delete-title {
            color: var(--danger-color);
            font-weight: 700;
        }
        .table-responsive {
            margin-top: 25px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .table th {
            background: linear-gradient(135deg, var(--danger-color), #d11450);
            color: white;
            text-align: center;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: none;
            padding: 15px;
        }
        .table td {
            vertical-align: middle;
            padding: 12px 15px;
            border-color: #f1f3f9;
        }
        .table-hover tbody tr {
            transition: all 0.25s ease;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(247, 37, 133, 0.05);
            transform: translateX(5px);
        }
        .btn {
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-danger {
            background-color: var(--danger-color);
        }
        .btn-danger:hover {
            background-color: #d11450;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 37, 133, 0.3);
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
        .empty-message {
            color: #6c757d;
            font-style: italic;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .alert-message {
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .bi {
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="delete-container">
        <div class="delete-header">
            <h1 class="delete-title"><i class="bi bi-exclamation-triangle-fill"></i> Suppression d'Articles</h1>
            <p class="text-muted">Sélectionnez l'article à supprimer</p>
        </div>
        
        <?= $deleteMessage ?>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($articles) > 0): ?>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($article['id']) ?></td>
                                <td><?= htmlspecialchars($article['titre']) ?></td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($article['id']) ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet article ?')">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="empty-message">Aucun article à afficher</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <a href="Article.php" class="btn btn-secondary mt-4">
            <i class="bi bi-arrow-left"></i> Retour à la liste des articles
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>