<?php

namespace App\Http\Controllers;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

class FCMv1Controller extends Controller
{
    /**
     * Read these from config/services.php (see below).
     */
    protected static function projectId(): string
    {
        return (string) config('services.firebase.project_id', 'aeroson-monitoring');
    }

    protected static function serviceAccountPath(): string
    {
        // absolute path to your service account JSON
        return (string) config('services.firebase.credentials', storage_path('app/aeroson-monitoring-3264904849d0.json'));
    }

    protected static function endpoint(): string
    {
        return "https://fcm.googleapis.com/v1/projects/" . self::projectId() . "/messages:send";
    }

    /**
     * Mint a Google OAuth access token for the FCM scope using the service account.
     */
    protected static function accessToken(): ?string
    {
        $scopes  = ['https://www.googleapis.com/auth/firebase.messaging'];
        $jsonKey = json_decode(file_get_contents(self::serviceAccountPath()), true);
        $creds   = new ServiceAccountCredentials($scopes, $jsonKey);
        $token   = $creds->fetchAuthToken()['access_token'] ?? null;

        return $token ?: null;
    }

    /**
     * Send a NOTIFICATION + DATA message (appears in system tray).
     * Use topic OR token. If both are passed, token wins.
     */
    public static function send(string $title, string $body, array $data = [], ?string $topic = 'all_devices', ?string $token = null)
    {
        $jwt = self::accessToken();
        if (!$jwt) {
            return ['error' => 'Could not obtain Google OAuth access token'];
        }

        $message = [
            'notification' => [
                'title' => $title,
                'body'  => $body,
            ],
            'data' => array_map('strval', $data), // FCM data values must be strings
        ];

        if ($token) {
            $message['token'] = $token;
        } else {
            $message['topic'] = $topic ?? 'all_devices';
        }

        $payload = ['message' => $message];

        return Http::withToken($jwt)->post(self::endpoint(), $payload)->json();
    }

    /**
     * Send a DATA-ONLY message (NO system tray notification).
     * This is what you want for silent AQI updates.
     * Use topic OR token. If both are passed, token wins.
     */
    public static function sendDataOnly(array $data, ?string $topic = 'all_devices', ?string $token = null)
    {
        $jwt = self::accessToken();
        if (!$jwt) {
            return ['error' => 'Could not obtain Google OAuth access token'];
        }

        $message = [
            'data' => array_map('strval', $data), // ensure strings
        ];

        if ($token) {
            $message['token'] = $token;
        } else {
            $message['topic'] = $topic ?? 'all_devices';
        }

        $payload = ['message' => $message];

        return Http::withToken($jwt)->post(self::endpoint(), $payload)->json();
    }
}
