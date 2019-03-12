<div class="mb-20 p-8 bg-pale-baby-blue-light shadow max-w-lg mx-auto {{ $classes ?? '' }}" @if($usher ?? false) data-usher @endif>
    <div class="max-w-md mx-auto">
        {{ $slot }}
    </div>
</div>