<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Repositories\SlotRepository;
use App\Services\ApplicantListService;
use App\Repositories\ApplicantListRepository;

/**
 * Class ApplicantListServiceTest
 * @coversDefaultClass \App\Services\ApplicantListService
 * @package Tests\Unit\Services
 */
class ApplicantListServiceTest extends TestCase
{
    private $mockedApplicantListRepository;
    private $applicantListService;
    private $mockedSlotRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockedApplicantListRepository = $this->buildMockApplicantListRepository();
        $this->mockedSlotRepository = $this->buildMockSlotRepository();

        $this->applicantListService = new ApplicantListService(
            $this->mockedApplicantListRepository,
            $this->mockedSlotRepository
        );
    }

    /**
     * @covers ::tryCreateApplicantList
     * @dataProvider provideDataForTestCreateApplicantList
     */
    public function testTryCreateApplicantList($attributes, $slot, $listCount)
    {
        $this->mockedSlotRepository->expects($this->once())
            ->method('find')
            ->with($attributes['max_applicants'])
            ->willReturn($slot);

        $this->mockedApplicantListRepository->expects($this->once())
            ->method('countListsInSlot')
            ->willReturn($listCount);
    }

    public function provideDataForTestCreateApplicantList()
    {
        return [
            'creates_applicant_list' => [
                'attributes' => [
                    'max_applicants' => 100,
                    'slot_id' => 1,
                ],
                'slot' => $this->createSlotObject(),
                'listCount' => 2,
            ],
        ];
    }

    private function buildMockApplicantListRepository()
    {
        return $this->getMockBuilder(ApplicantListRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['all', 'find', 'create', 'update', 'softDelete', 'hardDelete', 'countListsInSlot'])
            ->getMock();
    }

    public function buildMockSlotRepository()
    {
        return $this->getMockBuilder(SlotRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();
    }

    private function createSlotObject()
    {
        $slot = new \stdClass();
        $slot->id = 1;
        $slot->slot_capacity = 100;
        $slot->total_lists = 1;

        return $slot;
    }
}
