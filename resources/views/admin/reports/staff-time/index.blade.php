@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">員工 &rarr; 時間紀錄整理報告</p>
        <div class="flex justify-end">

        </div>
    </div>
<time-report export-url="/admin/exports/reports/staff-time"
             fetch-url="/admin/reports/staff-time"
></time-report>
@endsection