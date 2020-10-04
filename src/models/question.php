<?php

use Expreql\Expreql\Model;

require_once 'models/exercise.php';

class Question extends Model
{
    public static $table = 'questions';

    public static $primary_key = 'id';

    public static $fields = [
        'id',
        'label',
        'type',
        'exercises_id',
    ];

    public static function has_one() {
        return [
            Exercise::class
        ];
    }

}
