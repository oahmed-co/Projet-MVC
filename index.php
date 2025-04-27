<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e3eafc, #ffffff);
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #0056b3;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #0056b3;
            border: none;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #003f8a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="login" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="login" name="login" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
        <hr>
        <?php
        // Ton script PHP pour gérer la connexion
        $servername = "localhost";
        $username = "root"; // Remplacez par votre nom d'utilisateur
        $password = ""; // Remplacez par votre mot de passe
        $dbname = "blog_mvc"; // Remplacez par le nom de votre base de données

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifiez la connexion
        if ($conn->connect_error) {
            die("<p class='text-danger'>Connexion échouée : " . htmlspecialchars($conn->connect_error) . "</p>");
        }

        // Récupérez les données du formulaire
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!empty($login) && !empty($password)) {
            // Requête SQL pour vérifier le login et le mot de passe
            $sql = "SELECT * FROM users WHERE login = ? AND pass = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $login, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if ($row['login'] === 'admin@gmail.com') {
                    header("Location: Model/Admin/Article.php"); // Redirection vers la page admin
                    exit; // Arrête l'exécution après la redirection
                } else {
                    header("Location: model/bolg/getArticleLimete.php");
                    exit; // Arrête l'exécution après la redirection
                }
            } else {
                echo "<p class='alert alert-danger'>Login ou mot de passe incorrect.</p>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>