<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryRepository
{
    /**
     * Get the search params's name that the search() accepted.
     */
    public function searchables()
    {
        return [
            'name',
            'limit',
        ];
    }

    /**
     * Search for categories
     * 
     * @param array $params search params
     * @param array|null $fields fields to select
     * @return Illuminate\Support\Collection
     */
    public function search(array $params = [], $fields = null)
    {
        $query = Category::query();

        if ($fields) {
            $query->select($fields);
        }

        if (!empty($params['name'])) {
            $query->where('name', 'LIKE', "%{$params['name']}%");
        }

        // Todo make the Config util
        $query->limit($params['limit'] ?? 20);

        return $query->get();
    }
}