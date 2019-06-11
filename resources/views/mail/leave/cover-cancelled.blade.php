@component('mail::message')
# 代班請求已取消

{{ $request['covered_by'] }}您好

{{ $request['requestee']  }}已經取消了從{{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }})到{{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }})的請假申請。 因此，您將無需代班。

您無需回覆此通知。

謝謝，祝順心。

@endcomponent