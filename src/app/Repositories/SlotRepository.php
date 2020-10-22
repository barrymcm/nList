<?php

namespace App\Repositories;

use App\Models\Slot;
use Illuminate\Support\Facades\Log;
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

    public function find(int $id): Slot
    {
        try {
            $slot = $this->slotModel::find($id);
            $slot->availability = ApplicantListRepository::getAvailableSlotPlaces($id);

            return $slot;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function create(array $attributes, int $id = null)
    {
        try {

            DB::table('events')->where('id', $attributes['event_id'])
                ->increment('total_slots');

            return DB::table('slots')->insert($attributes);
        } catch (\PDOException $e) {
            Log::error($e->getMessage());
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
            Log::error($e->getMessage());
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

    public function update(array $slot, int $id)
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
        try {           
            $lists = ApplicantListRepository::countListsInSlot($id);

            if ($lists > 0) {
                return false;
            }
       
            DB::beginTransaction();
            $result = $this->slotModel->destroy($id);
            DB::commit();

            return $result;
        } catch (\PDOException $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            
            return;
        }
    }

    public function hardDelete()
    {
    }
}
