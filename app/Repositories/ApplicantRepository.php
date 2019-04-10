<?php

namespace App\Repositories;

use App\Models\Applicant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Facades\App\Repositories\ApplicantListRepository;
use Illuminate\Support\Facades\DB;

class ApplicantRepository implements RepositoryInterface
{
    private $applicantModel;

    public function __construct(Applicant $applicantModel)
    {
        $this->applicantModel = $applicantModel;
    }

    public function all()
    {
        try {
            return $this->applicantModel::all();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function find($id)
    {
        try {
            $applicant = $this->applicantModel::find($id);

            return $applicant;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function findByUserId($userId)
    {
        try {
            $applicant = $this->applicantModel::where('user_id', $userId)->first();

            return $applicant;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function create(array $attributes, $listId)
    {
        try {
            DB::beginTransaction();
            $applicant = $this->applicantModel::create($attributes);
            DB::table('applicant_applicant_list')
                ->insert([
                    'applicant_list_id' => $listId,
                    'applicant_id' => $applicant->id,
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', now()),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', now())
                ]);
            DB::commit();

            return $applicant;

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return $e->getMessage();
        }

    }

    public function update(array $attributes, $id)
    {
        try {
            DB::beginTransaction();
            $applicant = $this->applicantModel::with('contactDetails')->find($id);

            $applicant->first_name = $attributes['first_name'];
            $applicant->last_name = $attributes['last_name'];
            $applicant->dob = $attributes['dob'];
            $applicant->contactDetails->applicant_id = $applicant['id'];
            $applicant->gender = $attributes['gender'];

            $applicant->save();

            $applicant->contactDetails->update([
                'phone' => $attributes['phone'],
                'address_1' => $attributes['address_1'],
                'address_2' => $attributes['address_2'],
                'address_3' => $attributes['address_3'],
                'city' => $attributes['city'],
                'post_code' => $attributes['post_code'],
                'country' => $attributes['country']
            ]);

            DB::commit();

            return $applicant;

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function softDelete(int $id)
    {
        try {
            return $this->applicantModel::destroy($id);
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function hardDelete()
    {

    }

    public function getApplicantList($listId)
    {
        return ApplicantListRepository::find($listId);
    }

    public function getListCount($listId)
    {
        return $this->getApplicantList($listId)->count();
    }
}