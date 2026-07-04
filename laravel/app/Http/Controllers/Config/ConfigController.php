<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\BonusLevel;
use App\Models\LoyaltySetting;
use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
class ConfigController extends Controller
{
    public function profile(): View
    {
        return view('content.config.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updateProfilePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();
        $user->addMediaFromRequest('photo')
            ->toMediaCollection('profile-photo');

        return response()->json([
            'message' => 'Photo mise à jour.',
            'url'     => $user->fresh()->profile_photo_url,
        ]);
    }

    public function removeProfilePhoto(): JsonResponse
    {
        Auth::user()->clearMediaCollection('profile-photo');

        return response()->json(['message' => 'Photo supprimée.']);
    }

    public function pointsRules(): View
    {
        return view('content.config.points-rules', [
            'settings' => LoyaltySetting::instance(),
        ]);
    }

    public function bonusLevels(): View
    {
        return view('content.config.bonus-levels', [
            'levels' => BonusLevel::ordered()->get(),
        ]);
    }

    // ── Canaux ───────────────────────────────────────────────────────────────

    public function canaux(): View
    {
        return view('content.config.canaux', [
            'smtp' => [
                'host'         => config('mail.mailers.smtp.host', ''),
                'port'         => config('mail.mailers.smtp.port', 587),
                'encryption'   => config('mail.mailers.smtp.encryption', 'tls'),
                'username'     => config('mail.mailers.smtp.username', ''),
                'from_address' => config('mail.from.address', ''),
                'from_name'    => config('mail.from.name', ''),
            ],
            'whatsapp' => [
                'api_url'    => config('services.whatsapp.api_url', 'https://message.parrotscan.com/send'),
                'api_key'    => config('services.whatsapp.api_key', ''),
                'sender'     => config('services.whatsapp.sender', ''),
                'batch_size' => config('services.whatsapp.batch_size', 15),
            ],
        ]);
    }

    public function saveSmtp(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mail_host'         => 'required|string|max:255',
            'mail_port'         => 'required|integer|min:1|max:65535',
            'mail_encryption'   => 'nullable|in:tls,ssl,',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string|max:255',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name'    => 'nullable|string|max:255',
        ]);

        $env = base_path('.env');
        $lines = file($env, FILE_IGNORE_NEW_LINES);

        $map = [
            'MAIL_HOST'         => $data['mail_host'],
            'MAIL_PORT'         => $data['mail_port'],
            'MAIL_ENCRYPTION'   => $data['mail_encryption'] ?? '',
            'MAIL_USERNAME'     => $data['mail_username'] ?? '',
            'MAIL_FROM_ADDRESS' => $data['mail_from_address'],
            'MAIL_FROM_NAME'    => '"' . ($data['mail_from_name'] ?? '') . '"',
        ];

        if (!empty($data['mail_password'])) {
            $map['MAIL_PASSWORD'] = $data['mail_password'];
        }

        $updated = [];
        foreach ($lines as $line) {
            $replaced = false;
            foreach ($map as $key => $value) {
                if (str_starts_with($line, $key . '=')) {
                    $updated[] = $key . '=' . $value;
                    $replaced = true;
                    unset($map[$key]);
                    break;
                }
            }
            if (!$replaced) {
                $updated[] = $line;
            }
        }

        // Append any keys not yet present in .env
        foreach ($map as $key => $value) {
            $updated[] = $key . '=' . $value;
        }

        file_put_contents($env, implode("\n", $updated) . "\n");

        return back()->with('success', 'Paramètres SMTP enregistrés.');
    }

    public function testSmtp(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        try {
            Mail::raw('Test SMTP depuis PCC Fidélité — connexion OK.', function ($m) use ($request) {
                $m->to($request->email)->subject('Test SMTP — PCC Fidélité');
            });

            return response()->json(['ok' => true, 'message' => 'Email envoyé avec succès !']);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function saveWhatsapp(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'whatsapp_api_url'    => 'required|url|max:500',
            'whatsapp_api_key'    => 'nullable|string|max:500',
            'whatsapp_sender'     => 'nullable|string|max:30',
            'whatsapp_batch_size' => 'nullable|integer|min:1|max:100',
        ]);

        $env = base_path('.env');
        $lines = file($env, FILE_IGNORE_NEW_LINES);

        $map = [
            'WHATSAPP_API_URL'    => $data['whatsapp_api_url'],
            'WHATSAPP_SENDER'     => $data['whatsapp_sender'] ?? '',
            'WHATSAPP_BATCH_SIZE' => $data['whatsapp_batch_size'] ?? 15,
        ];

        if (!empty($data['whatsapp_api_key'])) {
            $map['WHATSAPP_API_KEY'] = $data['whatsapp_api_key'];
        }

        $updated = [];
        foreach ($lines as $line) {
            $replaced = false;
            foreach ($map as $key => $value) {
                if (str_starts_with($line, $key . '=')) {
                    $updated[] = $key . '=' . $value;
                    $replaced = true;
                    unset($map[$key]);
                    break;
                }
            }
            if (!$replaced) {
                $updated[] = $line;
            }
        }

        foreach ($map as $key => $value) {
            $updated[] = $key . '=' . $value;
        }

        file_put_contents($env, implode("\n", $updated) . "\n");

        return back()->with('success', 'Paramètres WhatsApp enregistrés.');
    }

    public function testWhatsapp(Request $request): JsonResponse
    {
        $request->validate(['phone' => 'required|string|max:20']);

        $result = WhatsAppService::sendMessage(
            [$request->phone],
            'Test WhatsApp depuis PCC Fidélité — connexion OK.'
        );

        if ($result['ok']) {
            return response()->json(['ok' => true, 'message' => 'Message envoyé !']);
        }

        return response()->json(['ok' => false, 'message' => 'Échec de l\'envoi'], 200);
    }

    public function whatsappQr(): JsonResponse
    {

        try {
            $response = Http::timeout(5)->get('https://message.parrotscan.com/qr/json');
            return response()->json($response->json());
        } catch (\Throwable $e) {
            return response()->json(['status' => 'offline', 'qr' => null, 'message' => $e->getMessage()], 200);
        }
    }

    public function whatsappDisconnect(): JsonResponse
    {

        try {
            $response = Http::timeout(5)->post('https://message.parrotscan.com/disconnect');
            return response()->json($response->json());
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 200);
        }
    }
}
