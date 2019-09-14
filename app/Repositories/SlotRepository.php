<?php

namespace App\Repositories;

use App\Models\Slot;
use Illuminate\Support\Facades\DB;
use Facades\App\Repositories\ApplicantListRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SlotRepository implements RepositoryInterface
{
    private $slotModel;

    public function __construct(Slot $slotModel)
    {
        $this->slotModel = $slotModel;
    }

    public function all()
    {
        return $this->slotModel::all();
    }

    public function find($id)
    {
        try {
            $slot = $this->slotModel::find($id);
            $slot->availability = ApplicantListRepository::getAvailableSlotPlaces($id);

            return $slot;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function create(array $attributes, $id = null)
    {
        try {
            return DB::table('slots')->insert($attributes);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function createSlotWithLists(array $slot)
    {
        try {
            DB::beginTransaction();
            $slot = $this->slotModel::create($slot);
            DB::table('applicant_lists')->insert($this->createLists($slot));
            DB::commit();

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
        try {
            $slotModel = $this->slotModel::find($id);

            $slotModel->name = $slot['name'];
            $slotModel->slot_capacity = $slot['slot_capacity'];
            $slotModel->total_lists = $slot['total_lists'];
            $slotModel->start_date = $slot['start_date'];
            $slotModel->end_date = $slot['end_date'];

            $slotModel->save();

            return $slotModel;
        } catch (\PDOException $e) {
        }
    }

    public function softDelete(int $id)
    {
    }

    public function hardDelete()
    {
    }
}
