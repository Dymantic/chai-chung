@extends('admin.base')

@section('content')
    <div class="w-screen h-screen flex justify-center items-center">
        <form action="/admin/password/forgot" method="POST" class="w-screen max-w-sm shadow">
            <p class="text-orange bg-navy py-3 text-center text-xl">Request New Password</p>
            @if (session('status'))
                <div class="text-navy m-4 p-2 bg-orange-light rounded text-center" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <p class="p-4 text-navy text-lg">Fill out your email that was used for your account, and an email will be sent to that account with a link to help you set up a new password and log back in.</p>
            <div class="p-8">
                {!! csrf_field() !!}
                <div>
                    <label class="font-bold text-grey-darkest"
                           for="email">Email:</label>
                    <input type="email"
                           class="w-full py-2 border-b border-orange mt-1 pl-2"
                           name="email"
                           id="email"
                           autofocus>
                </div>

                <div class="mt-8">
                    <button type="submit"
                            class="bg-navy hover:bg-navy-light rounded text-orange tracking-wide uppercase font-black w-full py-3">Request Reset
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection