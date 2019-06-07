@component('mail::message')
# 代班請求已被拒絕

{{ $request['requestee']  }}您好，

很遺憾{{ $request['covered_by']  }}無法在您請假期間從{{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }})到{{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }})幫您代班。

您需登入系統更新代班人選

謝謝，祝順心。

@component('mail::button', ['url' => url('/admin/leave')])
看代班請求
@endcomponent

@endcomponent