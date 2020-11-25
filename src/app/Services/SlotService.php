<?php

namespace App\Services;

use App\Repositories\SlotRepository;
use App\Repositories\ApplicantListRepository;
use Illuminate\Database\Eloquent\Collection;

class SlotService
{
	private SlotRepository $SlotRepository;
	private ApplicantListRepository $applicantListRepository;

	public function __construct(
		SlotRepository $slotRepository,
		ApplicantListRepository $applicantListRepository
	) 
	{
		$this->slotRepository = $slotRepository;
		$this->applicantListRepository = $applicantListRepository;
	}

	public function deleteSlot(int $id): bool
	{
		if ($this->canDeleteSlot($id)) {
			$isDeleted = $this->slotRepository->softDelete($id);
			
			if ($isDeleted) {
				return true;	
			}
		}

		return false;
	}

	public function hasApplicants(Collection $lists) : bool
	{
		foreach ($lists as $list) {
			if ($list->applicants->count() > 0) {

				return true;
			}
		}

		return false;	
	}

	public function canDeleteSlot(int $id) : bool 
	{
		$listCount = $this->applicantListRepository->countListsInSlot($id);

        if ($listCount > 0) {
			$lists = $this->applicantListRepository->findSlotLists($id);

			if ($this->hasApplicants($lists)) {

				return false;
			}
		}

		return true;
	}

	public function addTimes(array $attributes): array
	{
		$seconds = ':00';

		$attributes['start_date'] = $attributes['start_date'] . ' ' . 
			$attributes['start_time'] . $seconds;
		$attributes['end_date'] =  $attributes['end_date'] . ' ' . 
			$attributes['end_time'] . $seconds;

		unset($attributes['start_time'], $attributes['end_time']);

		return $attributes;
	}
}