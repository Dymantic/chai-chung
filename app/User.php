<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_manager', 'user_code', 'hourly_rate'
    ];

    protected $casts = ['is_manager' => 'bool'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function promote()
    {
        $this->is_manager = true;
        $this->save();
    }

    public function demote()
    {
        $this->is_manager = false;
        $this->save();
    }

    public function setPassword($new_password)
    {
        $this->password = bcrypt($new_password);
        $this->save();
    }
}
