@php
    $reports = config('rural2rural.reports');
    $mailReportRequest = 'mailto:'.$contact['email'].'?subject='.rawurlencode('Report request');
@endphp

<x-layouts.app title="Reports" description="Rural2Rural annual and impact reports on careers, skills, entrepreneurship and teacher development programmes in rural South Africa.">
    <x-page-header title="Reports" eyebrow="Impact<br>// &amp; accountability">
        Annual and impact reports on our careers, skills, entrepreneurship and teacher development programmes.
    </x-page-header>

    <section class="relative border-t border-white/10 bg-night" aria-labelledby="reports-title">
        <x-rail />
        <div data-reveal class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
            <x-eyebrow first="Our" class="fade-up">reports</x-eyebrow>
            <div>
                <h2 id="reports-title" class="fade-up text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em] delay-100">Reports &amp; documents</h2>

                @if (count($reports))
                    <ul class="mt-10 border-t border-white/10">
                        @foreach ($reports as $report)
                            <li class="border-b border-white/10">
                                <a href="{{ asset($report['file']) }}" target="_blank" rel="noopener" class="group flex items-center justify-between gap-4 py-5 transition-colors hover:text-green">
                                    <span class="flex items-baseline gap-5">
                                        <span class="font-mono text-[11px] text-green">{{ $report['year'] }}</span>
                                        <span class="text-lg">{{ $report['title'] }}</span>
                                    </span>
                                    <span class="font-mono text-[10px] tracking-[0.08em] uppercase">PDF <span aria-hidden="true">↓</span></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="fade-up mt-10 flex flex-col gap-6 border border-dashed border-white/20 p-8 delay-150 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="flex items-center gap-2 font-mono text-[10px] tracking-[0.1em] text-lime uppercase"><i class="animate-blink size-1.5 bg-lime"></i>Coming soon</p>
                            <p class="mt-3 max-w-md text-[15px] leading-relaxed text-white/70">Our reports will be published here. Partners and funders can request them by email in the meantime.</p>
                        </div>
                        <x-button :href="$mailReportRequest" class="shrink-0">Request a report</x-button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @include('sections.work-with-us')
</x-layouts.app>
