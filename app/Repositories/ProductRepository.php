<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;
use App\Libs\ConfigUtil;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get the search params's name that the search() accepted.
     */
    public function searchables()
    {
        return [
            'sort',
            'search',
            'skip',
            'limit',
            'min_price',
            'max_price',
            'category_id'
        ];
    }

    /**
     * Search for products
     *
     * @param array $params search params
     * @param array|null $fields fields to select
     * @return Illuminate\Support\Collection
     */
    public function search(array $params = [], array $fields = [])
    {
        $sortOptions = ConfigUtil::get("product_sort");
        $query = Product::query();

        if ($fields) {
            $query->select($fields);
        }

        if (!empty($params['search'])) {
            $query->whereFullText('name', $params['search']);
        }

        if (isset($params['min_price'])) {
            $query->whereRaw(
                "COALESCE(discount_price, unit_price) >= ?",
                [$params['min_price']]
            );
        }

        if (isset($params['max_price'])) {
            $query->whereRaw(
                "COALESCE(discount_price, unit_price) <= ?",
                [$params['max_price']]
            );
        }

        $sort = $params['sort'] ?? null;
        if ($sort && isset($sortOptions[$sort])) {
            $query->leftJoin('product_sort', 'product.id', '=', "product_sort.$sortOptions[$sort]")
                ->orderBy('product_sort.product_rank');
        }

        if (isset($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        return $query
                ->skip($params['skip'] ?? 0)
                ->limit($params['limit'] ?? ConfigUtil::get('page_limit'))
                ->get();
    }
}
