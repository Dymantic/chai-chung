@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">客戶 &rarr; 時間紀錄整理報告</p>
        <div class="flex justify-end">

        </div>
    </div>
    <time-report export-url="/admin/exports/reports/client-time"
                 fetch-url="/admin/reports/client-time"
    ></time-report>
@endsection