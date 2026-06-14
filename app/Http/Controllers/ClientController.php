<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Responses\ClientResponse;
use App\Services\ClientService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

/**
 * @group Clients
 */
class ClientController
{
    public function __construct(
        protected ClientService $service,
        protected ClientResponse $response
    ) {}

    /**
     * Remove the specified resource from clients.
     */
    public function destroy(Client $client): JsonResponse
    {
        try {
            Gate::authorize('delete', $client);

            return $this->service->destroy($client);
        } catch (AuthorizationException $e) {
            return $this->response->forbidden();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Display a listing of clients.
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
     * Display the specified client.
     */
    public function show(Client $client): JsonResponse
    {
        try {
            Gate::authorize('view', $client);

            return $this->service->show($client);
        } catch (AuthorizationException $e) {
            return $this->response->forbidden();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in client.
     */
    public function store(CreateClientRequest $request): JsonResponse
    {
        try {
            return $this->service->store($request);
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in client.
     */
    public function update(UpdateClientRequest $request, Client $client): JsonResponse
    {
        try {
            Gate::authorize('update', $client);

            return $this->service->update($request, $client);
        } catch (AuthorizationException $e) {
            return $this->response->forbidden();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }
}
