<?php

namespace App\Exceptions;

use App\Support\SiteContent;
use Exception;
use Illuminate\Http\JsonResponse;

class R2rBotUnavailableException extends Exception
{
    /**
     * Render a visitor-friendly response; the underlying cause is still reported to the logs.
     */
    public function render(): JsonResponse
    {
        $contact = app(SiteContent::class)->contact();

        return response()->json([
            'message' => 'r2rBot is taking a break right now. Please email '.$contact['email'].' or call '.$contact['phone'].'.',
        ], 503);
    }
}
