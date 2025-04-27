<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Blog MVC - Articles</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php include('include/header.php'); ?>

    <section class="section">
        <article>
            <!-- Navigation entre les articles du blog -->
            <form action="indexSwitch.php" method="POST">
                <p>
                    Circuler dans les articles du blog :
                    <input type="submit" name="haut" value="Haut">
                    <input type="submit" name="descendre" value="Descendre">
                    <input type="submit" name="monter" value="Monter">
                    <input type="submit" name="bas" value="Bas">
                    <input type="submit" name="boutonTousLesArticles" value="Tous les articles">
                    <input type="hidden" name="indexArticles" value="1">
                    <input type="hidden" name="debut" value="<?= htmlspecialchars($debut ?? 0); ?>">
                    <input type="hidden" name="tousLesArticles" value="<?= htmlspecialchars($tousLesArticles ?? 0); ?>">
                </p>
            </form>

            <?php
            // Vérification et affichage des articles
            if (!empty($articles) && is_array($articles)) {
                foreach ($articles as $article) {
                    ?>
                    <div class="toutArticle">
                        <h3>
                            <?= htmlspecialchars($article['titre']) ?> - id : <?= htmlspecialchars($article['id']) ?>
                        </h3>
                        <div class="articleEtDate">
                            <p class="dateArticle">
                                <em>
                                    <?php
                                    // Gestion et affichage des dates
                                    $date = date_create($article['dateCreation']);
                                    echo date_format($date, 'd M Y') . '<br/>';
                                    echo date_format($date, 'H:i:s');
                                    ?>
                                </em>
                            </p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="alert alert-info">Aucun article trouvé.</p>';
            }
            ?>
        </article>

        <aside class="aside">
            <p>Mon aside à remplir</p>
        </aside>
    </section>

    <?php include("include/footer.php"); ?>
</body>
</html>