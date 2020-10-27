<?php

use Expreql\Expreql\Model;

require_once 'models/exercise.php';

class Fulfillment extends Model
{
    public static $table = 'fulfillments';

    public static $primary_key = 'id';

    public static $fields = [
        'id',
        'timestamp',
    ];

    public static $has_many = [
        Response::class => 'fulfillments_id'
    ];

    public static $has_one = [
        Exercise::class => 'exercises_id'
    ];
}
