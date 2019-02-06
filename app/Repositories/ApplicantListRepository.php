<?php


namespace App\Repositories;

use App\Models\ApplicantList;
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
        return $this->applicantListModel::find($id);
    }

    public function create(array $list)
    {
        $event = $list['event_id'];
        $this->applicantListModel::create($list);

        return redirect()->route('events.show', ['event' => $event]);
    }

    public function update(array $list, $id)
    {

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
    public function getListCountBySlotId(int $id) : int
    {
        return $this->applicantListModel::where('slot_id', $id)->count();
    }

}