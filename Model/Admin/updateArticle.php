<?php
// Connexion à la base de données via PDO
try {
    $conn = new PDO("mysql:host=localhost;dbname=blog_mvc", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<div class='alert alert-danger text-center'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</div>");
}

// Vérifier si un ID est passé
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Variables pour affichage
$message = "";
$article = ["id" => "", "titre" => "", "contenu" => ""];

if ($id > 0) {
    // Récupérer l'article si l'ID est valide
    $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        $message = "<div class='alert alert-warning text-center'>Article introuvable.</div>";
    }
}

// Vérifier si une mise à jour est demandée
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);

    if ($id > 0 && !empty($titre) && !empty($contenu)) {
        // Mettre à jour l'article
        $stmt = $conn->prepare("UPDATE articles SET titre = ?, contenu = ? WHERE id = ?");
        if ($stmt->execute([$titre, $contenu, $id])) {
            $message = "<div class='alert alert-success text-center'>Article mis à jour avec succès!</div>";
            // Recharger les données après mise à jour
            $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
            $stmt->execute([$id]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $message = "<div class='alert alert-danger text-center'>Erreur lors de la mise à jour.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>Veuillez remplir tous les champs.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer un article</title>
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
        .edit-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .edit-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        .edit-header {
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 20px;
        }
        .edit-header::after {
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
        .edit-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 5px;
        }
        label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        .form-control, .form-control:focus {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: none;
        }
        .form-control:hover {
            border-color: var(--accent-color);
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        textarea.form-control {
            min-height: 250px;
            resize: vertical;
        }
        .btn {
            font-size: 1rem;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary {
            background-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(67, 97, 238, 0.3);
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(108, 117, 125, 0.3);
        }
        .alert-message {
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .bi {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <div class="edit-header">
            <h1 class="edit-title">Modifier l'article</h1>
            <p class="text-muted">ID: <?= htmlspecialchars($article['id'] ?? 'Nouvel article') ?></p>
        </div>
        
        <?= $message ?>
        
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= htmlspecialchars($article['id']) ?>">
            
            <div class="mb-4">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" 
                       value="<?= htmlspecialchars($article['titre']) ?>" required>
            </div>
            
            <div class="mb-4">
                <label for="contenu" class="form-label">Contenu</label>
                <textarea class="form-control" id="contenu" name="contenu" required><?= htmlspecialchars($article['contenu']) ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-save"></i> Enregistrer les modifications
            </button>
        </form>
        
        <a href="Article.php" class="btn btn-secondary mt-3 w-100">
            <i class="bi bi-arrow-left"></i> Retour à la liste des articles
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>