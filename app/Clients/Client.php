<?php

namespace App\Clients;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'client_code', 'annual_revenue'];
}
