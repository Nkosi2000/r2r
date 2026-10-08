<?php

namespace App\Http\Requests\Admin;

use App\Enums\MediaType;
use App\Models\MediaItem;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MediaItemRequest extends FormRequest
{
    /**
     * Any signed-in staff member may edit content; the route's auth middleware guarantees one is present.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Photos and publication covers are images; videos are MP4 or WebM. A file is required when adding;
     * when editing, leaving it empty keeps the current one. The type can't change after upload.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $mediaItem = $this->route('mediaItem');
        $type = $mediaItem instanceof MediaItem ? $mediaItem->type : MediaType::tryFrom((string) $this->input('type'));

        $fileRules = $type === MediaType::Video
            ? ['mimetypes:video/mp4,video/webm', 'max:102400']
            : ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];

        return [
            'type' => [$mediaItem instanceof MediaItem ? 'prohibited' : 'required', Rule::enum(MediaType::class)],
            'title' => ['required', 'string', 'max:150'],
            'subtitle' => ['nullable', 'string', 'max:150'],
            'file' => [$mediaItem instanceof MediaItem ? 'nullable' : 'required', 'file', ...$fileRules],
        ];
    }
}
