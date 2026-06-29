<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    /**
     * Send a WhatsApp message to many phone numbers in batches.
     *
     * @param  array<int,string>  $phones
     * @return array{ok: bool, reason?: string, target?: string, detail?: array<string,bool>}
     */
    public static function sendMessage(array $phones, string $message)
    {
        // return 'asasa';
        $phones = array_values(array_filter(array_unique(
            array_map(fn ($p) => preg_replace('/\D+/', '', (string) $p), $phones)
        )));
        // return $phones + $message;
        if (empty($phones)) {
            return ['ok' => false, 'reason' => 'no_recipient'];
        }

        $chunks = array_chunk($phones, 15);
        $results = [];
        
        foreach ($chunks as $batch) {
            try {
                $res = Http::timeout(8)->post('https://message.parrotscan.com/send', [
                    'numbers' => $batch,
                    'message' => $message,
                ]);

                $ok = $res->successful();

                foreach ($batch as $number) {
                    $results[$number] = $ok;
                }
            } catch (\Throwable $e) {
               
                foreach ($batch as $number) {
                    $results[$number] = false;
                }
            }
        }

        return ['ok' => ! empty(array_filter($results)), 'target' => implode(',', $phones), 'detail' => $results];
    }
}
