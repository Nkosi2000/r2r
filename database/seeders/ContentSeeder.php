<?php

namespace Database\Seeders;

use App\Enums\MediaType;
use App\Models\Event;
use App\Models\MediaItem;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Programme;
use App\Models\ResourceLink;
use App\Models\SiteSetting;
use App\Support\SiteContent;
use Illuminate\Database\Seeder;

/**
 * The site's launch content. Safe to run on every deploy: rows are matched on
 * their natural key and only created when missing, so edits made in the
 * database are never overwritten.
 */
class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedSettings();
        $this->seedPillars();
        $this->seedProgrammes();
        $this->seedPartners();
        $this->seedEvents();
        $this->seedMedia();
        $this->seedResources();

        SiteContent::flush();
    }

    private function seedSettings(): void
    {
        $settings = [
            'about' => 'Rural2Rural (R2R) Skills, Jobs, Careers and Entrepreneurship Initiative is a programme that travels across rural South Africa aimed at educating, training, exposing and advising small businesses, youth, women and people living with disabilities in rural areas to engage in further education and career opportunities, skills development, entrepreneurship opportunities, training and employment opportunities.',
            'mission' => [
                'Celebrating over 10 years of organising career guidance development programmes in rural communities.',
                'Promoting and exposing real opportunities to youth in rural communities.',
                'Hosting capacitation workshops and programmes aimed at school teacher development.',
                'Tackling the national crisis of poverty and unemployment whilst restoring the dignity of rural communities.',
            ],
            'contact' => [
                'email' => 'info@rural2rural.co.za',
                'phone' => '+27 12 440 1325',
                'mobile' => '+27 64 503 4334',
                'address' => ['28 Panorama Road', 'Rooihuiskraal', 'Centurion', '0157'],
                'postal' => [
                    'street_address' => '28 Panorama Road, Rooihuiskraal',
                    'locality' => 'Centurion',
                    'region' => 'Gauteng',
                    'postal_code' => '0157',
                    'country_name' => 'South Africa',
                    'country_code' => 'ZA',
                ],
                'map' => ['label' => 'Gauteng · HQ', 'latitude' => -25.88, 'longitude' => 28.14],
            ],
            'seo' => [
                'title' => 'Rural2Rural — Delivering Real Opportunities to Rural Communities',
                'share_title' => 'Rural2Rural (R2R) | Skills, Jobs, Careers & Entrepreneurship Initiative',
                'description' => 'Rural2Rural (R2R) travels across rural South Africa delivering career guidance, skills training, entrepreneurship support and teacher development to youth, women, small businesses and people living with disabilities. 10+ years on the road. Based in Centurion, Gauteng.',
                'slogan' => 'Delivering real opportunities to rural communities',
                'keywords' => 'Rural2Rural, R2R, rural development South Africa, career guidance, skills development, youth employment, entrepreneurship, SMME support, teacher development, career expo',
            ],
            'social' => [
                ['platform' => 'X / Twitter', 'url' => 'https://twitter.com/Rural2Rural'],
                ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/rural2rural'],
                ['platform' => 'Instagram', 'url' => 'https://www.instagram.com/rural2rural'],
            ],
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::query()->firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    private function seedPillars(): void
    {
        $pillars = [
            ['step' => 'First', 'verb' => 'Careers', 'figure' => 'signpost', 'title' => 'Careers & Job Opportunities', 'body' => 'Career Development programme and RoadShow, R2R Tutor Programme ( Maths, Science and Accounting Extra Classes), Teachers Capacitation Programme and Rural Teachers Summit'],
            ['step' => 'Second', 'verb' => 'Skills', 'figure' => 'gears', 'title' => 'Skills Training Workshops', 'body' => 'R2R Skills and Job Opportunities Roadshow, Soft Skills training programme, Employability/Work readiness skills programme, Job Readiness Programme and R2R Skills and Job Application Centre'],
            ['step' => 'Third', 'verb' => 'Enterprise', 'figure' => 'stall', 'title' => 'Entrepreneurship Opportunities', 'body' => 'R2R Entrepreneurship Opportunities Roadshow, R2R Entrepreneurship trainings and workshops, R2R Business Idea Pitch Competition and Rural SMME Coaching /Mentoring Programme'],
            ['step' => 'Last', 'verb' => 'Teachers', 'figure' => 'chalkboard', 'title' => 'Teacher Development Programmes', 'body' => 'Distributed Across SA rural communities and Municipalities'],
        ];

        foreach ($pillars as $position => $pillar) {
            Pillar::query()->firstOrCreate(['verb' => $pillar['verb']], [...$pillar, 'position' => $position + 1]);
        }
    }

    private function seedProgrammes(): void
    {
        $programmes = [
            ['title' => 'Career Development Programme & Roadshow', 'pillar' => 'Careers'],
            ['title' => 'R2R Tutor Programme', 'pillar' => 'Maths · Science · Accounting'],
            ['title' => 'Teachers Capacitation Programme', 'pillar' => 'Teachers'],
            ['title' => 'Rural Teachers Summit', 'pillar' => 'Teachers'],
            ['title' => 'Entrepreneurship Opportunities Roadshow', 'pillar' => 'Enterprise'],
            ['title' => 'Business Idea Pitch Competition', 'pillar' => 'Enterprise'],
            ['title' => 'Rural SMME Coaching & Mentoring', 'pillar' => 'Enterprise'],
            ['title' => 'Skills & Job Opportunities Roadshow', 'pillar' => 'Skills'],
            ['title' => 'Work-Readiness & Soft Skills Programme', 'pillar' => 'Skills'],
            ['title' => 'Skills & Job Application Centre', 'pillar' => 'Skills'],
        ];

        foreach ($programmes as $position => $programme) {
            Programme::query()->firstOrCreate(['title' => $programme['title']], [...$programme, 'position' => $position + 1]);
        }
    }

    private function seedPartners(): void
    {
        $partners = [
            ['name' => 'EWSETA', 'description' => 'Energy and Water Sector Education and Training Authority', 'logo' => 'images/partners/ewseta.png'],
            ['name' => 'FP&M SETA', 'description' => 'Fibre Processing & Manufacturing Sector Education and Training Authority', 'logo' => 'images/partners/fpm-seta.png'],
            ['name' => 'TETA', 'description' => 'Transport Education Training Authority', 'logo' => 'images/partners/teta.png'],
            ['name' => 'Zakhele N Foundation', 'description' => 'Career Accelerators', 'logo' => 'images/partners/zakhele-n-foundation.png'],
            ['name' => 'Nongoma FM 88.3', 'description' => 'Community radio station', 'logo' => 'images/partners/nongoma-fm.png'],
            ['name' => 'Green Youth Network', 'description' => 'Youth environmental network', 'logo' => 'images/partners/Green-Youth-Network-Logo-1-150x150.jpeg'],
            ['name' => 'Influence Afrika', 'description' => 'Branding agency', 'logo' => 'images/partners/Influence-Afrika-Logo-150x150.png'],
        ];

        foreach ($partners as $position => $partner) {
            Partner::query()->firstOrCreate(['name' => $partner['name']], [...$partner, 'position' => $position + 1]);
        }
    }

    private function seedEvents(): void
    {
        $events = [
            ['title' => 'Careers & Skills Expo', 'place' => 'Free State', 'held_on' => '2018-08-17', 'latitude' => -28.87, 'longitude' => 27.88],
            ['title' => 'Careers & Skills Expo', 'place' => 'KwaZulu-Natal', 'held_on' => '2018-08-03', 'latitude' => -27.43, 'longitude' => 32.06],
            ['title' => 'R2R Career Development', 'place' => 'Northern Cape', 'held_on' => '2017-10-19', 'latitude' => -28.74, 'longitude' => 24.76],
        ];

        foreach ($events as $event) {
            Event::query()->firstOrCreate(['title' => $event['title'], 'place' => $event['place']], $event);
        }
    }

    private function seedMedia(): void
    {
        $media = [
            ['type' => MediaType::Photo, 'title' => 'Career Guidance Roadshow 2022', 'path' => 'images/partners/IMG_0300-scaled.jpg'],
            ['type' => MediaType::Photo, 'title' => 'Learners speak up', 'path' => 'images/gallery/DSC0199-1024x683.jpg'],
            ['type' => MediaType::Photo, 'title' => 'Panel discussion with TETA', 'path' => 'images/gallery/DSC0256-1024x683.jpg'],
            ['type' => MediaType::Photo, 'title' => 'R2R Initiative panel', 'path' => 'images/gallery/IMG_1609-1024x683.jpg'],
            ['type' => MediaType::Photo, 'title' => 'R2R Connect magazine, 2017', 'path' => 'images/gallery/DSC0297-1024x683.jpg'],
            ['type' => MediaType::Photo, 'title' => 'Career guidance session', 'path' => 'images/r2r/learners.jpg'],
            ['type' => MediaType::Photo, 'title' => 'R2R roadshow team', 'path' => 'images/r2r/volunteers.jpg'],
            ['type' => MediaType::Photo, 'title' => 'Community & partners', 'path' => 'images/r2r/leaders.jpg'],
            ['type' => MediaType::Photo, 'title' => 'Rural South Africa', 'path' => 'images/r2r/village.jpg'],
            ['type' => MediaType::Video, 'title' => 'R2R in Marble Hall', 'subtitle' => 'Limpopo', 'path' => 'images/videos/R2R-Limpopo_Marble-Hall.mp4'],
            ['type' => MediaType::Publication, 'title' => 'Rural 2 Rural Opportunities: Connect', 'subtitle' => 'August/September 2017 · Health Special Edition', 'path' => 'images/gallery/DSC0297-1024x683.jpg'],
        ];

        foreach ($media as $position => $item) {
            MediaItem::query()->firstOrCreate(['type' => $item['type'], 'path' => $item['path']], [...$item, 'position' => $position + 1]);
        }
    }

    private function seedResources(): void
    {
        $links = [
            ['group' => 'Study & bursaries', 'title' => 'NSFAS', 'description' => 'National Student Financial Aid Scheme — funding for university and TVET studies.', 'url' => 'https://www.nsfas.org.za'],
            ['group' => 'Jobs & youth opportunities', 'title' => 'SAYouth.mobi', 'description' => 'Zero-rated platform for youth jobs, learnerships and opportunities.', 'url' => 'https://sayouth.mobi'],
            ['group' => 'Jobs & youth opportunities', 'title' => 'NYDA', 'description' => 'National Youth Development Agency — youth business grants and support.', 'url' => 'https://www.nyda.gov.za'],
            ['group' => 'Skills & learnerships (our SETA partners)', 'title' => 'EWSETA', 'description' => 'Energy and Water Sector Education and Training Authority.', 'url' => 'https://www.ewseta.org.za'],
            ['group' => 'Skills & learnerships (our SETA partners)', 'title' => 'FP&M SETA', 'description' => 'Fibre Processing & Manufacturing SETA.', 'url' => 'https://www.fpmseta.org.za'],
            ['group' => 'Skills & learnerships (our SETA partners)', 'title' => 'TETA', 'description' => 'Transport Education Training Authority.', 'url' => 'https://www.teta.org.za'],
        ];

        foreach ($links as $position => $link) {
            ResourceLink::query()->firstOrCreate(['url' => $link['url']], [...$link, 'position' => $position + 1]);
        }
    }
}
