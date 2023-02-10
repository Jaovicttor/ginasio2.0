<?php

namespace App\Models\System;

use App\Helpers\Helper;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory, Uuid;
    protected $table = 'system.users';
    protected $timestamp = true;
    protected $fillable = [
       'username',
       'password',
       'name',
       'mail',
       'status',
       'admin'
    ];


    public static function prepareToRegister($user)
    {
        return [
            'username' => $user['username'],
            'mail'     => $user['mail'],
            'name'     => $user['name'],
            'status'   => 'active',
            'admin'    => $user['admin'],
            'password' => Hash::make(Helper::generatePassword(12))
        ];
    }

    public static function getUser($username)
    {
        return User::where('username',$username)->first();
    }
}
