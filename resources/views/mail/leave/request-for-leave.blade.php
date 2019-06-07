@component('mail::message')
# 員工請假申請

您好

{{ $request['requestee']  }}已提出請假申請，請假時間從{{ $request['starts_date'] }} ({{ $request['starts_day'] }} - {{ $request['starts_time'] }})到{{ $request['ends_date'] }} ({{ $request['ends_day'] }} - {{ $request['ends_time'] }}).

您可以登入系統回覆是否批准本次請假

謝謝，祝順心。

@component('mail::button', ['url' => url('/admin/manage-staff-leave')])
    看請假細節
@endcomponent

@endcomponent