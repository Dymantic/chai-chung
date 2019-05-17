<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessAssistancePagesController extends Controller
{
    public function planning()
    {
        return view('front.business-registration.planning');
    }

    public function formation()
    {
        return view('front.business-registration.formation');
    }

    public function succession()
    {
        return view('front.business-registration.succession');
    }

    public function foreign()
    {
        return view('front.business-registration.foreign');
    }
}
