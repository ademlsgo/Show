<?php
$title = "Connexion";
ob_start();
?>

<div class="auth-container">
    <h1>Connexion</h1>

    <form action="/login" method="POST" class="auth-form">
        <?php if ($flash = Session::getFlash()): ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <?= Security::escape($flash['message']) ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">
        
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
            <label>
                <input type="checkbox" name="remember_me"> Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    <div class="auth-links">
        <a href="/register">Pas encore de compte ? S'inscrire</a>
        <a href="/forgot-password">Mot de passe oublié ?</a>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 