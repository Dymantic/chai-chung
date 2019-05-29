<a href="{{ localUrl($url) }}" class="no-underline">
    <div data-usher class="bg-baby-blue-opq hover:bg-orange-opaque md:w-80 md:h-80 mx-auto sm:mx-4 my-4 max-w-full p-4 md:p-8 flex md:flex-col md:justify-between items-center text-white hover:text-orange-light shadow">
        @include($icon, ['classes' => 'h-12 md:h-40'])
        <p class="text-navy h3 md:h2 text-center pl-4 md:pl-0">{{ $title }}</p>
    </div>
</a>