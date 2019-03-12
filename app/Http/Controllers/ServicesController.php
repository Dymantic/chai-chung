<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ServicesController extends Controller
{
    public function show($service)
    {
        if (!in_array(Str::lower($service), ['audits', 'bookkeeping', 'business-registration', 'tax'], true)) {
            abort(404);
        }

        return view('front.services.show', ['content' => trans("service_{$service}")]);
    }
}
