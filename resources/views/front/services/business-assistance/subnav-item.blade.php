@if($isLink)
<a href="{{ $address }}" class="no-underline">
@endif
    <div class="relative flex flex-row md:flex-col justify-start items-center text-center my-4 md:my-0 px-4 pb-2 md:w-32 md:h-32 bg-grey-lighter @if($isLink) hover:bg-orange-light @endif shadow mx-4 rounded no-underline text-navy font-bold">
        <span class="pr-4 md:pr-0 @if(!$isLink) text-grey-dark @endif">{{ $number }}.</span>
        <span @if(!$isLink) class="text-grey-dark" @endif>{{ $text }}</span>
    </div>
@if($isLink)
</a>
@endif