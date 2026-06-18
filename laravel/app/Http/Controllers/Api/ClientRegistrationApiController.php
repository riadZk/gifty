<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientStatusRequest;
use App\Http\Requests\Api\RegisterClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientRegistrationApiController extends Controller
{
    /**
     * POST /api/clients/register
     *
     * Register a new client directly. The client is created with status=inactive
     * and must be activated by an administrator before being able to log in.
     */
    public function register(RegisterClientRequest $request): JsonResponse
    {
        $client = Client::create([
            ...$request->validated(),
            'status' => Client::STATUS_INACTIVE,
        ]);

        return response()->json([
            'message' => 'Your account has been created and is awaiting activation by an administrator.',
            'data'    => [
                'id'     => $client->id,
                'status' => $client->status,
            ],
        ], 201);
    }

    /**
     * GET /api/clients/status?email=...
     *
     * Check whether a registered client has been activated yet.
     */
    public function status(ClientStatusRequest $request): JsonResponse
    {
        $client = Client::where('email', $request->validated('email'))->first();

        if (! $client) {
            return response()->json(['message' => 'No client found for this email.'], 404);
        }

        return response()->json([
            'status'        => $client->status,
            'registered_at' => $client->created_at,
        ]);
    }
}
