<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientChangePasswordRequest;
use App\Http\Requests\Api\ClientLoginRequest;
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

        $client = Client::where('phone', $validated['phone'])->first();

        if (! $client || ! Hash::check($validated['password'], $client->password)) {
            return response()->json([
                'message' => 'Les identifiants sont incorrects.',
            ], 401);
        }

        if ($client->isBlocked()) {
            return response()->json([
                'message' => 'Votre compte est bloqué. Veuillez contacter le support.',
            ], 403);
        }

        // Revoke previous tokens for this device and issue a fresh one
        $client->tokens()->where('name', $validated['device_name'])->delete();

        $token = $client->createToken($validated['device_name'])->plainTextToken;

        return response()->json([
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
        ]);
    }

    /**
     * POST /api/client/logout
     * Revoke the current token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user('client')->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie.']);
    }

    /**
     * GET /api/client/me
     * Return the authenticated client's profile.
     */
    public function me(Request $request): JsonResponse
    {
        $client = $request->user('client');

        return response()->json([
            'id'                => $client->id,
            'company_name'      => $client->company_name,
            'contact_name'      => $client->contact_name,
            'email'             => $client->email,
            'phone'             => $client->phone,
            'pcc_customer_code' => $client->pcc_customer_code,
            'status'            => $client->status,
            'points_balance'    => $client->points_balance,
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
            return response()->json(['message' => 'Le mot de passe actuel est incorrect.'], 422);
        }

        $client->update(['password' => bcrypt($validated['new_password'])]);

        return response()->json(['message' => 'Mot de passe mis à jour avec succès.']);
    }
}
