<?php

use Expreql\Expreql\Model;

require_once 'models/question.php';
require_once 'models/fulfillment.php';

class Response extends Model
{
    public static $table = 'responses';

    public static $primary_key = 'id';

    public static $fields = [
        'id',
        'text',
        'questions_id',
        'fulfillments_id',
    ];

    public static $has_one = [
        Question::class => 'questions_id',
        Fulfillment::class => 'fulfillments_id',
    ];
}
