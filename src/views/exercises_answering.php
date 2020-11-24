<?= Component::new('header.php', ['class' => 'header-answering']) ?>
<div class="content">
    <div class="searchbar">
        <input type="search" placeholder="Search..." data-filter="exercises" data-filter-attr="data-filter-title">
        <button class="search-icon" type="submit"></button>
    </div>
    <div id="exercises" class="exercise-list">
        <?php foreach($exercises as $exercise): ?>
            <div class="exercise-card" data-filter-title="<?= $exercise->title ?>">
                <div class="exercise-title"><?= $exercise->title ?></div>
                <a href="<?= $exercise->id ?>/fulfillments/new" class="button button-purple">Take it</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
