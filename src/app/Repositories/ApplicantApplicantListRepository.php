<?php

namespace App\Repositories;

use App\Models\ApplicantApplicantList;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplicantApplicantListRepository implements RepositoryInterface
{
    private $applicantList;

    public function __construct(ApplicantApplicantList $applicantList)
    {
        $this->applicantList = $applicantList;
    }

    public function all()
    {
    }

    public function find(int $ids)
    {
    }

    public function findBy(int $applicantListId, int $applicantIds): bool
    {
        try {
            return ApplicantApplicantList::where('applicant_list_id', $applicantListId)
                ->whereIn('applicant_id', $applicantIds)->value('applicant_id');
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * @param $applicantListId
     * @param $applicantIds
     * @return bool
     */
    public function findListsBy(int $applicantId)
    {
        try {
            return ApplicantApplicantList::where('applicant_id', $applicantId)->get();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * @param array $attributes
     * @param $id
     */
    public function create(array $attributes, int $id)
    {
        // TODO: Implement create() method.
    }

    public function update(array $attributes, int $id)
    {
        // TODO: Implement update() method.
    }

    public function softDelete(int $id)
    {
        // TODO: Implement softDelete() method.
    }

    public function hardDelete()
    {
        // TODO: Implement hardDelete() method.
    }
}
