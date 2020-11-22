<?php

namespace App\Repositories;

use App\Models\ApplicantApplicantList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class ApplicantApplicantListRepository implements RepositoryInterface
{
    private $applicantList;

    public function __construct(ApplicantApplicantList $applicantApplicantList)
    {
        $this->applicantApplicantList = $applicantApplicantList;
    }

    public function all()
    {
    }

    public function find(int $list): ?Collection
    {
        try {
            return $this->applicantApplicantList::where('applicant_list_id', $list)->get();
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return null;
        }
    }

    public function findBy(int $applicantListId, int $applicantIds): bool
    {
        try {
            return $this->applicantApplicantList::where('applicant_list_id', $applicantListId)
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
            return $this->applicantApplicantList::where('applicant_id', $applicantId)->get();
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
