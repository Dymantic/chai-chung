@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">客戶成本: {{ $report['date_range'] }}</p>
        <div class="flex justify-end">
            <download-report-button export-url="/admin/exports/reports/client-cost/{{ $report['id'] }}"></download-report-button>
        </div>
    </div>
    <section class="max-w-xl mx-auto">
        <div class="flex justify-between p-8 bg-grey-lightest shadow">
            <div>
                <p>總時數</p>
                <p class="text-3xl">{{ $report['total_hours'] }}</p>
            </div>
            <div>
                <p>加班總時數</p>
                <p class="text-3xl">{{ $report['overtime_hours'] }}</p>
            </div>
            <div>
                <p>總成本</p>
                <p class="text-3xl">{{ $report['total_cost'] }}</p>
            </div>
            <div>
                <p>預估收入</p>
                <p class="text-3xl">{{ $report['estimated_revenue'] }}</p>
            </div>
        </div>
    </section>
    <section class="max-w-xl mx-auto py-20">
        <table class="w-full">
            <thead>
            <tr class="text-left">
                <th>客戶代號</th>
                <th>客戶姓名</th>
                <th>總時數</th>
                <th>加班總時數</th>
                <th>每年收入</th>
                <th>所需成本</th>
            </tr>
            </thead>
            <tbody>
            @foreach($report['entries'] as $entry)
                @if($entry['total_hours'] > 0)
                <tr>
                    <td>{{ $entry['client_code'] }}</td>
                    <td>{{ $entry['client_name'] }}</td>
                    <td>{{ $entry['total_hours'] }}</td>
                    <td>{{ $entry['overtime_hours'] }}</td>
                    <td>{{ $entry['annual_revenue'] }}</td>
                    <td>{{ $entry['cost'] }}</td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </section>
@endsection