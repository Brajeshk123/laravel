<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{   
    public function search(?string $search, int $perPage = 10);
    
    public function getTrashed();

    public function restore(int $id);

    public function forceDelete(int $id);
}