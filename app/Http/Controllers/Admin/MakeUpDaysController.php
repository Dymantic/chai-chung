<?php

namespace App\Http\Controllers\Admin;

use App\Time\MakeUpDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MakeUpDaysController extends Controller
{

    public function index()
    {
        return MakeUpDay::all();
    }

    public function store()
    {
        request()->validate([
            'date' => ['required', 'date'],
            'reason' => ['required']
        ]);
        return MakeUpDay::forDate(request('date'), request('reason'));
    }

    public function delete(MakeUpDay $makeUpDay)
    {
        $makeUpDay->delete();
    }
}
