@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">Staff Cost: {{ $report['date_range'] }}</p>
        <div class="flex justify-end">
            <download-report-button export-url="/admin/exports/reports/staff-cost/{{ $report['id'] }}"></download-report-button>
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
                <p class="text-3xl">{{ $report['cost'] }}</p>
            </div>
        </div>
    </section>
    <section class="max-w-xl mx-auto py-20">
        <table class="w-full">
            <thead>
            <tr class="text-left">
                <th>Staff Code</th>
                <th>Name</th>
                <th>Total Hours</th>
                <th>Total Overtime</th>
                <th>Hourly Rate</th>
                <th>Cost</th>
            </tr>
            </thead>
            <tbody>
            @foreach($report['entries'] as $entry)
                <tr>
                    <td>{{ $entry['user_code'] }}</td>
                    <td>{{ $entry['user_name'] }}</td>
                    <td>{{ $entry['total_hours'] }}</td>
                    <td>{{ $entry['overtime_hours'] }}</td>
                    <td>{{ $entry['hourly_rate'] }}</td>
                    <td>{{ $entry['cost'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection