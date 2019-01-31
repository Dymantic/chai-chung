@extends('admin.base')

@section('content')
    <form action="/admin/password/reset" method="POST">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label for="email">Your email address</label>
            <input type="email" value="{{ old('email') }}" name="email">
        </div>
        <div>
            <label for="password">Your new password:</label>
            <input type="password" value="" name="password">
        </div>
        <div>
            <label for="password">Confirm password:</label>
            <input type="password" value="" name="password_confirmation">
        </div>
        <div>
            <button type="submit">Reset</button>
        </div>
    </form>
@endsection