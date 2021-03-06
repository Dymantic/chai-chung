@extends('admin.base')

@section('content')
    <div class="w-screen h-screen flex justify-center items-center">
        <form action="/admin/password/forgot" method="POST" class="w-screen max-w-sm shadow">
            <p class="text-orange bg-navy py-3 text-center text-xl">設定新密碼</p>
            @if (session('status'))
                <div class="text-navy m-4 p-2 bg-orange-light rounded text-center" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <p class="p-4 text-navy text-lg">填入您帳戶使用的信箱，您會收到郵件指示協助新密碼的設定。</p>
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
                            class="bg-navy hover:bg-navy-light rounded text-orange tracking-wide uppercase font-black w-full py-3">送出</button>
                </div>
            </div>
        </form>
    </div>

@endsection