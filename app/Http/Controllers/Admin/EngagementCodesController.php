<?php

namespace App\Http\Controllers\Admin;

use App\Clients\EngagementCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EngagementCodesController extends Controller
{
    public function store()
    {
        request()->validate([
            'code' => 'required',
            'description' => 'required',
        ]);
        return EngagementCode::create(request()->only('code', 'description'));
    }

    public function update(EngagementCode $engagement_code)
    {
        request()->validate(['description' => 'required']);

        $engagement_code->update(request()->only('description'));

        return $engagement_code->fresh();
    }

    public function delete(EngagementCode $engagement_code)
    {
        $engagement_code->delete();
    }
}
