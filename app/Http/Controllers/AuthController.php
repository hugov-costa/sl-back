<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Responses\AuthResponse;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController
{
    public function __construct(
        protected AuthResponse $response,
        protected AuthService $service
    ) {}

    /**
     * Check if the user is authenticated.
     */
    public function checkAuth(Request $request): JsonResponse
    {
        try {
            return $this->service->checkAuth($request);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            return $this->response->unauthorized();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Log in the specified user.
     *
     * @unauthenticated
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            return $this->service->login($request);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            return $this->response->unauthorized();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Log out the specified user.
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            return $this->service->logout($request);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            return $this->response->unauthorized();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }
}
