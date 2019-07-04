<?php


namespace App\Repositories;

use App\Models\ApplicantList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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

    public function find($id)
    {
        try {
            return $this->applicantListModel::find($id);

        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function findCustomersLists(array $listIds)
    {
        try {
            return $this->applicantListModel::whereIn('id', $listIds)->get();

        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function create(array $list, $id = null)
    {
        try {
            return $this->applicantListModel::create($list);

        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function update(array $listAttributes, $id)
    {
        try {
            $list = $this->applicantListModel::find($id);

            $list->name = $listAttributes['name'];
            $list->max_applicants = $listAttributes['max_applicants'];
            $list->save();

            return $list;

        } catch (ModelNotFoundException $e) {
            return $e->getMessage();

        }
    }

    public function softDelete(int $id)
    {
        try {
            DB::beginTransaction();
            $result = $this->applicantListModel::destroy($id);
            DB::commit();

            return $result;
        } catch (\PDOException $e) {
            DB::rollBack();
        }
    }

    public function hardDelete()
    {

    }

    /** select * from applicant_lists where slot_id = */
    public function countListsInSlot($slot) : int
    {
        try {
            return $this->applicantListModel::where('slot_id', $slot->id)->count();

        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function getAvailableSlotPlaces($slotId)
    {
        try {

            /** @noinspection SqlDialectInspection */
            $results = DB::select(
                'SELECT s.slot_capacity - SUM(al.max_applicants) AS availability 
                        FROM slots s 
                          JOIN applicant_lists al ON (s.id = al.slot_id) 
                        WHERE deleted_at IS NULL 
                          AND s.id = ? 
                        GROUP BY s.id', [$slotId]
            );

            foreach($results as $result) {
                return $result->availability;
            }

        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}