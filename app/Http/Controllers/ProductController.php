<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Responses\ProductResponse;
use App\Services\ProductService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

/**
 * @group Products
 */
class ProductController
{
    public function __construct(
        protected ProductService $service,
        protected ProductResponse $response
    ) {}

    /**
     * Remove the specified resource from products.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            Gate::authorize('delete', $product);

            return $this->service->destroy($product);
        } catch (AuthorizationException $e) {
            return $this->response->forbidden();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Display a listing of products.
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
     * Display the specified product.
     */
    public function show(Product $product): JsonResponse
    {
        try {
            Gate::authorize('view', $product);

            return $this->service->show($product);
        } catch (AuthorizationException $e) {
            return $this->response->forbidden();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in product.
     */
    public function store(CreateProductRequest $request): JsonResponse
    {
        try {
            return $this->service->store($request);
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in product.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        try {
            Gate::authorize('update', $product);

            return $this->service->update($request, $product);
        } catch (AuthorizationException $e) {
            return $this->response->forbidden();
        } catch (\Exception $e) {
            return $this->response->unexpectedError($e->getMessage());
        }
    }
}
