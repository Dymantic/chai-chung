@component('mail::message')
# Request for Leave

Hi

{{ $request['requestee']  }} has requested permission to take time off from {{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }}) to {{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}).

You may log in to either approve or deny this request.

Many Thanks.

@component('mail::button', ['url' => url('/admin/manage-staff-leave')])
    See request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent