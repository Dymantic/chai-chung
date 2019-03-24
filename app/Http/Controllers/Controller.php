<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function flashError($notification)
    {
        $defaults = [
            'type' => 'error',
            'title' => 'An error occurred',
            'message' => "",
            'clear' => false
        ];
        request()->session()->flash('flash-message', array_merge($defaults, $notification));
    }

    public function flashSuccess($notification)
    {
        $defaults = [
            'type' => 'success',
            'title' => 'Success',
            'message' => "",
            'clear' => true
        ];
        request()->session()->flash('flash-message', array_merge($defaults, $notification));
    }
}
