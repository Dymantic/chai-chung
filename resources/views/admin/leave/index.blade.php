@extends('admin.base')

@section('content')
<staff-leave-page :user-list='@json($users)'></staff-leave-page>
@endsection