<header class="header <?= $class ?>">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
    <?php if (isset($exercise)) : ?>
    <p class="header-context">
        <span>Exercise: </span><span><?= $exercise->title ?></span>
    </p>
    <?php endif; ?>
</header>