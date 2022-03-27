<?php

namespace reu\backoffice\app\model;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'guest';
    public $incrementing = true;
    public $timestamps = false;

    public function event() {
        return $this->belongsTo(Event::class,'event_id');
    }
}
