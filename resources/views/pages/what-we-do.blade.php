<x-layouts.app title="What We Do" description="Rural2Rural's four programme pillars — careers & jobs, skills training, entrepreneurship and teacher development — delivered through roadshows across rural South Africa.">
    <x-page-header title="What We Do" eyebrow="Programmes<br>// Four pillars">
        Four programme pillars and {{ count($programmes) }} programmes, delivered where people live: in rural schools, towns and municipalities.
    </x-page-header>

    @include('sections.pillars')
    @include('sections.programme-list')
    @include('sections.how-we-work')
    @include('sections.work-with-us')
</x-layouts.app>
