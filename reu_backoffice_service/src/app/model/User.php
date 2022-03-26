<?php

namespace reu\backoffice\app\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user';
    public $incrementing = false;
    public $timestamps = false;

    public function events()
    {
        return $this->belongsToMany(Event::class, 'user_event', 'user_id', 'event_id')
                ->withPivot(['user_id', 'event_id', 'choice']);
    }

    public function messages()
    {
        return $this->belongsToMany(Event::class, 'message', 'user_id', 'event_id')
            ->withPivot(['user_id', 'event_id', 'content', 'date']);
    }
}
