<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    private ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo)
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
