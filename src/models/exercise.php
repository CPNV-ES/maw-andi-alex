<?php

use Expreql\Expreql\Model;

require_once 'models/question.php';

class Exercise extends Model
{
    public static $table = 'exercises';

    public static $primary_key = 'id';

    public static $fields = [
        'id',
        'title',
        'state',
    ];

    public static $has_many = [
        Question::class => 'exercises_id',
        Fulfillment::class => 'exercises_id'
    ];
}
