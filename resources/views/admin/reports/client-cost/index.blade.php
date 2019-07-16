@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">客戶每月成本報告</p>
        <div class="flex justify-end">

        </div>
    </div>
    <section class="max-w-xl mx-auto py-20">
        <table class="w-full">
            <thead>
            <tr class="text-left">
                <th>日期</th>
                <th>員工人數</th>
                <th>總時數</th>
                <th>加班總時數</th>
                <th>總成本</th>
                <th>預估收入</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>
                        <a href="/admin/manage-reports/client-cost/{{ $report['id'] }}" class="text-navy hover:text-orange">
                            {{ $report['date_range'] }}
                        </a>
                    </td>
                    <td>{{ $report['entries_count'] }}</td>
                    <td>{{ $report['total_hours'] }}</td>
                    <td>{{ $report['overtime_hours'] }}</td>
                    <td>{{ $report['total_cost'] }}</td>
                    <td>{{ $report['estimated_revenue'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection