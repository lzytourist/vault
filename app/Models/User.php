<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User credits
     */
    public function credits()
    {
        return $this->hasMany(Credit::class, 'user_id', 'id');
    }

    /**
     * User expenditures
     */
    public function expenditures()
    {
        return $this->hasMany(Expenditure::class, 'user_id', 'id');
    }

    /**
     * User notes
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }
}
