<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    /**
     * Get the search params's name that the search() accepted.
     */
    public function searchables();

    /**
     * Search for categories
     *
     * @param array $params search params
     * @param array|null $fields fields to select
     * @return Illuminate\Support\Collection
     */
    public function search(array $params = [], $fields = null);
}
