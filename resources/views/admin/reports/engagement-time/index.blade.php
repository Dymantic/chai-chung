@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">工作事項 &rarr; 時間紀錄整理報告</p>
        <div class="flex justify-end">

        </div>
    </div>
    <time-report export-url="/admin/exports/reports/engagement-time"
                 fetch-url="/admin/reports/engagement-time"
    ></time-report>
@endsection