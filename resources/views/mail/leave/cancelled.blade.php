@component('mail::message')
# Leave cancelled

Hi

{{ $request['requestee']  }} has cancelled their request to take time off from {{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }}) to {{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}).

You don't need to take any action for this.

Thanks,<br>
{{ config('app.name') }}
@endcomponent