<?php

namespace App\Repositories;


interface RepositoryInterface
{
    public function index();

    public function show($id);

    public function store(array $applicant);

    public function edit($id);

    public function update();

    public function softDelete();

    public function hardDelete();
}