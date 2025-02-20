<?php
$title = "Erreur serveur";
ob_start();
?>

<div class="error-container">
    <h1>Une erreur est survenue</h1>
    <p>Désolé, une erreur inattendue s'est produite. Veuillez réessayer plus tard.</p>
    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
</div>

<style>
.error-container {
    max-width: 600px;
    margin: 4rem auto;
    text-align: center;
    padding: 2rem;
}

.error-container h1 {
    color: var(--error-color);
    margin-bottom: 1rem;
}

.error-container p {
    margin-bottom: 2rem;
    color: #666;
}
</style>

<?php
$content = ob_get_clean();
require_once 'layouts/default.php';
?> 