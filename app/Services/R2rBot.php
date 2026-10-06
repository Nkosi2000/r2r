<?php

namespace App\Services;

use Anthropic\Client;
use Anthropic\Core\Exceptions\AnthropicException;
use App\Exceptions\R2rBotUnavailableException;

class R2rBot
{
    public function __construct(private Client $client) {}

    /**
     * Ask Claude for r2rBot's next reply in the conversation.
     *
     * @param  list<array{role: 'user'|'assistant', content: string}>  $messages
     *
     * @throws R2rBotUnavailableException
     */
    public function reply(array $messages): string
    {
        if (blank(config('services.anthropic.key'))) {
            throw new R2rBotUnavailableException('ANTHROPIC_API_KEY is not configured.');
        }

        try {
            $response = $this->client->beta->messages->create(
                model: config('rural2rural.bot.model'),
                maxTokens: config('rural2rural.bot.max_tokens'),
                system: $this->systemPrompt(),
                messages: $messages,
                outputConfig: ['effort' => 'low'],
                fallbacks: 'default',
                betas: ['server-side-fallback-2026-07-01'],
            );
        } catch (AnthropicException $exception) {
            throw new R2rBotUnavailableException('r2rBot could not reach the Claude API.', previous: $exception);
        }

        if ($response->stopReason === 'refusal') {
            return "I can't help with that one, but I'm happy to answer questions about Rural2Rural's programmes, events or how to get in touch.";
        }

        $reply = collect($response->content)
            ->filter(fn (object $block): bool => $block->type === 'text')
            ->map(fn (object $block): string => $block->text)
            ->implode("\n");

        return trim($reply) !== ''
            ? trim($reply)
            : 'Sorry, I lost my train of thought. Could you ask that again?';
    }

    /**
     * Build the system prompt from the site's own content so r2rBot only answers from known facts.
     */
    public function systemPrompt(): string
    {
        $site = config('rural2rural');
        $contact = $site['contact'];

        $mission = collect($site['mission'])->map(fn (string $line): string => "- {$line}")->implode("\n");
        $pillars = collect($site['pillars'])->map(fn (array $pillar): string => "- {$pillar['title']}: {$pillar['body']}")->implode("\n");
        $programmes = collect($site['programmes'])->map(fn (array $programme): string => "- {$programme['title']} ({$programme['pillar']})")->implode("\n");
        $events = collect($site['events'])->map(fn (array $event): string => "- {$event['title']}, {$event['place']}, {$event['date']}")->implode("\n");
        $social = collect($site['social'])->map(fn (string $url, string $name): string => "- {$name}: {$url}")->implode("\n");
        $address = implode(', ', $contact['address']);

        return <<<PROMPT
        You are r2rBot, the friendly assistant on the Rural2Rural (R2R) website. Visitors are learners, parents, teachers, small business owners, municipalities and potential partners, mostly from rural South Africa. Many are reading on a phone with limited data.

        Answer only from the facts below. If someone asks for something the facts don't cover, such as upcoming event dates, application deadlines, fees, eligibility rules or funding amounts, say you don't have that information and point them to the R2R team using the contact details. Never invent dates, numbers, people, partners or promises.

        Keep replies short and warm: two to four sentences, or a few "-" bullets when listing. Write plain text without Markdown headings, bold or tables. Reply in the language the visitor writes in when you can. If a question has nothing to do with Rural2Rural, politely steer back to what you can help with.

        <about>
        {$site['about']}
        </about>

        <mission>
        {$mission}
        </mission>

        <programme_pillars>
        {$pillars}
        </programme_pillars>

        <programmes>
        {$programmes}
        </programmes>

        <past_events>
        {$events}
        </past_events>

        <contact>
        - Email: {$contact['email']}
        - Phone: {$contact['phone']}
        - Mobile: {$contact['mobile']}
        - Office: {$address}
        {$social}
        </contact>

        To partner with R2R, host a roadshow in a community, or sponsor a programme, visitors should email {$contact['email']} or call {$contact['phone']}.
        PROMPT;
    }
}
