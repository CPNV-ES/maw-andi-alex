<?= Component::new('header.php', ['exercise' => $exercise]) ?>
<div class="content">
    <div class="exercise-fields">
        <section>
            <h1>Fields</h1>
            <table>
                <thead>
                    <tr>
                        <td>Label</td>
                        <td>Value kind</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($exercise->questions as $field) : ?>
                        <tr>
                            <td><?= $field->label ?></td>
                            <td><?= $field->type ?></td>
                            <td>
                                <a href="/exercises/<?= $exercise->id ?>/fields/<?= $field->id ?>/edit" class="icon-button">
                                    <img src="/static/edit.svg" alt="Manage fields">
                                </a>
                                <a href="/exercises/<?= $exercise->id ?>/fields/<?= $field->id ?>/delete" class="icon-button">
                                    <img src="/static/delete.svg" alt="Delete">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="/exercises/<?= $exercise->id ?>/status/answering" class="button button-purple" data-confirm="Are you sure? You won't be able to further edit this exercise">
                <img class="button-img" src="/static/chat.svg">Complete and be ready for answers
            </a>
        </section>
        <section>
            <h1>New Field</h1>
            <form class="form" action="/exercises/<?= $exercise->id ?>/fields" method="POST">
                <label for="label">Label</label>
                <input id="label" type="text" name="label">
                <label for="type">Value kind</label>
                <select name="type" id="type">
                    <option value="single_line" selected>Single line text</option>
                    <option value="single_line_list">List of single lines</option>
                    <option value="multi_line">Multi-line text</option>
                </select>
                <input class="button button-purple" type="submit" value="Create field">
            </form>
        </section>
    </div>
</div>