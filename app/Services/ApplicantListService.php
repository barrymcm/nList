<?php


namespace App\Services;

use App\Repositories\ApplicantListRepository;
use App\Repositories\SlotRepository;

class ApplicantListService
{
    private $applicantListRepository;
    private $slotRepository;

    public function __construct(
        ApplicantListRepository $applicantListRepository,
        SlotRepository $slotRepository
    )
    {
        $this->applicantListRepository = $applicantListRepository;
        $this->slotRepository = $slotRepository;
    }

    public function tryCreateApplicantList(array $attributes)
    {
        $maxApplicants = $attributes['max_applicants'];
        $slotId = $attributes['slot_id'];

        $slot = $this->slotRepository->find($slotId);

        if (
            !$this->isListSizeWithinMaximumSlotCapacity($slot, $maxApplicants) ||
            !$this->isAvailability($slot, $maxApplicants)
        )
        {
            return false;
        }

        return $this->applicantListRepository->create($attributes);

    }

    private function isListSizeWithinMaximumSlotCapacity($slot, $maxApplicants) : bool
    {
        if ($slot->slot_capacity >= $maxApplicants) {
            return true;
        }

        return false;
    }

    private function isAvailability($slot, $totalAllocatedPlaces) : bool
    {
        $placesAvalable = ($slot->slot_capacity - $totalAllocatedPlaces);

        if ($placesAvalable > 0) {
            return true;
        }

        return false;
    }
}