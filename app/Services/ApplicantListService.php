<?php


namespace App\Services;

use App\Models\ApplicantList;
use Facades\App\Repositories\ApplicantListRepository;
use Facades\App\Repositories\SlotRepository;

class ApplicantListService
{
    private $applicantListRepository;

    public function __construct(ApplicantListRepository $applicantListRepository)
    {
        $this->applicantListRepository = $applicantListRepository;
    }

    public function getListOfApplicants($id)
    {
        return ApplicantList::find($id);
    }

    /** @todo : add backend validation for available list places */
    public function availablePlaces($id)
    {

    }

    public function createApplicantList(array $attributes) : bool
    {
        $slotId = $attributes['slot_id'];

        $slot = SlotRepository::find($slotId);
        $listCount = ApplicantListRepository::getListCountBySlotId($slotId);

        if ($listCount < $slot->total_lists) {
            $list = ApplicantListRepository::create($attributes);
        }

        if (isset($list)) {
            return true;
        }

        return false;
    }
}