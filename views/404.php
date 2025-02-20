<?php
$title = "Page non trouvée";
ob_start();
?>

<div class="error-container">
    <h1>404 - Page non trouvée</h1>
    <p>La page que vous recherchez n'existe pas ou a été déplacée.</p>
    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
</div>

<style>
.error-container {
    text-align: center;
    padding: 4rem 0;
}

.error-container h1 {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.error-container p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: #666;
}
</style>

<?php
$content = ob_get_clean();
require_once 'layouts/default.php';
?> 