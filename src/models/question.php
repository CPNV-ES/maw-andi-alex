<?php

use Expreql\Expreql\Model;

require_once 'models/exercise.php';
require_once 'models/response.php';

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

    public static $has_one = [
        Exercise::class => 'exercises_id'
    ];

    public static $has_many = [
        Response::class => 'questions_id',
    ];
}
