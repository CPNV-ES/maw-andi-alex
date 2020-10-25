<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
    <p class="header-context"><span>Exercise: </span><span><?= $exercise->title ?></span></p>
</header>
<div class="content">
    <h1><?= $fulfillment->timestamp ?></h1>
    <dl>
        <?php foreach ($user_responses as $user_response) : ?>
            <dt><?= $user_response['question']->label ?></dt>    
            <dd><?= $user_response['response']->text ?></dd>
        <?php endforeach; ?>
    </dl>
</div>