<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
    <p class="header-context"><span>Exercise: </span><span><?= $exercise->title ?></span></p>
</header>
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
                    <?php foreach($exercise->questions as $field): ?>
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
            <a href="/exercises/<?= $exercise->id ?>/status/answering" class="button button-purple"><img class="button-img" src="/static/chat.svg">Complete and be ready for answers</a>
        </section>
        <section>
            <h1>New Field</h1>
            <form class="form" action="/exercises/id/fields" method="POST">
                <label for="label">Label</label>
                <input id="label" type="text" name="label">
                <label for="kind">Value kind</label>
                <select name="kind" id="kind">
                    <option value="single">Single line text</option>
                    <option value="multi">List of single lines</option>
                    <option value="list">Multi-line text</option>
                </select>
                <input class="button button-purple" type="submit" value="Create field">
            </form>
        </section>
    </div>
</div>