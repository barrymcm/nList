<?php

namespace App\Repositories;


interface RepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $var);

    public function update(array $var);

    public function softDelete($id);

    public function hardDelete();
}