<?= Component::new('header.php', ['exercise' => $exercise]) ?>
<div class="content">

    <h1>Your take</h1>
    <p>If you'd like to come back later to finish, simply submit with blanks</p>
    <form class="form" action="new" method="POST">

        <?php foreach($exercise->questions as $question): // Display every quetion ?>
            <!-- Label for every input -->
            <label for="fulfillment_answers_<?= $question->id ?>"><?= $question->label ?></label>

            <?php switch ($question->type): case "single_line": // Display input if "single_line" ?>
            <input id="fulfillment_answers_<?= $question->id ?>" type="text" name="questions[<?= $question->id ?>]" value="">

            <?php break; case "single_line_list": case "multi_line": // Display textarea if "single_line_list" or "multi_line" ?>
            <textarea id="fulfillment_answers_<?= $question->id ?>" name="questions[<?= $question->id ?>]" value="" cols="30" rows="3"></textarea>

            <?php break; default: // Default display the same input for "single_line" ?>
            <input id="fulfillment_answers_<?= $question->id ?>" type="text" name="questions[<?= $question->id ?>]" value="">
            <?php break; ?>

            <?php endswitch; ?>
        <?php endforeach; ?>

        <?php if ($exercise->questions->count() > 0): // Display the submit button if there is question on the page ?>
            <input class="button button-purple" type="submit" value="Save">
        <?php endif; ?>
    </form>
</div>
