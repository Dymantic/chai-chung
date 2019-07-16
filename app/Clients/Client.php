<?php

namespace App\Clients;

use App\Pastureable;
use App\Time\Session;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use Pastureable;

    protected $fillable = ['name', 'client_code', 'annual_revenue'];

    protected $dates = ['pastured_on'];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
