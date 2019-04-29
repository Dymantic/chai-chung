@component('mail::message')
# Request to Cover

Hi {{ $request['covered_by'] }}

{{ $request['requestee']  }} has requested for you to cover for them when they take time off from {{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }}) to {{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}).

You may log in to either accept or reject this request.

Many Thanks.

@component('mail::button', ['url' => url('/admin/covering-requests')])
See request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent