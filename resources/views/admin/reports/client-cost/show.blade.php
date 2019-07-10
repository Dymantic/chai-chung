@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">Client Cost: {{ $report['date_range'] }}</p>
        <div class="flex justify-end">
            <download-report-button export-url="/admin/exports/reports/client-cost/{{ $report['id'] }}"></download-report-button>
        </div>
    </div>
    <section class="max-w-xl mx-auto">
        <div class="flex justify-between p-8 bg-grey-lightest shadow">
            <div>
                <p>Total Hours</p>
                <p class="text-3xl">{{ $report['total_hours'] }}</p>
            </div>
            <div>
                <p>Total Overtime</p>
                <p class="text-3xl">{{ $report['overtime_hours'] }}</p>
            </div>
            <div>
                <p>Total Cost</p>
                <p class="text-3xl">{{ $report['total_cost'] }}</p>
            </div>
            <div>
                <p>Estimated Revenue</p>
                <p class="text-3xl">{{ $report['estimated_revenue'] }}</p>
            </div>
        </div>
    </section>
    <section class="max-w-xl mx-auto py-20">
        <table class="w-full">
            <thead>
            <tr class="text-left">
                <th>Client Code</th>
                <th>Client Name</th>
                <th>Total Hours</th>
                <th>Total Overtime</th>
                <th>Annual Revenue</th>
                <th>Cost</th>
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