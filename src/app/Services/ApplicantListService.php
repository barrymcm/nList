<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Customer;
use App\Models\Slot;
use App\Models\ApplicantList;
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
    private const LIST_STATUS_CANCELED = 'canceled';

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

    private function isAvailability(\App\Models\Slot $slot, int $totalAllocatedPlaces) : bool
    {
        $placesAvailable = ($slot->slot_capacity - $totalAllocatedPlaces);

        if ($placesAvailable > 0 || $slot->slot_capacity == $totalAllocatedPlaces) {
            return true;
        }

        return false;
    }

    public function getLists(Customer $customer): Collection
    {
        $listDetails = [];

        $applicants = $this->applicantRepository->findByCustomerId($customer->id);
        $listIds = $applicants->pluck('list_id')->unique()->values()->toArray();
        $lists = $this->applicantListRepository->findCustomersLists($listIds);

        foreach ($lists as $list) {
            $listDetails[] = $this->serialize($list);
        }

        return collect($listDetails);
    }

    private function serialize($list)
    {
        return [
            'eventName' => $list->slot->event->name,
            'slotName' => $list->slot->name,
            'listName' => $list->name,
            'startDate' => $list->slot->start_date->format('Y-m-d'),
            'endDate' => $list->slot->end_date->format('Y-m-d'),
            'status' => $this->getListStatus($list),
        ];
    }

    private function getListStatus(ApplicantList $list): string
    {
        $date = $list->slot->start_date->format('Y-m-d');

        if ($list->deleted_at != null) {
            return self::LIST_STATUS_CANCELED;
        }

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

    public function hasApplicants(int $listId) : bool
    {
        $list = $this->applicantListRepository->find($listId);   

        if ($list->applicants->count() > 0) {
            return true;
        }

        return false;
    }
}
