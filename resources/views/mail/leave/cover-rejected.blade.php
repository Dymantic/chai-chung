@component('mail::message')
# Cover rejected

Hi {{ $request['requestee']  }}

Unfortunately {{ $request['covered_by']  }} is not able to cover for you when you take time off from {{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }}) to {{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}).

You will need to update your request to ask someone else to cover for you.

Many thanks.

@component('mail::button', ['url' => url('/admin/leave')])
    See request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent