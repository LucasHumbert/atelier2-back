<?php

namespace reu\auth\app\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'refresh_token', 'level'];
    protected $hidden = ['password', 'created_at', 'updated_at', 'level', 'id'];
}