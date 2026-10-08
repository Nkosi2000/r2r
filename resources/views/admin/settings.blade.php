@php
    $contact = $settings['contact'] ?? [];
    $seo = $settings['seo'] ?? [];
    $socialRows = old('social', [...($settings['social'] ?? []), ...array_fill(0, 3, ['platform' => '', 'url' => ''])]);
    $sections = ['about' => 'About & mission', 'contact' => 'Contact details', 'seo' => 'Search & sharing', 'social' => 'Social links'];
@endphp

<x-layouts.admin title="Site settings">
    <x-admin.page-header title="Site settings" description="Organisation-wide details used across the website, in search results and in r2rBot's answers." />

    <nav aria-label="Settings sections" class="mb-8 flex flex-wrap gap-x-5 gap-y-2 text-[13px]">
        @foreach ($sections as $id => $label)
            <a href="#{{ $id }}" class="text-blue hover:underline">{{ $label }}</a>
        @endforeach
    </nav>

    <div class="grid gap-12">
        {{-- ─────────────── About & mission ─────────────── --}}
        <section id="about" class="scroll-mt-6" aria-labelledby="about-title">
            <h2 id="about-title" class="mb-3 text-xl tracking-[-0.02em]">About &amp; mission</h2>
            <x-admin.form :action="route('admin.settings.about')" method="PUT" submit="Save about & mission" :fields="['about', 'mission']">
                <x-admin.textarea name="about" label="About Rural2Rural" :value="$settings['about'] ?? ''" rows="5" hint="A summary of the organisation. r2rBot uses it to answer visitors." required />
                <x-admin.textarea name="mission" label="Mission commitments" :value="$settings['mission'] ?? []" rows="6" hint="One commitment per line, up to 8. Shown as numbered cards on the Who We Are page." required />
            </x-admin.form>
        </section>

        {{-- ─────────────── Contact ─────────────── --}}
        <section id="contact" class="scroll-mt-6" aria-labelledby="contact-title">
            <h2 id="contact-title" class="mb-3 text-xl tracking-[-0.02em]">Contact details</h2>
            <x-admin.form :action="route('admin.settings.contact')" method="PUT" submit="Save contact details" :fields="['email', 'phone', 'mobile', 'address', 'postal', 'map', 'google_maps']">
                <div class="grid gap-6 sm:grid-cols-3">
                    <x-admin.input name="email" label="Email" type="email" :value="$contact['email'] ?? ''" required />
                    <x-admin.input name="phone" label="Office phone" :value="$contact['phone'] ?? ''" required />
                    <x-admin.input name="mobile" label="Mobile" :value="$contact['mobile'] ?? ''" required />
                </div>

                <x-admin.textarea name="address" label="Address as shown on the Contact page" :value="$contact['address'] ?? []" rows="4" hint="One line per line, e.g. street, suburb, town, postal code." required />

                <fieldset class="grid gap-6 border-t border-navy/10 pt-6">
                    <legend class="text-[13px] font-medium">Postal address for search engines</legend>
                    <div class="grid gap-6 sm:grid-cols-2">
                        <x-admin.input name="postal[street_address]" label="Street address" :value="$contact['postal']['street_address'] ?? ''" required />
                        <x-admin.input name="postal[locality]" label="Town or city" :value="$contact['postal']['locality'] ?? ''" required />
                        <x-admin.input name="postal[region]" label="Province" :value="$contact['postal']['region'] ?? ''" required />
                        <x-admin.input name="postal[postal_code]" label="Postal code" :value="$contact['postal']['postal_code'] ?? ''" required />
                        <x-admin.input name="postal[country_name]" label="Country" :value="$contact['postal']['country_name'] ?? 'South Africa'" required />
                        <x-admin.input name="postal[country_code]" label="Country code" :value="$contact['postal']['country_code'] ?? 'ZA'" hint="Two letters, e.g. ZA." required />
                    </div>
                </fieldset>

                <fieldset class="grid gap-6 border-t border-navy/10 pt-6">
                    <legend class="text-[13px] font-medium">Head office pin on the “On the road” map</legend>
                    <div class="grid gap-6 sm:grid-cols-3">
                        <x-admin.input name="map[label]" label="Label" :value="$contact['map']['label'] ?? ''" required />
                        <x-admin.input name="map[latitude]" label="Latitude" type="number" step="any" :value="$contact['map']['latitude'] ?? ''" required />
                        <x-admin.input name="map[longitude]" label="Longitude" type="number" step="any" :value="$contact['map']['longitude'] ?? ''" required />
                    </div>
                </fieldset>

                <fieldset class="grid gap-6 border-t border-navy/10 pt-6">
                    <legend class="text-[13px] font-medium">Google map on the Contact page <span class="font-normal text-navy/55">(optional — clear all four to hide it)</span></legend>
                    <div class="grid gap-6 sm:grid-cols-2">
                        <x-admin.input name="google_maps[place]" label="Place name" :value="$contact['google_maps']['place'] ?? ''" />
                        <x-admin.input name="google_maps[url]" label="Google Maps share link" type="url" :value="$contact['google_maps']['url'] ?? ''" placeholder="https://maps.app.goo.gl/…" />
                        <x-admin.input name="google_maps[latitude]" label="Latitude" type="number" step="any" :value="$contact['google_maps']['latitude'] ?? ''" />
                        <x-admin.input name="google_maps[longitude]" label="Longitude" type="number" step="any" :value="$contact['google_maps']['longitude'] ?? ''" />
                    </div>
                </fieldset>
            </x-admin.form>
        </section>

        {{-- ─────────────── SEO ─────────────── --}}
        <section id="seo" class="scroll-mt-6" aria-labelledby="seo-title">
            <h2 id="seo-title" class="mb-3 text-xl tracking-[-0.02em]">Search &amp; sharing</h2>
            <x-admin.form :action="route('admin.settings.seo')" method="PUT" submit="Save search & sharing" :fields="['title', 'share_title', 'description', 'slogan', 'keywords']">
                <x-admin.input name="title" label="Home page title" :value="$seo['title'] ?? ''" hint="Shown in browser tabs and Google results." required />
                <x-admin.input name="share_title" label="Title when shared" :value="$seo['share_title'] ?? ''" hint="Shown on WhatsApp, Facebook and LinkedIn link previews." required />
                <x-admin.textarea name="description" label="Description" :value="$seo['description'] ?? ''" rows="3" hint="One or two sentences, up to 300 characters. Shown under the title in Google." required />
                <x-admin.input name="slogan" label="Slogan" :value="$seo['slogan'] ?? ''" required />
                <x-admin.textarea name="keywords" label="Keywords" :value="$seo['keywords'] ?? ''" rows="2" hint="Comma separated." required />
            </x-admin.form>
        </section>

        {{-- ─────────────── Social ─────────────── --}}
        <section id="social" class="scroll-mt-6" aria-labelledby="social-title">
            <h2 id="social-title" class="mb-3 text-xl tracking-[-0.02em]">Social links</h2>
            <x-admin.form :action="route('admin.settings.social')" method="PUT" submit="Save social links" :fields="['social']">
                <p class="text-[13px] text-navy/65">Shown in the footer, sidebar and Contact page. Facebook, Instagram and X / Twitter get their own icons. Clear a row to remove it.</p>
                @foreach ($socialRows as $index => $row)
                    <div class="grid gap-4 sm:grid-cols-[12rem_1fr]">
                        <x-admin.input name="social[{{ $index }}][platform]" label="Platform" :value="$row['platform'] ?? ''" placeholder="e.g. Facebook" />
                        <x-admin.input name="social[{{ $index }}][url]" label="Profile link" type="url" :value="$row['url'] ?? ''" placeholder="https://" />
                    </div>
                @endforeach
            </x-admin.form>
        </section>
    </div>
</x-layouts.admin>
