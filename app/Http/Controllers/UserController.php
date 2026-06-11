<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Responses\UserResponse;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @group Users
 */
class UserController
{
    public function __construct(
        protected UserService $service,
        protected UserResponse $response
    ) {}

    /**
     * Remove the specified resource from users.
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            return $this->service->destroy($user);
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Display a listing of users. Shouldn't show the user making the request.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->service->index();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): JsonResponse
    {
        try {
            return $this->service->show($user);
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in user.
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            return $this->service->store($request);
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in user.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            return $this->service->update($request, $user);
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }
}
