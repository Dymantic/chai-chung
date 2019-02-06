@extends('admin.base')

@section('content')
<profile-page :user='@json($user)'></profile-page>
@endsection