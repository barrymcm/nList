<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Facades\App\Repositories\ApplicantListRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function find(int $applicantId)
    {
        try {
            $applicant = $this->applicantModel::findOrFail($applicantId);

            return $applicant;
        } catch (ModelNotFoundException $e) {
            logger($e->getMessage());

            return false;
        }
    }

    /**
     * @todo  find usages and consider renaming user id is not matching customer * id param in the where clause
     */
    public function findByUserId(int $userId): ?Collection
    {
        try {
            return $this->applicantModel::where('user_id', $userId)->get();
        } catch (ModelNotFoundException $e) {
            logger($e->getMessage());

            return null;
        }
    }

    /**
     * @todo  review this to see if it can be made smart findBy(user_id/ customer_id)
     */
    public function findByCustomerId(int $customerId): ?Collection
    {
        try {
            return $this->applicantModel::where('customer_id', $customerId)
                ->withTrashed()->get();
        } catch (ModelNotFoundException $e) {
            logger($e->getMessage());

            return null;
        }
    }

    public function create(array $attributes, int $list)
    {
        try {
            DB::beginTransaction();
            $applicant = $this->applicantModel::create($attributes);
            DB::table('applicant_applicant_list')
                ->insert([
                    'applicant_list_id' => $list,
                    'applicant_id' => $applicant->id,
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', now()),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', now()),
                ]); 
            DB::commit();

            return $applicant;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            logger($e->getMessage());
            
            return null;
        }
    }

    public function update(array $attributes, int $id)
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
                'country' => $attributes['country'],
            ]);

            DB::commit();

            return $applicant;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            logger($e->getMessage());
            return null;
        }
    }

    public function softDelete(int $id)
    {
        try {
            return $this->applicantModel::destroy($id);
        } catch (ModelNotFoundException $e) {
            logger($e->getMessage());
            
            return false;
        }
    }

    public function hardDelete()
    {
    }

    public function getApplicantList(int $listId)
    {
        return ApplicantListRepository::find($listId);
    }

    public function getListCount($listId)
    {
        return $this->getApplicantList($listId)->count();
    }
}
