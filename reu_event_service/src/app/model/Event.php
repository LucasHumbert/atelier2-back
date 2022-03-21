<?php

namespace reu\event\app\model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'event';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
