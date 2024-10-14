<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogMessage extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql_log';


    protected $table = 'logs';

    protected $fillable = [
        'name',
        'level',
        'level_name',
        'context',
        'parent_id',
        'attributes',
        'message',
        'timestamp',
    ];

}
