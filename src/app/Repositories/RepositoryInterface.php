<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all();

    public function find(int $id);

    public function create(array $attributes, int $id);

    public function update(array $attributes, int $id);

    public function softDelete(int $id);

    public function hardDelete();
}
