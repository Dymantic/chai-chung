<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MacDonaldsReport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class MacDonaldsReportsExportController extends Controller
{
    public function store()
    {
        request()->validate([
            'date' => 'required',
            'reports' => 'required',
            'filename' => 'required'
        ]);
        $data = request()->only('date', 'reports', 'filename');
        $key = Str::random(10);

        Cache::put("macreports.{$key}", $data, 60);

        return ['cache_key' => $key];
    }

    public function show($key)
    {
        $data = Cache::get("macreports.{$key}");

        $report = new MacDonaldsReport($data);
        $filename = Str::replaceLast(".xlsx", "", $data['filename']);

        Cache::forget("macreports.{$key}");

        return Excel::download($report, "{$filename}.xlsx");
    }
}
