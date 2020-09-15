<?php

require_once 'core/model.php';

require_once 'models/exercise.php';

class Question extends Model
{
    public static $table = 'questions';

    public static $primary_key = 'id';

    protected static function has_one() {
        return [
            Exercise::class
        ];
    }

}
