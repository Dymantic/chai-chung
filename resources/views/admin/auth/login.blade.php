@extends('admin.base')

@section('content')
    <div class="h-screen w-screen flex justify-center items-center">
        <form action="/admin/login"
              method="POST"
              class="max-w-sm shadow w-screen">
            <p class="text-orange bg-navy py-3 text-center text-xl">Hi there! Please login.</p>
            <div class="px-8 pt-8">
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
                    <label class="font-bold text-grey-darkest"
                           for="password">Password:</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="w-full py-2 border-b border-orange mt-1 pl-2">
                </div>
                <div class="mt-8">
                    <button type="submit"
                            class="bg-navy hover:bg-navy-light rounded text-orange tracking-wide uppercase font-black w-full py-3">Login
                    </button>
                </div>
            </div>
            <p class="my-4 text-grey-dark text-center">
                <a href="/admin/password/forgot" class="text-grey-dark hover:text-orange no-underline">I forgot my password</a>
            </p>

        </form>
    </div>
@endsection