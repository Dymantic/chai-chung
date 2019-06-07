<?php

namespace App\Clients;

use App\Time\Session;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'client_code', 'annual_revenue'];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
