<?php

namespace App\Repositories;


interface RepositoryInterface
{
    public function index();

    public function show($id);

    public function store(array $var);

    public function update(array $var);

    public function softDelete();

    public function hardDelete();
}