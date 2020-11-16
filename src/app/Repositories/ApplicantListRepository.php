<?php

namespace App\Repositories;

use App\Models\Slot;
use App\Models\ApplicantList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplicantListRepository implements RepositoryInterface
{
    private $applicantListModel;

    public function __construct(ApplicantList $applicantListModel)
    {
        $this->applicantListModel = $applicantListModel;
    }

    public function all()
    {
        return $this->applicantListModel::all();
    }

    public function find(int $id)
    {
        try {
            return $this->applicantListModel::find($id);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return null;
        }
    }

    public function findSlotLists(int $id) : ?Collection
    {
        try {
            return $this->applicantListModel::where('slot_id', $id)->get();
        } catch(ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return null;
        }
    }

    public function findCustomersLists(array $listIds)
    {
        try {
            return $this->applicantListModel::whereIn('id', $listIds)->get();
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return null;
        }
    }

    public function create(array $list, int $id = null)
    {
        try {
            return $this->applicantListModel::create($list);
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function update(array $listAttributes, int $id)
    {
        try {
            $list = $this->applicantListModel::find($id);

            $list->slot_id = $listAttributes['slot_id'];
            $list->name = $listAttributes['name'];
            $list->max_applicants = $listAttributes['max_applicants'];

            $list->save();

            return $list;
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function softDelete(int $id): bool
    {
        try {
            DB::beginTransaction();
            $result = $this->applicantListModel::destroy($id);
            DB::commit();

            return $result;
        } catch (\PDOException $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            return false;
        }
    }

    public function hardDelete()
    {
    }

    public function countListsInSlot(int $id) : int
    {
        try {
            return $this->applicantListModel::where('slot_id', $id)->count();
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function getAvailableSlotPlaces(int $slotId)
    {
        try {

            /** @noinspection SqlDialectInspection */
            $results = DB::select(
                'SELECT s.slot_capacity - SUM(al.max_applicants) AS availability 
                        FROM slots s 
                          JOIN applicant_lists al ON (s.id = al.slot_id) 
                        WHERE deleted_at IS NULL 
                          AND s.id = ? 
                        GROUP BY s.id',
                [$slotId]
            );

            foreach ($results as $result) {
                return $result->availability;
            }
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
