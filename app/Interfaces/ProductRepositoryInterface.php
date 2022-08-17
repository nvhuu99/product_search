<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    /**
     * Get the search params's name that the search() accepted.
     */
    public function searchables();

    /**
     * Search for products
     *
     * @param array $params search params
     * @param array|null $fields fields to select
     * @return Illuminate\Support\Collection
     */
    public function search(array $params = [], array $fields = []);
}
