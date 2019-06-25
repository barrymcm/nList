<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    private $eventRepository;
    private const AVAILABILITY_STATUS = 'empty';

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function find($id)
    {
        $event = $this->eventRepository->find($id);

        return $this->getSlotAvailability($event);
    }

    private function getSlotAvailability($event)
    {
        foreach ($event->slots as $slot) {

            $availability = (int) $slot->availability;
            $lists = (int) $slot->applicantLists->count();

            if (!$availability && $lists > 0) {
                $slot->availability = self::AVAILABILITY_STATUS;
            }

            if (!$availability && !$lists) {
                $slot->availability = $slot->slot_capacity;
            }
        }

        return $event;
    }
}