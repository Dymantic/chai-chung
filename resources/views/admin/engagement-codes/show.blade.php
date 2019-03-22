@extends('admin.base')

@section('content')
<engagement-code-page :engagement-code='@json($engagement_code)'></engagement-code-page>
@endsection