<?php
$title = "Mes Compétences";
ob_start();
?>

<div class="skills-container">
    <h1>Mes Compétences</h1>

    <?php if ($flash = Session::getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= Security::escape($flash['message']) ?>
        </div>
    <?php endif; ?>

    <form action="/skills/update" method="POST" class="skills-form">
        <input type="hidden" name="csrf_token" 
               value="<?= Security::generateCSRFToken() ?>">

        <div class="skills-grid">
            <?php if (isset($availableSkills) && !empty($availableSkills)): ?>
                <?php foreach ($availableSkills as $skill): ?>
                    <div class="skill-card">
                        <h3><?= Security::escape($skill['name']) ?></h3>
                        <select name="skills[<?= $skill['id'] ?>]">
                            <option value="">Non sélectionné</option>
                            <option value="débutant" <?= 
                                (isset($userSkills[$skill['id']]) && 
                                 $userSkills[$skill['id']] === 'débutant') ? 'selected' : '' 
                            ?>>Débutant</option>
                            <option value="intermédiaire" <?= 
                                (isset($userSkills[$skill['id']]) && 
                                 $userSkills[$skill['id']] === 'intermédiaire') ? 'selected' : '' 
                            ?>>Intermédiaire</option>
                            <option value="avancé" <?= 
                                (isset($userSkills[$skill['id']]) && 
                                 $userSkills[$skill['id']] === 'avancé') ? 'selected' : '' 
                            ?>>Avancé</option>
                            <option value="expert" <?= 
                                (isset($userSkills[$skill['id']]) && 
                                 $userSkills[$skill['id']] === 'expert') ? 'selected' : '' 
                            ?>>Expert</option>
                        </select>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune compétence disponible pour le moment.</p>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/default.php';
?> 