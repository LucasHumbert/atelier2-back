<?php

namespace reu\backoffice\app\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user';
    public $incrementing = true;
    public $timestamps = false;

    public function events()
    {
        return $this->belongsToMany('App\Model\Event', 'user_event', 'user_id', 'event_id')
                ->withPivot(['user_id', 'event_id', 'choice']);
    }

    public function messages()
    {
        return $this->belongsToMany('App\Model\Event', 'messages', 'user_id', 'event_id')
            ->withPivot(['user_id', 'event_id', 'content', 'date']);
    }
}
