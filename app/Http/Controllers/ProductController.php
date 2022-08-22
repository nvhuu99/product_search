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
     * Products page
     */
    public function list(Request $request)
    {
        $params = $request->only($this->productRepo->searchables());
        $products = $this->productRepo->search(array_filter($params));

        return view('product_list', compact('products'));
    }
}
