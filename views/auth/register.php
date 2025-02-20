<?php
$title = "Inscription";
ob_start();
?>

<div class="auth-container">
    <h1>Créer un compte</h1>

    <form action="/register" method="POST" class="auth-form">
        <?php if ($flash = Session::getFlash()): ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <?= Security::escape($flash['message']) ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">
        
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required 
                   value="<?= isset($_POST['username']) ? Security::escape($_POST['username']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required 
                   value="<?= isset($_POST['email']) ? Security::escape($_POST['email']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmer le mot de passe</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>

    <div class="auth-links">
        <a href="/login">Déjà un compte ? Se connecter</a>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 