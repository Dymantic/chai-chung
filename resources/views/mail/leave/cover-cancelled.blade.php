@component('mail::message')
# Request for Cover cancelled

Hi {{ $request['covered_by'] }}

{{ $request['requestee']  }} has cancelled their leave from {{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }}) to {{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}). You no longer need to cover for them.

您無需回覆此通知

謝謝，祝順心。

@endcomponent