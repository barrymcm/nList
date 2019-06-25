<?php

namespace App\Repositories;


interface RepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $attributes, $id);

    public function update(array $attributes, $id);

    public function softDelete(int $id);

    public function hardDelete();
}