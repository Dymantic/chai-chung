@extends('front.base', ['bodyClasses' => 'pt-12'])

@section('content')
    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('contact.intro.heading') }}</h2>
        </div>
    </section>
    <section class="reg-section-space">
        <contact-form :trans='@json(trans("contact.form"))'></contact-form>
    </section>
    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('contact.location.heading') }}</h2>
            <p>{{ trans('contact.location.address') }}</p>
        </div>

    </section>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3640.6353787917665!2d120.64645468447416!3d24.149439941871073!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34693d965c93dccd%3A0x9e365a9054bd0389!2s%E6%A8%93%E4%B9%8B2%2C+No.+61%2C+Section+2%2C+Gongyi+Road%2C+Nantun+District%2C+Taichung+City%2C+408!5e0!3m2!1sen!2stw!4v1551144006614" width="600" height="450" class="w-full" frameborder="0" style="border:0" allowfullscreen></iframe>
@endsection