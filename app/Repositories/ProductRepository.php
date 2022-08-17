<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;

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
        $query = Product::query()
            ->skip($params['skip'] ?? 0)
            ->limit($params['limit'] ?? 20);
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

        if (isset($params['sort'])) {
            // todo:
            $sortKey = 'popular_id';
            $query->leftJoin('product_sort', 'product.id', '=', "product_sort.$sortKey")
                ->orderBy('product_sort.product_rank');
        }

        if (isset($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        return $query->get();
    }
}
