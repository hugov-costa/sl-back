<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Responses\AuthResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        protected AuthResponse $response
    ) {}

    public function checkAuth(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user instanceof User) {
            return $this->response->unauthorized();
        }

        return $this->response->userIsAuthenticated($user);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $this->setCredentials($request);
        $credentialsAreOk = Auth::attempt($credentials);

        if (! $credentialsAreOk) {
            return $this->response->unauthorized();
        }

        $user = Auth::user();

        if (! $user instanceof User) {
            return $this->response->userNotFoundAfterAuthentication();
        }

        $token = $this->issueToken($user);

        return $this->response->success($token, $user);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user instanceof User) {
            return $this->response->unauthorized();
        }

        /** @var \Laravel\Sanctum\PersonalAccessToken|null $token */
        $token = $user->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return $this->response->logout();
    }

    private function issueToken(User $user): string
    {
        return $user->createToken(
            'clarapp-token', ['*'],
            now()->addMonths(1)
        )->plainTextToken;
    }

    /**
     * @return array<string, mixed>
     */
    private function setCredentials(LoginRequest $request): array
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }
}
