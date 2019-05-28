@if($isLink)
<a href="{{ localUrl("/business-formation") }}" class="no-underline">
@endif
    <div class="biz-ass-subnav-item item-{{ $number }} block flex justify-center items-center text-center p-4 w-32 h-32 bg-grey-lighter @if($isLink) shadow-lg hover:bg-orange-light @endif  mx-4 rounded no-underline text-navy font-bold">
        {{ $text }}
    </div>
@if($isLink)
</a>
@endif