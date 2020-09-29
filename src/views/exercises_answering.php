<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
</header>
<div class="content">
    <div class="exercise-list">
        <?php foreach($exercises as $exercise): ?>
        <div class="exercise-card">
            <div class="exercise-title"><?= $exercise->title ?></div>
            <a href="exercises/<?= $exercise->id ?>/fulfillments/new" class="button button-purple">Take it</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>