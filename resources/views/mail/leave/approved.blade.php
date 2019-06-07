@component('mail::message')
# 請假申請已批准

{{ $request['requestee']  }}您好，

{{ $request['decider']  }}已批准您申請從{{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }})到{{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }})的請假事宜。

謝謝，祝順心。

@component('mail::button', ['url' => url('/admin/leave')])
看請假申請
@endcomponent

@endcomponent