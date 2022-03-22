<?php

namespace reu\backoffice\app\model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'event';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_event', 'event_id', 'user_id')
            ->withPivot(['user_id', 'event_id', 'choice']);
    }

    public function messages()
    {
        return $this->belongsToMany(User::class, 'message', 'event_id', 'user_id')
            ->withPivot(['user_id', 'event_id', 'content', 'date']);
    }
}
