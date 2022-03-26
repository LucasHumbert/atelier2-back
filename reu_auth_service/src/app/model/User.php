<?php

namespace reu\auth\app\model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @author HUMBERT Lucas
 * @author BUDZIK Valentin
 * @author HOUQUES Baptiste
 * @author LAMBERT Calvin
 * @package reu\auth\app\model
 *
 */
class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'refresh_token', 'level'];
    protected $hidden = ['password', 'created_at', 'updated_at', 'level', 'id'];
}