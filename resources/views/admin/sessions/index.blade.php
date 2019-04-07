@extends('admin.base')

@section('content')
    <user-sessions-index :clients='@json($clients)'
                         :engagements='@json($engagement_codes)'
                         :service_periods='@json($service_periods)'
    ></user-sessions-index>
@endsection