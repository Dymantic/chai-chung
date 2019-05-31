@extends('admin.base')

@section('content')
    <div class="h-screen w-screen flex justify-center items-center">
        <form action="/admin/password/reset"
              method="POST"
              class="max-w-sm shadow w-screen">
            <p class="text-orange bg-navy py-3 text-center text-xl">設定新密碼</p>
            <div class="p-8">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">
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
                           for="password">輸入新密碼:</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="w-full py-2 border-b border-orange mt-1 pl-2">
                </div>
                <div class="mt-8">
                    <label class="font-bold text-grey-darkest"
                           for="password">新密碼確認</label>
                    <input type="password"
                           name="password_confirmation"
                           id="password"
                           class="w-full py-2 border-b border-orange mt-1 pl-2">
                </div>
                <div class="mt-8">
                    <button type="submit"
                            class="bg-navy hover:bg-navy-light rounded text-orange tracking-wide uppercase font-black w-full py-3">送出</button>
                </div>
            </div>


        </form>
    </div>
@endsection