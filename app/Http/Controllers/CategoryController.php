<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Libs\ConfigUtil;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo) {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Get list of categories
     */
    public function list(Request $request) {
        dd(ConfigUtil::getMessage('SAD'));

        $params = $request->only($this->categoryRepo->searchables());
        $query = $this->categoryRepo->search($params);

        $categories = $query->map(function($cat) {
            return [
                'name' => $cat->name,
                'url' => route('product.list', ['category_id' => $cat->id])
            ];
        });

        return response()->json($categories);
    }
}
