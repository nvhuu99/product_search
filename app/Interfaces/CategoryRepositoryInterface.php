<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    /**
     * Get the search params's name that the search() accepted.
     */
    public function searchables();

    public function search(array $params = []);
}