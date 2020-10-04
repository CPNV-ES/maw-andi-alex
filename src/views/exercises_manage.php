<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
</header>
<div class="content">
    <div class="exercise-categories">
        <section>
            <h1>Building</h1>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($building_exercises as $exercise) : ?>
                        <tr>
                            <td><?= $exercise->title ?></td>
                            <td>
                                <?php if ($exercise->questions->count() > 0) : ?>
                                    <a href="/exercises/<?= $exercise->id ?>/status/answering" class="icon-button">
                                        <img src="/static/check.svg" alt="Be ready for answers">
                                    </a>
                                <?php endif; ?>
                                <a href="/exercises/<?= $exercise->id ?>/fields" class="icon-button">
                                    <img src="/static/edit.svg" alt="Manage fields">
                                </a>
                                <a href="/exercises/<?= $exercise->id ?>/delete" class="icon-button">
                                    <img src="/static/delete.svg" alt="Delete">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section>
            <h1>Answering</h1>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($answering_exercises as $exercise) : ?>
                        <tr>
                            <td><?= $exercise->title ?></td>
                            <td>
                                <a href="/exercises/<?= $exercise->id ?>/results" class="icon-button">
                                    <img src="/static/chart.svg" alt="See results">
                                </a>
                                <a href="/exercises/<?= $exercise->id ?>/status/closed" class="icon-button">
                                    <img src="/static/close.svg" alt="Close">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section>
            <h1>Closed</h1>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($closed_exercises as $exercise) : ?>
                        <tr>
                            <td><?= $exercise->title ?></td>
                            <td>
                                <a href="/exercises/<?= $exercise->id ?>/results" class="icon-button">
                                    <img src="/static/chart.svg" alt="See results">
                                </a>
                                <a href="/exercises/<?= $exercise->id ?>/delete" class="icon-button">
                                    <img src="/static/delete.svg" alt="Close">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>