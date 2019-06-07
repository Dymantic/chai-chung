@component('mail::message')
# 員工取消請假申請

您好，

{{ $request['requestee']  }}已取消從{{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }})到{{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }})的請假申請。

您無需回覆此通知

謝謝，祝順心。

@endcomponent