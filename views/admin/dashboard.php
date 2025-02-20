<?php
$title = "Tableau de bord administrateur";
ob_start();
?>

<div class="admin-dashboard">
    <h1>Tableau de bord administrateur</h1>

    <?php if ($flash = Session::getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= Security::escape($flash['message']) ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h2>Gestion des compétences</h2>
            <p>Gérez les compétences disponibles pour les utilisateurs.</p>
            <a href="/admin/skills" class="btn btn-primary">Gérer les compétences</a>
        </div>

        <div class="dashboard-card">
            <h2>Statistiques</h2>
            <ul class="stats-list">
                <li>Nombre total d'utilisateurs : <strong><?= $userCount ?? 0 ?></strong></li>
                <li>Nombre de projets : <strong><?= $projectCount ?? 0 ?></strong></li>
                <li>Nombre de compétences : <strong><?= $skillCount ?? 0 ?></strong></li>
            </ul>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    padding: 2rem;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.dashboard-card {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.dashboard-card h2 {
    margin-bottom: 1rem;
    color: var(--primary-color);
}

.stats-list {
    list-style: none;
    padding: 0;
}

.stats-list li {
    margin-bottom: 0.5rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.stats-list strong {
    color: var(--secondary-color);
}
</style>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 