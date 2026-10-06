<?php

namespace App\Http\Controllers;

use App\Http\Requests\R2rBotChatRequest;
use App\Services\R2rBot;
use Illuminate\Http\JsonResponse;

class R2rBotController extends Controller
{
    /**
     * Return r2rBot's reply to the visitor's latest message.
     */
    public function __invoke(R2rBotChatRequest $request, R2rBot $bot): JsonResponse
    {
        return response()->json([
            'reply' => $bot->reply($request->conversation()),
        ]);
    }
}
