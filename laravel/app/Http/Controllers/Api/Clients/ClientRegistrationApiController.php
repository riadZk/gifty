<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\ClientStatusRequest;
use App\Http\Requests\Api\RegisterClientRequest;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewClientRegistered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

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
        $data = $request->validated();

        $client = Client::create([
            ...collect($data)->except('picture')->all(),
            'status' => Client::STATUS_INACTIVE,
        ]);

        if ($request->hasFile('picture')) {
            $ext = $request->file('picture')->getClientOriginalExtension();
            $client->addMediaFromRequest('picture')->usingFileName(Str::uuid() . '.' . $ext)->toMediaCollection('picture');
        }

        // Notify all users with the admin role
        $notification = new NewClientRegistered($client);
        User::whereHas('roles', fn($q) => $q->where('name', 'admin'))
            ->each(fn(User $user) => $user->notify($notification));

        return $this->jsonResponse([
            'id'          => $client->id,
            'status'      => $client->status,
        ], 'Your account has been created and is awaiting activation by an administrator.', 201);
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
            return $this->jsonResponse(null, 'No client found for this email.', 404);
        }

        return $this->jsonResponse([
            'status'        => $client->status,
            'registered_at' => $client->created_at,
        ]);
    }
}
