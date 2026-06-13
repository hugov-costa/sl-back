<?php

namespace App\Services;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Responses\ProductResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function __construct(
        protected ProductResponse $response
    ) {}

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->response->destroy();
    }

    public function index(): JsonResponse
    {
        $resources = Product::where('user_id', Auth::id())->get();

        return $this->response->index($resources);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->response->show($product);
    }

    public function store(CreateProductRequest $data): JsonResponse
    {
        $data = $data->validated();
        $data['user_id'] = Auth::id();

        Product::create($data);

        return $this->response->store();
    }

    public function update(UpdateProductRequest $data, Product $product): JsonResponse
    {
        $product->update($data->validated());

        return $this->response->update();
    }
}
