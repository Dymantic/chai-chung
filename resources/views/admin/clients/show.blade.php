@extends('admin.base')

@section('content')
<client-page :client='@json($client)'></client-page>
@endsection