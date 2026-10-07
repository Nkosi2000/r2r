<x-layouts.app :preloader="true">
    @include('sections.hero')
    @include('sections.about-statement', ['moreLink' => route('about')])
    @include('sections.pillars')
    @include('sections.programme-list', ['moreLink' => route('what-we-do')])
    @include('sections.stripe-band')
    @include('sections.mission')
    @include('sections.how-we-work')
    @include('sections.on-the-road', ['moreLink' => route('events')])
    @include('sections.partners', ['moreLink' => route('partners')])
    @include('sections.work-with-us')
</x-layouts.app>
