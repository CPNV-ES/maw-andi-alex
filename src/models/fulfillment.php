<?php

use Expreql\Expreql\Model;

require_once 'models/exercise.php';

class Fulfillment extends Model
{
    public static $table = 'exercises';

    public static $primary_key = 'id';

    public static $fields = [
        'id',
        'timestamp',
    ];

    public static function has_one()
    {
        return [
            Exercise::class => 'exercises_id'
        ];
    }
}
