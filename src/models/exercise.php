<?php

require_once 'core/model.php';

require_once 'models/question.php';

class Exercise extends Model
{
    public static $table = 'exercises';

    public static $primary_key = 'id';

      protected static function has_many() {
        return [
            Question::class => 'exercises_id'
        ];
    }
}
