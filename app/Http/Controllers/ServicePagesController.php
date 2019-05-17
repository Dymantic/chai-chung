<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ServicePagesController extends Controller
{

    public function audits()
    {
        return view('front.services.audits.page');
    }

    public function bookkeeping()
    {
        return view('front.services.bookkeeping.page');
    }

    public function tax()
    {
        return view('front.services.tax-services.page');
    }

    public function businessAssistance()
    {
        return view('front.services.business-assistance.page');
    }
}
