@component('mail::message')
# Cover accepted

Hi {{ $request['requestee']  }}

{{ $request['covered_by']  }} has agreed to cover for you when you take time off from {{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }}) to {{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}).

You request will now be sent through for final approval.

Many thanks.

@component('mail::button', ['url' => url('/admin/leave')])
    See request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent