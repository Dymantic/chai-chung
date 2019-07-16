<?php

namespace App\Clients;

use App\Pastureable;
use Illuminate\Database\Eloquent\Model;

class EngagementCode extends Model
{
    use Pastureable;

    protected $fillable = ['code', 'description'];

    protected $dates = ['pastured_on'];
}
