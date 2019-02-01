<?php


namespace App\Repositories;

use App\Models\Slot;

class SlotRepository implements RepositoryInterface
{
    private $slotModel;

    public function __construct(Slot $slotModel)
    {
        $this->slotModel = $slotModel;
    }

    public function index()
    {

    }

    public function show($id)
    {

    }

    public function store(array $event)
    {

    }

    public function update(array $slot)
    {

    }

    public function softDelete()
    {

    }

    public function hardDelete()
    {

    }
}