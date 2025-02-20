<?php
$title = "Modifier mon profil";
ob_start();

$user = (new User())->findById(Session::get('user_id'));
?>

<div class="edit-profile-container">
    <h1>Modifier mon profil</h1>

    <?php if ($flash = Session::getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= Security::escape($flash['message']) ?>
        </div>
    <?php endif; ?>

    <form action="/profile/update" method="POST" class="edit-form">
        <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">

        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required 
                   value="<?= Security::escape($user['username']) ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required 
                   value="<?= Security::escape($user['email']) ?>">
        </div>

        <div class="form-group">
            <label for="current_password">Mot de passe actuel</label>
            <input type="password" id="current_password" name="current_password">
            <small>Requis uniquement si vous souhaitez changer de mot de passe</small>
        </div>

        <div class="form-group">
            <label for="new_password">Nouveau mot de passe</label>
            <input type="password" id="new_password" name="new_password">
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmer le nouveau mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="/profile" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<style>
.edit-profile-container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.edit-form {
    display: grid;
    gap: 1.5rem;
}

.form-group {
    display: grid;
    gap: 0.5rem;
}

.form-group small {
    color: #666;
    font-size: 0.9rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

@media (max-width: 768px) {
    .edit-profile-container {
        margin: 1rem;
        padding: 1rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
    }
}
</style>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 