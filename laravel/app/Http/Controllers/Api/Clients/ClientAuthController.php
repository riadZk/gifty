<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\ClientChangePasswordRequest;
use App\Http\Requests\Api\ClientLoginRequest;
use App\Http\Requests\Api\ClientUpdateInfoRequest;
use App\Http\Requests\Api\ClientUpdatePictureRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    /**
     * POST /api/client/login
     * Mobile app authenticates with phone + password.
     */
    public function login(ClientLoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $client = Client::where('email', $validated['email'])->first();

        if (! $client || ! Hash::check($validated['password'], $client->password)) {
            return $this->jsonResponse(null, 'Invalid credentials.', 401);
        }

        if ($client->isBlocked()) {
            return $this->jsonResponse(null, 'Your account is blocked. Please contact support.', 403);
        }

        // Revoke all previous tokens and issue a fresh one
        $client->tokens()->delete();

        $token = $client->createToken('api')->plainTextToken;

        return $this->jsonResponse([
            'token'  => $token,
            'client' => [
                'id'                => $client->id,
                'company_name'      => $client->company_name,
                'contact_name'      => $client->contact_name,
                'email'             => $client->email,
                'phone'             => $client->phone,
                'pcc_customer_code' => $client->pcc_customer_code,
                'status'            => $client->status,
                'points_balance'    => $client->points_balance,
            ],
        ], 'Login successful.');
    }

    /**
     * POST /api/client/logout
     * Revoke the current token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user('client')->currentAccessToken()->delete();

        return $this->jsonResponse(null, 'Logged out successfully.');
    }

    /**
     * GET /api/client/me
     * Return the authenticated client's profile.
     */
    public function me(Request $request): JsonResponse
    {
        $client = $request->user('client');

        return $this->jsonResponse([
            'id'                => $client->id,
            'company_name'      => $client->company_name,
            'contact_name'      => $client->contact_name,
            'email'             => $client->email,
            'phone'             => $client->phone,
            'pcc_customer_code' => $client->pcc_customer_code,
            'status'            => $client->status,
            'points_balance'    => (float) $client->points_balance,
            'total_sales'       => (float) $client->total_sales,
            'accepted_at'       => $client->accepted_at?->toIso8601String(),
            'created_at'        => $client->created_at?->toIso8601String(),
            'updated_at'        => $client->updated_at?->toIso8601String(),
        ]);
    }

    /**
     * POST /api/client/change-password
     * Client changes their temporary password from the mobile app.
     */
    public function changePassword(ClientChangePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $client = $request->user('client');

        if (! Hash::check($validated['current_password'], $client->password)) {
            return $this->jsonResponse(null, 'Current password is incorrect.', 422);
        }

        $client->update(['password' => bcrypt($validated['new_password'])]);

        return $this->jsonResponse(null, 'Password updated successfully.');
    }

    /**
     * PUT /api/client/update-info
     * Update the authenticated client's profile information.
     */
    public function updateInfo(ClientUpdateInfoRequest $request): JsonResponse
    {
        $client = $request->user('client');

        $client->update($request->validated());

        return $this->jsonResponse([
            'id'           => $client->id,
            'company_name' => $client->company_name,
            'contact_name' => $client->contact_name,
            'email'        => $client->email,
            'phone'        => $client->phone,
        ], 'Profile updated successfully.');
    }

    /**
     * POST /api/client/update-picture
     * Replace the authenticated client's profile picture.
     */
    public function updatePicture(ClientUpdatePictureRequest $request): JsonResponse
    {
        $client = $request->user('client');

        $ext = $request->file('picture')->getClientOriginalExtension();

        $client->addMediaFromRequest('picture')
            ->usingFileName(\Illuminate\Support\Str::uuid() . '.' . $ext)
            ->toMediaCollection('picture');

        return $this->jsonResponse([
            'picture_url' => $client->fresh()->picture_url,
        ], 'Picture updated successfully.');
    }
}
