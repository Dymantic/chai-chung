@component('mail::message')
# 請假未獲准

{{ $request['requestee']  }}您好，

很遺憾{{ $request['decider']  }}未批准您申請從{{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }})到{{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }})的請假事宜。

謝謝，祝順心。

@component('mail::button', ['url' => url('/admin/leave')])
看請假申請
@endcomponent

@endcomponent