<x-layouts.app title="Resources" description="Useful links for rural learners, job seekers, teachers and small businesses — bursaries, youth opportunities, skills and learnerships.">
    <x-page-header title="Resources" eyebrow="Useful<br>// links">
        Trusted places to find bursaries, jobs, learnerships and support, for learners, job seekers, teachers and small businesses.
    </x-page-header>

    <section data-header="light" class="bg-paper text-navy" aria-label="Resource links">
        <div data-reveal class="grid gap-16 px-4 py-24 sm:px-8 lg:pr-12 lg:pl-[136px] lg:py-28">
            @foreach (config('rural2rural.resources') as $group)
                <div class="fade-up grid gap-6 lg:grid-cols-[1fr_2.4fr]" style="transition-delay: {{ $loop->index * 100 }}ms">
                    <h2 class="tag text-blue">{{ sprintf('%02d', $loop->iteration) }}<br>// {{ $group['group'] }}</h2>
                    <ul class="grid gap-4 md:grid-cols-2">
                        @foreach ($group['links'] as $link)
                            <li>
                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="group flex h-full flex-col bg-white p-6 ring-1 ring-navy/10 transition duration-500 ease-out-expo hover:-translate-y-1 hover:shadow-[0_24px_50px_-28px_rgba(41,49,121,0.45)] hover:ring-blue/40">
                                    <span class="flex items-start justify-between gap-4">
                                        <span class="text-xl tracking-[-0.02em]">{{ $link['title'] }}</span>
                                        <span class="text-blue transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true">↗</span>
                                    </span>
                                    <span class="mt-2 text-[14px] leading-relaxed text-navy/65">{{ $link['description'] }}</span>
                                    <span class="mt-auto pt-5 font-mono text-[10px] tracking-[0.08em] text-navy/45 uppercase">{{ parse_url($link['url'], PHP_URL_HOST) }}<span class="sr-only"> (opens in a new tab)</span></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <p class="fade-up max-w-2xl font-mono text-[10px] leading-relaxed tracking-[0.08em] text-navy/50 uppercase">These links open external websites that Rural2Rural does not run. Questions? Ask r2rBot or email <a href="mailto:{{ $contact['email'] }}" class="text-blue underline underline-offset-4">{{ $contact['email'] }}</a>.</p>
        </div>
    </section>

    @include('sections.work-with-us')
</x-layouts.app>
