<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class R2rBotUnavailableException extends Exception
{
    /**
     * Render a visitor-friendly response; the underlying cause is still reported to the logs.
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'r2rBot is taking a break right now. Please email '.config('rural2rural.contact.email').' or call '.config('rural2rural.contact.phone').'.',
        ], 503);
    }
}
