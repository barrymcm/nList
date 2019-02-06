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

    public function create(array $slot)
    {
        try {
            DB::beginTransaction();
            $slot = $this->slotModel::create($slot);
            DB::table('applicant_lists')->insert($this->createLists($slot));
            BD::commit();

            return $slot;

        } catch (\PDOException $e) {
            DB::rollback();
        }
    }

    private function createLists($event)
    {
        $rows = [];
        $lists = $event['total_lists'];

        for ($i = 0; $i < $lists; $i++) {
            $rows[] = (array) ['list_id' => $lists['id']];
        }

        return $rows;
    }

    public function update(array $slot, $id)
    {
        $slotModel = $this->slotModel::find($id);

        $slotModel->name = $slot['name'];
        $slotModel->slot_capacity = $slot['slot_capacity'];
        $slotModel->total_lists = $slot['total_lists'];
        $slotModel->start_date = $slot['start_date'];
        $slotModel->end_date = $slot['end_date'];

        $slotModel->save();

        return $slotModel;
    }

    public function softDelete(int $id)
    {

    }

    public function hardDelete()
    {

    }
}