<?php

return [

    /*
    |--------------------------------------------------------------------------
    | r2rBot
    |--------------------------------------------------------------------------
    |
    | The AI assistant on the site. It answers only from the site content in
    | the database (see App\Support\SiteContent) and is rate limited per
    | visitor to keep API spend predictable.
    |
    | All other site content (contact details, pillars, programmes, partners,
    | events, media, resources and reports) lives in the database and is
    | seeded by Database\Seeders\ContentSeeder.
    |
    */

    'bot' => [
        'model' => env('R2R_BOT_MODEL', 'claude-opus-5-5'),
        'max_tokens' => (int) env('R2R_BOT_MAX_TOKENS', 4096),
        'max_turns' => 20,
        'max_message_length' => 1000,
        'per_minute' => (int) env('R2R_BOT_PER_MINUTE', 8),
        'per_day' => (int) env('R2R_BOT_PER_DAY', 60),
    ],

];
