<?php

namespace App\Repositories;

use App\Models\Organiser;

class OrganiserRepository implements RepositoryInterface
{
    private $organiserModel;

    public function __construct(Organiser $organiserModel)
    {
        $this->organiserModel = $organiserModel;
    }

    public function all()
    {
    }

    public function find(int $id)
    {
    }

    public function create(array $organiser)
    {
    }

    public function update(array $organiser, int $id)
    {
    }

    public function softDelete(int $id)
    {
    }

    public function hardDelete()
    {
    }
}
