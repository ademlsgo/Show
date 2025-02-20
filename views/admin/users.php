<?php
$title = "Gestion des Utilisateurs";
ob_start();
?>

<div class="admin-container">
    <h1>Gestion des Utilisateurs</h1>

    <?php if ($flash = Session::getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= Security::escape($flash['message']) ?>
        </div>
    <?php endif; ?>

    <div class="users-table-container">
        <?php if (isset($users) && !empty($users)): ?>
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= Security::escape($user['id']) ?></td>
                            <td><?= Security::escape($user['username']) ?></td>
                            <td><?= Security::escape($user['email']) ?></td>
                            <td>
                                <form action="/admin/users/update-role" method="POST" class="role-form">
                                    <input type="hidden" name="csrf_token" 
                                           value="<?= Security::generateCSRFToken() ?>">
                                    <input type="hidden" name="user_id" 
                                           value="<?= $user['id'] ?>">
                                    <select name="role" onchange="this.form.submit()" 
                                            <?= $user['id'] === Session::get('user_id') ? 'disabled' : '' ?>>
                                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>
                                            Utilisateur
                                        </option>
                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                                            Administrateur
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                            <td class="actions">
                                <a href="/admin/users/view/<?= $user['id'] ?>" 
                                   class="btn btn-secondary btn-sm">
                                    Voir le profil
                                </a>
                                <?php if ($user['id'] !== Session::get('user_id')): ?>
                                    <form action="/admin/users/delete/<?= $user['id'] ?>" 
                                          method="POST" class="delete-form" style="display: inline;">
                                        <input type="hidden" name="csrf_token" 
                                               value="<?= Security::generateCSRFToken() ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                            Supprimer
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun utilisateur trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.admin-container {
    padding: 2rem;
}

.users-table-container {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.users-table th,
.users-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

.users-table th {
    background-color: var(--primary-color);
    color: white;
    font-weight: bold;
}

.users-table tr:hover {
    background-color: var(--light-bg);
}

.role-form {
    margin: 0;
}

.role-form select {
    padding: 0.3rem;
    border-radius: 4px;
    border: 1px solid var(--border-color);
}

.actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.9rem;
}

.delete-form {
    margin: 0;
}

@media (max-width: 768px) {
    .users-table {
        font-size: 0.9rem;
    }

    .users-table th,
    .users-table td {
        padding: 0.5rem;
    }

    .actions {
        flex-direction: column;
        gap: 0.3rem;
    }

    .btn-sm {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
// Confirmation avant changement de rôle
document.querySelectorAll('.role-form select').forEach(select => {
    const originalValue = select.value;
    
    select.addEventListener('change', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir modifier le rôle de cet utilisateur ?')) {
            e.preventDefault();
            this.value = originalValue;
            return false;
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 