<?php
$title = "Administration des Compétences";
ob_start();
?>

<div class="admin-container">
    <h1>Gestion des Compétences</h1>

    <?php if ($flash = Session::getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= Security::escape($flash['message']) ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'ajout de compétence -->
    <div class="admin-form-container">
        <h2>Ajouter une nouvelle compétence</h2>
        <form action="/admin/skills/add" method="POST" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">
            
            <div class="form-group">
                <label for="name">Nom de la compétence</label>
                <input type="text" id="name" name="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <!-- Liste des compétences existantes -->
    <div class="admin-list-container">
        <h2>Compétences existantes</h2>
        
        <?php if (isset($skills) && !empty($skills)): ?>
            <div class="skills-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($skills as $skill): ?>
                            <tr>
                                <td><?= Security::escape($skill['id']) ?></td>
                                <td><?= Security::escape($skill['name']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($skill['created_at'])) ?></td>
                                <td class="actions">
                                    <button class="btn btn-secondary btn-sm" 
                                            onclick="editSkill(<?= $skill['id'] ?>, '<?= Security::escape($skill['name']) ?>')">
                                        Modifier
                                    </button>
                                    
                                    <form action="/admin/skills/delete/<?= $skill['id'] ?>" 
                                          method="POST" class="delete-form" style="display: inline;">
                                        <input type="hidden" name="csrf_token" 
                                               value="<?= Security::generateCSRFToken() ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Aucune compétence n'a été créée pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de modification -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Modifier la compétence</h2>
        <form action="/admin/skills/edit" method="POST" class="edit-form">
            <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">
            <input type="hidden" name="skill_id" id="edit_skill_id">
            
            <div class="form-group">
                <label for="edit_name">Nom de la compétence</label>
                <input type="text" id="edit_name" name="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>

<style>
/* Styles spécifiques à l'administration */
.admin-container {
    padding: 2rem;
}

.admin-form-container {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.skills-table {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

th, td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

th {
    background-color: var(--primary-color);
    color: white;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.9rem;
}

/* Styles pour la modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 2rem;
    border-radius: 8px;
    width: 80%;
    max-width: 500px;
    position: relative;
}

.close {
    position: absolute;
    right: 1rem;
    top: 0.5rem;
    font-size: 1.5rem;
    cursor: pointer;
}
</style>

<script>
// JavaScript pour la gestion de la modal
function editSkill(id, name) {
    const modal = document.getElementById('editModal');
    const skillIdInput = document.getElementById('edit_skill_id');
    const nameInput = document.getElementById('edit_name');
    
    skillIdInput.value = id;
    nameInput.value = name;
    
    modal.style.display = 'block';
}

document.querySelector('.close').onclick = function() {
    document.getElementById('editModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 