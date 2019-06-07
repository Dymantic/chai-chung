@component('mail::message')
# 代班請求已被接受

{{ $request['requestee']  }}您好，

{{ $request['covered_by']  }}已接受在您請假期間從{{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }})到{{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }})幫您代班。

您的請假申請目前正在等候最後批准通知

謝謝，祝順心。

@component('mail::button', ['url' => url('/admin/leave')])
    看請假申請
@endcomponent

@endcomponent