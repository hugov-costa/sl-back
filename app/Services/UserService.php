<?php

namespace App\Services;

use App\Helpers\ArrayHelper;
use App\Helpers\EmailHelper;
use App\Helpers\PasswordHelper;
use App\Helpers\UserCaseHelper;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Responses\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected UserCaseHelper $userCaseHelper;

    public function __construct(
        protected UserResponse $response
    ) {
        $this->userCaseHelper = new UserCaseHelper;
    }

    public function destroy(User $user): JsonResponse
    {
        $currentId = Auth::id();

        if ($currentId && $currentId === $user->id) {
            return $this->response->forbiddenExclusion();
        }

        $user->delete();

        return $this->response->destroy();
    }

    public function index(): JsonResponse
    {
        $currentId = Auth::id();
        $resources = User::where('id', '!=', $currentId)
            ->orderBy('name', 'asc')
            ->get();

        return $this->response->index($resources);
    }

    public function show(User $user): JsonResponse
    {
        return $this->response->show($user);
    }

    public function store(CreateUserRequest $data): JsonResponse
    {
        $validatedData = $data->validated();
        $validatedData = $this->userCaseHelper->formatData($validatedData);

        User::create($validatedData);

        return $this->response->store();
    }

    public function update(UpdateUserRequest $data, User $user): JsonResponse
    {
        $data = $this->prepareForUpdate($data->validated());

        $user->update($data);

        return $this->response->update();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function prepareForUpdate(array $data): array
    {
        $data = EmailHelper::applyUpdatedEmail($data);
        $data = PasswordHelper::applyUpdatedPassword($data);
        $data = $this->userCaseHelper->formatData(ArrayHelper::removeEmptyStrings($data));

        return $data;
    }
}
