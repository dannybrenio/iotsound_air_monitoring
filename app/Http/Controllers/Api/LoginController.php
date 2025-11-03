<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;   // ⬅️ add
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Throwable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $startedAt = microtime(true);
        Log::info('login-user hit', ['ip' => $request->ip()]);
        // Attach per-request context once; it will be included on all subsequent Log:: calls
        Log::withContext([
            'route'      => 'api.login',
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_id' => $request->header('X-Request-ID') ?? uniqid('req_', true),
        ]);

        try {
            // --- validation ---
            $validated = $request->validate([
                'username' => ['nullable', 'string'],
                'email'    => ['nullable', 'email'],
                'password' => ['required', 'string'],
            ]);

            if (empty($validated['username']) && empty($validated['email'])) {
                Log::warning('Login validation failed: no username/email provided');
                throw ValidationException::withMessages([
                    'login' => ['Provide either a username or an email.'],
                ]);
            }

            $loginField = !empty($validated['username']) ? 'username' : 'email';
            $loginValue = $validated[$loginField];

            // --- user lookup ---
            /** @var User|null $user */
            $user = User::where($loginField, $loginValue)->first();

            if (!$user) {
                Log::warning('Login failed: user not found', [
                    'login_field' => $loginField,
                    'login_value' => $loginValue,
                    'status'      => 401,
                ]);

                return response()->json([
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            // --- password check ---
            if (!Hash::check($validated['password'], $user->password)) {
                Log::warning('Login failed: bad password', [
                    'login_field' => $loginField,
                    'login_value' => $loginValue,
                    'user_id'     => $user->id,
                    'status'      => 401,
                ]);

                return response()->json([
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            // --- token issue ---
            $token = $user->createToken('aeroson-mobile')->plainTextToken;

            Log::info('Login success', [
                'login_field' => $loginField,
                'login_value' => $loginValue,
                'user_id'     => $user->id,
                'status'      => 200,
                'elapsed_ms'  => (int) ((microtime(true) - $startedAt) * 1000),
                // do NOT log token; optional: length only
                'token_len'   => strlen($token),
            ]);

            return response()->json([
                'token' => $token,
                'user'  => [
                    'id'       => $user->id,
                    'name'     => $user->name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')),
                    'username' => $user->username,
                    'email'    => $user->email,
                ],
            ], 200);
        } catch (ValidationException $e) {
            Log::notice('Login validation exception', [
                'errors'     => $e->errors(),
                'status'     => 422,
                'elapsed_ms' => (int) ((microtime(true) - $startedAt) * 1000),
            ]);

            throw $e; // let Laravel format the 422 JSON
        } catch (Throwable $e) {
            Log::error('Login unexpected exception', [
                'exception'  => get_class($e),
                'message'    => $e->getMessage(),
                'status'     => 500,
                'elapsed_ms' => (int) ((microtime(true) - $startedAt) * 1000),
            ]);

            return response()->json([
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    // optional logout already shown earlier, you can add similar logs there too
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $tokenId = optional($user?->currentAccessToken())->id;

            $user?->currentAccessToken()?->delete();

            Log::info('Logout success', [
                'user_id'  => $user?->id,
                'token_id' => $tokenId,
                'status'   => 200,
            ]);

            return response()->json(['message' => 'Logged out'], 200);
        } catch (Throwable $e) {
            Log::error('Logout exception', [
                'exception' => get_class($e),
                'message'   => $e->getMessage(),
                'status'    => 500,
            ]);
            return response()->json(['message' => 'Something went wrong.'], 500);
        }
    }
}
