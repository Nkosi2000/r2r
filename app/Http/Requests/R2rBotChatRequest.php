<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class R2rBotChatRequest extends FormRequest
{
    /**
     * r2rBot is public; abuse is handled by rate limiting.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'messages' => ['required', 'array', 'min:1', 'max:'.config('rural2rural.bot.max_turns')],
            'messages.*.role' => ['required', 'string', 'in:user,assistant'],
            'messages.*.content' => ['required', 'string', 'max:'.config('rural2rural.bot.max_message_length')],
        ];
    }

    /**
     * The conversation must start and end with the visitor.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $messages = $this->input('messages', []);

                if (! is_array($messages) || $messages === []) {
                    return;
                }

                if (($messages[0]['role'] ?? null) !== 'user' || (end($messages)['role'] ?? null) !== 'user') {
                    $validator->errors()->add('messages', 'The conversation must start and end with a visitor message.');
                }
            },
        ];
    }

    /**
     * The validated conversation in the shape the Claude API expects.
     *
     * @return list<array{role: 'user'|'assistant', content: string}>
     */
    public function conversation(): array
    {
        return collect($this->validated('messages'))
            ->map(fn (array $message): array => [
                'role' => $message['role'],
                'content' => trim($message['content']),
            ])
            ->values()
            ->all();
    }
}
