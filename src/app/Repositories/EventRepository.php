<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Category;
use App\Models\EventOrganiser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Facades\App\Repositories\ApplicantListRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventRepository implements RepositoryInterface
{
    private Event $eventModel;

    public function __construct(Event $event)
    {
        $this->eventModel = $event;
    }

    public function all()
    {
        try {
            $events = $this->eventModel::all();

            $events->each(function ($event) {
                return $event->organiser = EventOrganiser::find($event->event_organiser_id);
            });

            return $events;
        } catch (ModelNotFoundException $e) {
            Log::error(['message' => $e->getMessage()]);

            return null;
        }
    }

    public function find(int $eventId)
    {
        $event = $this->eventModel::find($eventId);

        foreach ($event->slots as $key => $slot) {
            $availability = ApplicantListRepository::getAvailableSlotPlaces($slot->id);
            $slot->setAvailabilityAttribute($availability);
        }

        $organiser = EventOrganiser::find($event->event_organiser_id);
        $event->organiser = $organiser->name;

        $category = Category::find($event->category_id);
        $event->category_name = $category->name;

        return $event;
    }

    public function create(array $attributes, int $id = null): ?Event
    {
        try {
            DB::beginTransaction(); 
            
            $event = $this->eventModel->create($attributes);
            // Bug : this will insert new slots and increment the event_id
            DB::table('slots')->insert($this->createSlots($event));
            DB::commit();

            return $event;
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::error(['message' => $e->getMessage()]);

            return null;
        }
    }

    private function createSlots($event): array
    {
        $rows = [];
        $slots = $event['total_slots'];

        for ($i = 0; $i < $slots; $i++) {
            $rows[] = (array) ['event_id' => $event['id']];
        }

        return $rows;
    }

    public function update(array $attributes, int $id)
    {
        try {
            $event = $this->eventModel::find($id);

            $event->category_id = $attributes['category_id'];
            $event->name = $attributes['name'];
            $event->description = $attributes['description'];

            $event->save();

            return $event;
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::error(['message' => $e->getMessage()]);

            return false;
        }
    }

    public function softDelete(int $id)
    {
    }

    public function hardDelete()
    {
    }
}
