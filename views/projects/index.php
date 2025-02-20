<?php
$title = "Mes Projets";
ob_start();
?>

<div class="projects-container">
    <div class="projects-header">
        <h1>Mes Projets</h1>
        <a href="/projects/create" class="btn btn-primary">Ajouter un projet</a>
    </div>

    <?php if ($flash = Session::getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= Security::escape($flash['message']) ?>
        </div>
    <?php endif; ?>

    <div class="projects-grid">
        <?php if (isset($projects) && !empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <?php if ($project['image_path']): ?>
                        <div class="project-image">
                            <img src="<?= Security::escape($project['image_path']) ?>" 
                                 alt="<?= Security::escape($project['title']) ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="project-content">
                        <h3><?= Security::escape($project['title']) ?></h3>
                        <p><?= nl2br(Security::escape($project['description'])) ?></p>
                        
                        <?php if ($project['external_link']): ?>
                            <a href="<?= Security::escape($project['external_link']) ?>" 
                               target="_blank" class="project-link">
                                Voir le projet
                            </a>
                        <?php endif; ?>

                        <div class="project-actions">
                            <a href="/projects/edit/<?= $project['id'] ?>" 
                               class="btn btn-secondary">Modifier</a>
                            <form action="/projects/delete/<?= $project['id'] ?>" 
                                  method="POST" class="delete-form">
                                <input type="hidden" name="csrf_token" 
                                       value="<?= Security::generateCSRFToken() ?>">
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-projects">Vous n'avez pas encore de projets. 
               Commencez par en créer un !</p>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 