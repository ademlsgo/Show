<?php
$title = "Mon Profil";
ob_start();

$user = (new User())->findById(Session::get('user_id'));
$projects = (new Project())->getUserProjects(Session::get('user_id'));
$skills = (new Skill())->getUserSkills(Session::get('user_id'));
?>

<div class="profile-container">
    <?php if ($flash = Session::getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= Security::escape($flash['message']) ?>
        </div>
    <?php endif; ?>

    <div class="profile-header">
        <h1>Mon Profil</h1>
        <a href="/profile/edit" class="btn btn-secondary">Modifier mon profil</a>
    </div>

    <div class="profile-grid">
        <!-- Informations utilisateur -->
        <div class="profile-card">
            <h2>Informations personnelles</h2>
            <div class="info-group">
                <label>Nom d'utilisateur :</label>
                <p><?= Security::escape($user['username']) ?></p>
            </div>
            <div class="info-group">
                <label>Email :</label>
                <p><?= Security::escape($user['email']) ?></p>
            </div>
            <div class="info-group">
                <label>Membre depuis :</label>
                <p><?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
            </div>
        </div>

        <!-- Compétences -->
        <div class="profile-card">
            <h2>Mes Compétences</h2>
            <?php if (!empty($skills)): ?>
                <div class="skills-list">
                    <?php foreach ($skills as $skill): ?>
                        <div class="skill-item">
                            <span class="skill-name"><?= Security::escape($skill['name']) ?></span>
                            <span class="skill-level <?= $skill['level'] ?>">
                                <?= Security::escape($skill['level']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucune compétence ajoutée. <a href="/skills">Ajouter des compétences</a></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Projets -->
    <div class="profile-projects">
        <h2>Mes Projets</h2>
        <?php if (!empty($projects)): ?>
            <div class="projects-grid">
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
                                   target="_blank" class="btn btn-link">
                                    Voir le projet
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun projet ajouté. <a href="/projects/create">Créer un projet</a></p>
        <?php endif; ?>
    </div>
</div>

<style>
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.profile-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.profile-card {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.info-group {
    margin-bottom: 1rem;
}

.info-group label {
    font-weight: bold;
    color: var(--primary-color);
}

.skills-list {
    display: grid;
    gap: 1rem;
}

.skill-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem;
    background: var(--light-bg);
    border-radius: 4px;
}

.skill-level {
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-size: 0.9rem;
}

.skill-level.débutant { background: #ffeaa7; }
.skill-level.intermédiaire { background: #81ecec; }
.skill-level.avancé { background: #74b9ff; }
.skill-level.expert { background: #a8e6cf; }

.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.project-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.project-image {
    height: 200px;
    overflow: hidden;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.project-content {
    padding: 1.5rem;
}

.project-content h3 {
    margin-bottom: 1rem;
    color: var(--primary-color);
}

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .profile-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 