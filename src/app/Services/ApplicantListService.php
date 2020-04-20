<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Repositories\SlotRepository;
use App\Repositories\ApplicantRepository;
use App\Repositories\ApplicantListRepository;
use App\Repositories\ApplicantApplicantListRepository;

class ApplicantListService
{
    private $applicantListRepository;
    private $slotRepository;
    private $applicantRepository;
    private $applicantApplicantListRepository;

    private const LIST_STATUS_PENDING = 'pending';
    private const LIST_STATUS_CURRENT = 'current';
    private const LIST_STATUS_EXPIRED = 'expired';

    public function __construct(
        ApplicantListRepository $applicantListRepository,
        ApplicantApplicantListRepository $applicantApplicantListRepository,
        SlotRepository $slotRepository,
        ApplicantRepository $applicantRepository
    ) {
        $this->applicantListRepository = $applicantListRepository;
        $this->applicantApplicantListRepository = $applicantApplicantListRepository;
        $this->slotRepository = $slotRepository;
        $this->applicantRepository = $applicantRepository;
    }

    public function tryCreateApplicantList(array $attributes)
    {
        $maxApplicants = $attributes['max_applicants'];
        $slotId = $attributes['slot_id'];

        $slot = $this->slotRepository->find($slotId);

        if (
            ! $this->isListSizeWithinMaximumSlotCapacity($slot, $maxApplicants) ||
            ! $this->isAvailability($slot, $maxApplicants)
        ) {
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

    /**
     * @param $customer
     * @return Collection
     */
    public function getLists($customer): Collection
    {
        $listDetails = [];

        $applicantIds = $this->applicantRepository->findByUserId($customer->user_id)->pluck('id');

        if($applicantIds->isEmpty()) {
            return collect($listDetails);
        }

        $listIds = $this->applicantApplicantListRepository->findListsBy($applicantIds)->pluck('applicant_list_id');
        $lists = $this->applicantListRepository->findCustomersLists($listIds->all());

        foreach ($lists as $list) {
            $listDetails[] = $this->serialize($list);
        }

        return collect($listDetails);
    }

    private function serialize($list)
    {
        return [
            'listName' => $list->name,
            'slotName' => $list->slot->name,
            'eventName' => $list->slot->event->name,
            'startDate' => $list->slot->start_date->format('Y-m-d H:i:s'),
            'status' => $this->getListStatus($list->slot->start_date->format('Y-m-d')),
        ];
    }

    private function getListStatus($date): string
    {
        if ($date > Carbon::now()) {
            return self::LIST_STATUS_PENDING;
        }

        if ($date == Carbon::now()) {
            return self::LIST_STATUS_CURRENT;
        }

        if ($date < Carbon::now()) {
            return self::LIST_STATUS_EXPIRED;
        }

        return 'N/A';
    }
}
