<?php

// 1. Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "blog_mvc");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// 2. Récupération des articles
$sql = "SELECT id, titre, contenu FROM articles";
$result = $conn->query($sql);
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des articles</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .container {
            margin-top: 50px;
            padding: 30px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        h1 {
            font-weight: 700;
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }
        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }
        .table-responsive {
            margin-top: 25px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
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
            background-color: rgba(67, 97, 238, 0.05);
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        .btn {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 0 3px;
            border: none;
        }
        .btn-primary {
            background-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
        .btn-danger {
            background-color: var(--danger-color);
        }
        .btn-danger:hover {
            background-color: #e3176a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 37, 133, 0.3);
        }
        .btn-info {
            background-color: #17a2b8;
            margin-top: 20px;
        }
        .btn-info:hover {
            background-color: #138496;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
        }
        .action-buttons {
            white-space: nowrap;
        }
        .empty-message {
            color: #6c757d;
            font-style: italic;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .bi {
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Administration des Articles</h1>
        <div class="d-flex justify-content-end">
            <a href="insertArticle.php" class="btn btn-primary mb-3 add-btn">
                <i class="bi bi-plus-lg"></i> Ajouter un article
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['titre']) ?></td>
                                <td class="text-center action-buttons">
                                    <a href="detail.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                    <a href="updateArticle.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <a href="deleteArticle.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="empty-message">Aucun article trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <a href="count.php" class="btn btn-info">
                <i class="bi bi-list-ol"></i> Nombre total des articles
            </a>
        </div>
    </div>

    <!-- Bootstrap JS + Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</body>
</html>