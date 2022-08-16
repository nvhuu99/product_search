<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository
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
            'max_price'
        ];
    }

    public function search(array $params = [], $fields = [])
    {
        $query = Product::query()
            ->skip($params['skip'] ?? 0)
            ->limit($params['limit'] ?? 20);
        
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
                ->orderBy('product_sort.product_rank ASC');
        }

        return $query->get();
        // todo
        // query result differ from DB
    }
}