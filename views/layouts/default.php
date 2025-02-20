<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? Security::escape($title) . ' - ' : '' ?>Show Portfolio</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/">Accueil</a></li>
                <?php if (Session::isLoggedIn()): ?>
                    <li><a href="/profile">Mon Profil</a></li>
                    <li><a href="/projects">Mes Projets</a></li>
                    <li><a href="/skills">Mes Compétences</a></li>
                    <?php if (Session::isAdmin()): ?>
                        <li><a href="/admin">Administration</a></li>
                    <?php endif; ?>
                    <li><a href="/logout">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="/login">Connexion</a></li>
                    <li><a href="/register">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <?php if ($flash = Session::getFlash()): ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <?= Security::escape($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Show Portfolio</p>
    </footer>

    <script src="/assets/js/main.js"></script>
</body>
</html> 