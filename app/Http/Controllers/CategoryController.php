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
        $params = $request->only($this->categoryRepo->searchables());
        $query = $this->categoryRepo->search(array_filter($params));

        $categories = $query->each(function($cat) {
            $url = route('product.list', ['category_id' => $cat->id, 'category_name' => $cat->name]);
            echo "$cat->name : <a href=\"$url\"> $url </a>";
            echo "<br>";
        });
    }
}
