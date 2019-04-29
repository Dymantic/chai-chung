@component('mail::message')
# Leave approved

Hi {{ $request['requestee']  }}

{{ $request['decider']  }} has approved your request to take time off from {{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }}) to {{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}).

Many thanks.

@component('mail::button', ['url' => url('/admin/leave')])
    See request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent