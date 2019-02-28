<?php

namespace App\Repositories;

use App\Models\ ApplicantContactDetails;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApplicantContactDetailsRepository implements RepositoryInterface
{
    private $contactDetailsModel;

        public function __construct(ApplicantContactDetails $contactDetails)
        {
           $this->contactDetailsModel = $contactDetails;
        }

    public function all()
    {

    }

    public function find($id)
    {
        return $this->contactDetailsModel::find($id);
    }

    public function create(array $attributes, $id = null)
    {
        try {
            $contactDetails = $this->contactDetailsModel;

            $contactDetails->applicant_id = $attributes['applicant_id'];
            $contactDetails->email = $attributes['email'];
            $contactDetails->phone = $attributes['phone'];
            $contactDetails->address_1 = $attributes['address_1'];
            $contactDetails->address_2 = $attributes['address_2'];
            $contactDetails->address_3 = $attributes['address_3'];
            $contactDetails->city = $attributes['city'];
            $contactDetails->county = $attributes['county'];
            $contactDetails->post_code = $attributes['post_code'];
            $contactDetails->country = $attributes['country'];

            $contactDetails->save();

            return $contactDetails;

        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function update(array $attributes, $id)
    {
        try {
            $contactDetails = $this->contactDetailsModel::find($id);

            $contactDetails->applicant_id = $attributes['applicant_id'];
            $contactDetails->phone = $attributes['phone'];
            $contactDetails->address_1 = $attributes['address_1'];
            $contactDetails->address_2 = $attributes['address_2'];
            $contactDetails->address_3 = $attributes['address_3'];
            $contactDetails->city = $attributes['city'];
            $contactDetails->post_code = $attributes['post_code'];
            $contactDetails->country = $attributes['country'];
            $this->contactDetailsModel->save();

            return $this->contactDetailsModel;

        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function softDelete(int $id)
    {
        return DB::table('applicant_contact_details')
            ->where('applicant_id', $id)
            ->update(['deleted_at' => Carbon::now()->format('Y-m-d')]);
    }

    public function hardDelete()
    {

    }
}