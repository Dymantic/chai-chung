@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">Client &rarr; Time Report</p>
        <div class="flex justify-end">

        </div>
    </div>
    <time-report fetch-url="/admin/reports/client-time"></time-report>
@endsection