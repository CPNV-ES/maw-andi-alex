<?= Component::new('header.php', ['exercise' => $exercise]) ?>
<div class="content">
    <h1>Editing field</h1>
    <form class="form" action="/exercises/<?= $exercise->id ?>/fields/<?= $field->id ?>" method="POST">
        <label for="label">Label</label>
        <input id="label" type="text" name="label" value="<?= $field->label?>">
        <label for="type">Value kind</label>
        <select name="type" id="type">
            <option value="single_line" <?= $field->type == 'single_line' ? 'selected' : '' ?>>Single line text</option>
            <option value="single_line_list" <?= $field->type == 'single_line_list' ? 'selected' : '' ?>>List of single lines</option>
            <option value="multi_line" <?= $field->type == 'multi_line' ? 'selected' : '' ?>>Multi-line text</option>
        </select>
        <input class="button button-purple" type="submit" value="Update field">
    </form>
    </form>
</div>