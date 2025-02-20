<?php
$title = "Ajouter un projet";
ob_start();
?>

<div class="form-container">
    <h1>Ajouter un nouveau projet</h1>

    <form action="/projects/create" method="POST" enctype="multipart/form-data" 
          class="project-form">
        <input type="hidden" name="csrf_token" 
               value="<?= Security::generateCSRFToken() ?>">

        <?php if ($flash = Session::getFlash()): ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <?= Security::escape($flash['message']) ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="title">Titre du projet *</label>
            <input type="text" id="title" name="title" required 
                   value="<?= isset($_POST['title']) ? Security::escape($_POST['title']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="description">Description *</label>
            <textarea id="description" name="description" rows="5" required><?= 
                isset($_POST['description']) ? Security::escape($_POST['description']) : ''
            ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image du projet</label>
            <input type="file" id="image" name="image" accept="image/*">
            <small>Formats acceptés : JPG, PNG, GIF. Taille maximale : 2MB</small>
        </div>

        <div class="form-group">
            <label for="external_link">Lien externe</label>
            <input type="url" id="external_link" name="external_link" 
                   value="<?= isset($_POST['external_link']) ? Security::escape($_POST['external_link']) : '' ?>">
            <small>URL complète vers votre projet (optionnel)</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Créer le projet</button>
            <a href="/projects" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 