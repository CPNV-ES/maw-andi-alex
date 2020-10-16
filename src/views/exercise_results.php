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
            <?php foreach ($exercise->questions as $question) : ?>
                <th><?= $question->label ?></th>
            <?php endforeach; ?>
        </thead>
        <tbody>
            <?php foreach ($exercise->fulfillments as $fulfillment) : ?>
                <tr>
                    <td><?= $fulfillment->timestamp ?></td>
                    <?php for ($response_index = 0; $response_index < $exercise->questions->count(); $response_index++) : ?>
                        <?php if (isset($fulfillment->responses[$response_index])) : ?>
                            <?php if (strlen($fulfillment->responses[$response_index]->text) >= 10) : ?>
                                <td><img src="/static/double_check.svg" alt=""></td>
                            <?php else : ?>
                                <td><img src="/static/check.svg" alt=""></td>
                            <?php endif; ?>
                        <?php else : ?>
                            <td><img src="/static/close.svg" alt=""></td>
                        <?php endif; ?>
                    <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>