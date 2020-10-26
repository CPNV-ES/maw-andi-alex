<?= Component::new('header.php') ?>
<div class="content">
    <div class="exercise-list">
        <?php foreach($exercises as $exercise): ?>
            <?php if ($exercise->questions->count() > 0): ?>
                <div class="exercise-card">
                    <div class="exercise-title"><?= $exercise->title ?></div>
                    <a href="<?= $exercise->id ?>/fulfillments/new" class="button button-purple">Take it</a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
