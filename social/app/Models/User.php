<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail  //  aggiunto per la verifica via email durante la registrazione
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'gender',
        'nick',
        'email',
        'password',
        'img',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function images(){
        return $this->hasMany('App\Models\Image');
    }

    
    public function videos(){
        return $this->hasMany('App\Models\Video');
    }


    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }


    public function likes(){
        return $this->hasMany('App\Models\Like');
    }


    public function friends(){
        return $this->hasMany('App\Models\Friendship');
    }

    public function list(){
        return $this->hasMany('App\Models\Friendslist');
    }


}

