<?php

namespace App\Http\Controllers;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

class FCMv1Controller extends Controller
{
    public static function send(string $title, string $body, array $data = [], string $topic = 'all_devices')
    {
        $projectId = 'aeroson-monitoring'; // <-- your Firebase project ID
        $saPath    = storage_path('app/aeroson-monitoring-3264904849d0.json'); // <-- your service account JSON

        // 1) Create creds and mint an access token for the FCM scope
        $scopes  = ['https://www.googleapis.com/auth/firebase.messaging'];
        $jsonKey = json_decode(file_get_contents($saPath), true);
        $creds   = new ServiceAccountCredentials($scopes, $jsonKey);
        $token   = $creds->fetchAuthToken()['access_token'] ?? null;

        if (!$token) {
            return ['error' => 'Could not obtain Google OAuth access token'];
        }

        // 2) Build FCM v1 payload
        $payload = [
            'message' => [
                'topic' => "all_devices", // or use 'token' / 'tokens'
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'data' => $data,
            ],
        ];

        // 3) Call FCM v1 endpoint
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        return Http::withToken($token)
            ->post($url, $payload)
            ->json();
    }
}
