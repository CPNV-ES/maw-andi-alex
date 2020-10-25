<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
    <p class="header-context"><span>Exercise: </span><span><?= $exercise->title ?></span></p>
</header>
<div class="content">
    <h1><?= $question->label ?></h1>
    <table class="question-result">
        <thead>
            <tr>
                <th>Take</th>
                <th>Content</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exercise->fulfillments as $fulfillment) : ?>
                <tr>
                    <td>
                        <a href="/exercises/<?= $exercise->id ?>/fulfillments/<?= $fulfillment->id ?>">
                            <?= $fulfillment->timestamp ?>
                        </a>
                    </td>
                    <td><?= $fulfillment->responses[0]->text ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>