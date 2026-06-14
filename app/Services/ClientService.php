<?php

namespace App\Services;

use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Responses\ClientResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ClientService
{
    public function __construct(
        protected ClientResponse $response
    ) {}

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return $this->response->destroy();
    }

    public function index(): JsonResponse
    {
        $resources = Client::where('user_id', Auth::id())->get();

        return $this->response->index($resources);
    }

    public function show(Client $client): JsonResponse
    {
        return $this->response->show($client);
    }

    public function store(CreateClientRequest $data): JsonResponse
    {
        $data = $data->validated();
        $data['user_id'] = Auth::id();

        Client::create($data);

        return $this->response->store();
    }

    public function update(UpdateClientRequest $data, Client $client): JsonResponse
    {
        $client->update($data->validated());

        return $this->response->update();
    }
}
