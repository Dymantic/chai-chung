@extends('front.base', ['bodyClasses' => 'pt-12'])

@section('content')
    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('contact.intro.heading') }}</h2>
            <p class="mt-8 mb-20">{{ trans('contact.intro.content') }}</p>
            <contact-form :trans='@json(trans("contact.form"))'></contact-form>
        </div>
    </section>
    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('contact.location.heading') }}</h2>
            <p>{{ trans('contact.location.address') }}</p>
        </div>

    </section>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3640.6007939641504!2d120.64828931544035!3d24.150653879283702!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34693d965c93dccd%3A0xf977bbe82b73f74e!2z5ZiJ55y-5pyD6KiI5bir5LqL5YuZ5omA!5e0!3m2!1sen!2stw!4v1560908414009!5m2!1sen!2stw" class="w-full" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
@endsection