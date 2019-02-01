<form action="/admin/logout" method="POST" class="my-3">
    {!! csrf_field() !!}
    <button type="submit" class="text-grey-darker hover:text-orange-light">Logout</button>
</form>