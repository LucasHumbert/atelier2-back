<?php

namespace reu\event\app\model;

use Illuminate\Database\Eloquent\Model;
use Respect\Validation\Rules\Even;

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
        return $this->belongsToMany(User::class, 'messages', 'user_id', 'event_id')
            ->withPivot(['user_id', 'event_id', 'content', 'date']);
    }
}
