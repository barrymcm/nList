<?php

namespace App\Services;

use App\Models\ApplicantApplicantList;
use App\Repositories\ApplicantRepository;
use App\Repositories\ApplicantApplicantListRepository;
use App\Notifications\CanceledListNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Applicant;
use App\Models\Customer;
use Illuminate\Support\Collection;

class CancellationService
{
	private ApplicantApplicantListRepository $applicantApplicantListRepository;
	private ApplicantRepository $applicantRepository;
	private Customer $customer;

	public function __construct(
		ApplicantApplicantListRepository $applicantApplicantListRepository,
		ApplicantRepository $applicantRepository,
		Customer $customer
	) 
	{
		$this->applicantApplicantListRepository = $applicantApplicantListRepository;
		$this->applicantRepository = $applicantRepository;
		$this->customer = $customer;
	}

	public function notifyApplicants(int $list): bool
	{
		$applicants = $this->getApplicantsFromList($list);
		
		if ( ! $this->cancelApplicants($applicants)) {
			return false;
		}

		$users = [];

		$applicants->each( function ($applicant) use (&$users) {
			$users[] = $applicant->customer->user;
		});

		Notification::send(collect($users), new CanceledListNotification());	

		return true;
	}

	private function cancelApplicants(Collection $applicants) : bool
	{
		$isDeleted = [];

		$applicants->each( function ($applicant) use (&$isDeleted){

			if ($this->applicantRepository->softDelete($applicant->id)) {
				$isDeleted['applicant_' . $applicant->id][] = true;	
			} else {
				$isDeleted['applicant_' . $applicant->id][] = false;
			}
		});

		if (in_array(false, $isDeleted)) {
			return false;
		}

		return true;
	}

	private function getApplicantsFromList(int $list): Collection
	{
		$applicantList = $this->applicantApplicantListRepository->find($list);
		$ids = $applicantList->pluck('applicant_id');
		$applicants = [];

		foreach ($ids as $id) {

			$applicant = $this->applicantRepository->find($id);

			if ($applicant) {
				$applicants[] = $applicant;
			}
		}

		return collect($applicants);
	}
}