@extends('admin.base')

@section('content')
    <form action="/admin/password/forgot" method="POST">
        {!! csrf_field() !!}
        <div>
            <label for="email">Your email address</label>
            <input type="email" value="{{ old('email') }}" name="email">
        </div>
        <div>
            <button type="submit">Request Reset</button>
        </div>
    </form>
@endsection