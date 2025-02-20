<?php
$title = "Accueil";
ob_start();
?>

<div class="home-container">
    <section class="hero">
        <h1>Bienvenue sur Show Portfolio</h1>
        <p>Créez et partagez votre portfolio professionnel en ligne</p>
        <?php if (!Session::isLoggedIn()): ?>
            <div class="cta-buttons">
                <a href="/register" class="btn btn-primary">Créer mon portfolio</a>
                <a href="/login" class="btn btn-secondary">Se connecter</a>
            </div>
        <?php endif; ?>
    </section>

    <section class="features">
        <h2>Fonctionnalités</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Gérez vos projets</h3>
                <p>Ajoutez, modifiez et présentez vos réalisations professionnelles</p>
            </div>
            <div class="feature-card">
                <h3>Mettez en avant vos compétences</h3>
                <p>Détaillez vos compétences et votre niveau d'expertise</p>
            </div>
            <div class="feature-card">
                <h3>Portfolio personnalisé</h3>
                <p>Créez un portfolio qui vous ressemble</p>
            </div>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();
require_once 'layouts/default.php';
?> 