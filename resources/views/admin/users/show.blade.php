@extends('admin.base')

@section('content')
<user-page :user='@json($user)'></user-page>
@endsection