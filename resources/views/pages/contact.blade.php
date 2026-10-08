@php
    $googleMaps = $contact['google_maps'] ?? null;
    $directionsUrl = $googleMaps['url'] ?? 'https://www.google.com/maps/search/?api=1&query='.rawurlencode(implode(', ', [...$contact['address'], $contact['postal']['country_name']]));
    $channels = [
        ['label' => 'Office', 'value' => $contact['phone'], 'href' => 'tel:'.str_replace(' ', '', $contact['phone']), 'action' => 'Call'],
        ['label' => 'Mobile', 'value' => $contact['mobile'], 'href' => 'tel:'.str_replace(' ', '', $contact['mobile']), 'action' => 'Call'],
        ['label' => 'Email', 'value' => $contact['email'], 'href' => 'mailto:'.$contact['email'], 'action' => 'Write'],
    ];
@endphp

<x-layouts.app title="Contact Us" description="Contact Rural2Rural in Centurion, Gauteng — call, email or visit us to partner, host a roadshow or find out about our programmes.">
    <x-page-header title="Contact Us" eyebrow="Get in<br>// touch">
        Want to host a roadshow, partner on a programme or find out more? We'd love to hear from you.
    </x-page-header>

    <section data-header="light" class="bg-paper text-navy" aria-label="Contact details">
        <div data-reveal class="grid gap-10 px-4 py-24 sm:px-8 lg:grid-cols-[1.2fr_1fr] lg:pr-12 lg:pl-[136px] lg:py-28">
            <ul class="grid gap-4 sm:grid-cols-2">
                @foreach ($channels as $channel)
                    <li class="fade-up" style="transition-delay: {{ $loop->index * 80 }}ms">
                        <a href="{{ $channel['href'] }}" class="group flex h-full flex-col bg-white p-6 ring-1 ring-navy/10 transition duration-500 ease-out-expo hover:-translate-y-1 hover:shadow-[0_24px_50px_-28px_rgba(41,49,121,0.45)] hover:ring-blue/40">
                            <span class="font-mono text-[10px] tracking-[0.1em] text-blue uppercase">{{ sprintf('%02d', $loop->iteration) }} // {{ $channel['label'] }}</span>
                            <span class="mt-6 text-xl tracking-[-0.02em] break-all">{{ $channel['value'] }}</span>
                            <span class="mt-auto pt-5 font-mono text-[10px] tracking-[0.08em] text-navy/50 uppercase transition-colors group-hover:text-blue">{{ $channel['action'] }} <span aria-hidden="true">↳</span></span>
                        </a>
                    </li>
                @endforeach
                <li class="fade-up" style="transition-delay: 240ms">
                    <div class="flex h-full flex-col bg-white p-6 ring-1 ring-navy/10">
                        <span class="font-mono text-[10px] tracking-[0.1em] text-blue uppercase">04 // Follow</span>
                        <ul class="mt-6 flex gap-2">
                            @foreach ($social as $label => $href)
                                <li>
                                    <a href="{{ $href }}" target="_blank" rel="noopener" aria-label="Rural2Rural on {{ $label }} (opens in a new tab)" class="grid size-10 place-items-center rounded-full bg-navy/[0.06] text-navy transition-colors hover:bg-navy hover:text-white">
                                        <x-social-icon :platform="$label" class="size-[18px]" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>

            <div class="fade-up flex flex-col bg-night p-8 text-white delay-200 sm:p-10">
                <p class="flex items-center gap-2 font-mono text-[10px] tracking-[0.1em] text-white/70 uppercase"><i class="size-1.5 rounded-full bg-green"></i>Head office</p>
                <address class="mt-6 text-[clamp(1.4rem,2.2vw,1.9rem)] leading-[1.25] font-light tracking-[-0.02em] not-italic">
                    {!! implode('<br>', array_map('e', $contact['address'])) !!}
                </address>
                <div class="mt-auto flex flex-wrap items-center gap-6 pt-10">
                    <x-button :href="$directionsUrl" target="_blank" rel="noopener">Get directions</x-button>
                    <a href="{{ $mailPartner }}" class="font-mono text-[11px] tracking-[0.08em] uppercase underline-offset-4 hover:text-green hover:underline">Partner with us</a>
                </div>
            </div>
        </div>

        {{-- Live Google map of the office --}}
        @if ($googleMaps)
            <div class="px-4 pb-24 sm:px-8 lg:pr-12 lg:pb-28 lg:pl-[136px]">
                <figure class="overflow-hidden bg-white ring-1 ring-navy/10">
                    <iframe
                        src="https://maps.google.com/maps?q={{ $googleMaps['latitude'] }},{{ $googleMaps['longitude'] }}&z=16&hl=en&output=embed"
                        title="Map showing the Rural2Rural office at {{ $googleMaps['place'] }}"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                        class="block h-[360px] w-full border-0 sm:h-[440px]"
                    ></iframe>
                    <figcaption class="flex flex-wrap items-center justify-between gap-3 border-t border-navy/10 px-5 py-4">
                        <span class="flex items-center gap-2 font-mono text-[10px] tracking-[0.1em] text-navy/70 uppercase"><i class="size-1.5 rounded-full bg-green"></i>{{ $googleMaps['place'] }} · {{ $contact['postal']['locality'] }}</span>
                        <a href="{{ $googleMaps['url'] }}" target="_blank" rel="noopener" class="font-mono text-[10px] tracking-[0.1em] text-blue uppercase underline-offset-4 hover:underline">Open in Google Maps <span aria-hidden="true">↗</span></a>
                    </figcaption>
                </figure>
            </div>
        @endif
    </section>
</x-layouts.app>
