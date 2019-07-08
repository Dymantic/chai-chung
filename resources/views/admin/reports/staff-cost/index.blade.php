@extends('admin.base')

@section('content')
    <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
        <p class="font-black text-5xl">Monthly Staff Cost Reports</p>
        <div class="flex justify-end">

        </div>
    </div>
    <section class="max-w-xl mx-auto py-20">
        <table class="w-full">
            <thead>
            <tr class="text-left">
                <th>Report Dates</th>
                <th>Number of Staff</th>
                <th>Total Hours</th>
                <th>Total Overtime</th>
                <th>Total Cost</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
            <tr>
                <td>
                    <a href="/admin/manage-reports/staff-cost/{{ $report['id'] }}" class="text-navy hover:text-orange">
                        {{ $report['date_range'] }}
                    </a>
                </td>
                <td>{{ $report['entries_count'] }}</td>
                <td>{{ $report['total_hours'] }}</td>
                <td>{{ $report['overtime_hours'] }}</td>
                <td>{{ $report['cost'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection