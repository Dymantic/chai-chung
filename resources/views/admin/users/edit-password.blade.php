@extends('admin.base')

@section('content')
    <form action="/admin/users/{{ auth()->user()->id }}/password"
          method="POST"
          class="max-w-sm mx-auto mt-20 shadow"
    >
        <p class="py-3 bg-navy text-orange text-center font-bold text-xl mb-8">更改密碼</p>
        <p class="text-grey-darker px-4 text-center mb-8">更改密碼的同時，您會保持登入的狀態。</p>
        {!! csrf_field() !!}
        <div class="p-4">
            <div>
                <label class="font-bold text-grey-darkest"
                       for="current_password">舊密碼:</label>
                <span class="text-sm text-red">{{ $errors->first('current_password') }}</span>
                <input type="password"
                       class="w-full py-2 border-b border-orange mt-1 pl-2"
                       name="current_password"
                       id="current_password"
                       autofocus>
            </div>
            <div class="mt-8">
                <label class="font-bold text-grey-darkest"
                       for="password">新密碼:</label>
                <span class="text-sm text-red">{{ $errors->first('password') }}</span>
                <input type="password"
                       name="password"
                       id="password"
                       class="w-full py-2 border-b border-orange mt-1 pl-2">
            </div>
            <div class="mt-8">
                <label class="font-bold text-grey-darkest"
                       for="password_confirmation">新密碼確認:</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="w-full py-2 border-b border-orange mt-1 pl-2">
            </div>
            <div class="mt-8">
                <button type="submit"
                        class="bg-navy hover:bg-navy-light rounded text-orange tracking-wide uppercase font-black w-full py-3">
送出
                </button>
            </div>
        </div>

    </form>
@endsection