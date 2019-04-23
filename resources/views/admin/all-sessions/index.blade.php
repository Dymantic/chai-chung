@extends('admin.base')

@section('content')
<manage-sessions :clients='@json($clients)' :staff='@json($staff)'></manage-sessions>
@endsection