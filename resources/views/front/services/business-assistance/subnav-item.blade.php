@if($isLink)
<a href="{{ localUrl("/business-formation") }}" class="no-underline">
@endif
    <div class="relative flex md:justify-start md:justify-center items-center text-center my-4 md:my-0 p-4 md:w-32 md:h-32 bg-grey-lighter @if($isLink) shadow-lg hover:bg-orange-light @endif  mx-4 rounded no-underline text-navy font-bold">
        <span class="md:absolute md:pin-t md:pin-l mr-4 text-orange md:pl-2">{{ $number }}.</span>
        {{ $text }}
    </div>
@if($isLink)
</a>
@endif