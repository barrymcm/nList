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

    public function all()
    {

    }

    public function find($id)
    {
        return $this->slotModel::find($id);
    }

    public function create(array $event)
    {

    }

    public function update(array $slot)
    {
        $slotModel = $this->slotModel::find($slot['slot_id']);

        $slotModel->name = $slot['name'];
        $slotModel->slot_capacity = $slot['slot_capacity'];
        $slotModel->total_lists = $slot['total_lists'];
        $slotModel->start_date = $slot['start_date'];
        $slotModel->end_date = $slot['end_date'];

        $slotModel->save();

        return $slotModel;
    }

    public function softDelete($id)
    {

    }

    public function hardDelete()
    {

    }
}