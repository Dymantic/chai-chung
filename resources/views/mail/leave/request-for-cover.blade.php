@component('mail::message')
# 代班請求

{{ $request['covered_by'] }}您好，

{{ $request['requestee']  }} 已提出代班請求，代班時間從{{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }})到{{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}).

您可以登入系統回覆是否接受本次的代班請求

謝謝，祝順心。

@component('mail::button', ['url' => url('/admin/covering-requests')])
看代班細節
@endcomponent

@endcomponent