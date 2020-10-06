<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
    <p class="header-context"><span>Exercise: </span><span><?= $exercise->title ?></span></p>
</header>
<div class="content">
    <table class="exercise-results">
        <thead>
            <th>Take</th>
            <th>question label</th>
        </thead>
        <tbody>
            <?php foreach ($exercise->fulfillments as $fulfillment) : ?>
                <tr>
                    <td><?= $fulfillment->timestamp ?></td>
                    <td>check</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>