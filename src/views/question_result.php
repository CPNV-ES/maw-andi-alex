<?= Component::new('header.php', ['exercise' => $exercise]) ?>
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