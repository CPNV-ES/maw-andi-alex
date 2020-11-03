<?= Component::new('header.php', ['exercise' => $exercise, 'class' => 'header-results']) ?>
<div class="content">
    <table class="exercise-results">
        <thead>
            <th>Take</th>
            <?php foreach ($exercise->questions as $question) : ?>
                <th>
                    <a href="/exercises/<?= $exercise->id ?>/results/<?= $question->id ?>">
                        <?= $question->label ?>
                    </a>
                </th>
            <?php endforeach; ?>
        </thead>
        <tbody>
            <?php foreach ($exercise->fulfillments as $fulfillment) : ?>
                <tr>
                    <td>
                        <a href="/exercises/<?= $exercise->id ?>/fulfillments/<?= $fulfillment->id ?>">
                            <?= $fulfillment->timestamp ?>
                        </a>
                    </td>
                    <?php foreach ($fulfillment->responses as $response) : ?>
                        <?php if (empty($response->text)) : ?>
                            <td><img src="/static/close.svg" alt=""></td>
                        <?php else : ?>
                            <?php if (strlen($response->text) >= 10) : ?>
                                <td><img src="/static/double_check.svg" alt=""></td>
                            <?php else : ?>
                                <td><img src="/static/check.svg" alt=""></td>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>