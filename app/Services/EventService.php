<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    private $eventRepository;
    private const AVAILABILITY_FULL = 'Full';
    private const AVAILABILITY_EMPTY = 'Empty';

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function find($id)
    {
        $event = $this->eventRepository->find($id);

        return $this->getAvailability($event);
    }

    private function getAvailability($event)
    {
        foreach ($event->slots as $slot) {

            $availability = (int) $slot->availability;
            $lists = (int) $slot->applicantLists->count();

            if (!$availability && $lists > 0) {
                $slot->availability = self::AVAILABILITY_FULL;
            }

            if (!$availability && !$lists) {
                $slot->availability = self::AVAILABILITY_EMPTY;
            }
        }

        return $event;
    }
}