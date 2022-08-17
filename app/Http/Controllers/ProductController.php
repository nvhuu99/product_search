<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * Get list of products
     */
    public function list(Request $request)
    {
        $params = $request->only($this->productRepo->searchables());
        $query = $this->productRepo->search($params);

        $products = $query->map(function($item) {
            return $item->toArray();
        });

        return response()->json($products);
    }
}
