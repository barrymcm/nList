<?php


namespace App\Repositories;

use App\Models\Category;
use App\Models\Event;
use App\Models\EventOrganiser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Facades\App\Repositories\ApplicantListRepository;

class EventRepository implements RepositoryInterface
{

    private $eventModel;

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
            return $e->getMessage();
        }
    }

    public function find($eventId)
    {
        $event = $this->eventModel::find($eventId);

        foreach($event->slots as $key => $slot) {
            $availability = ApplicantListRepository::getAvailableSlotPlaces($slot->id);
            $slot->setAvailabilityAttribute($availability);
        }

        $organiser = EventOrganiser::find($event->event_organiser_id);
        $event->organiser = $organiser->name;

        $category = Category::find($event->category_id);
        $event->category_name = $category->name;

        return $event;
    }

    public function create(array $event, $id = null)
    {
        try {
            DB::beginTransaction();
            $newEvent = $this->eventModel::create($event);
            DB::table('slots')->insert($this->createSlots($newEvent));
            DB::commit();

            return $newEvent;

        } catch (\PDOException $e) {
            DB::rollBack();
        }
    }

    private function createSlots($event)
    {
        $rows = [];
        $slots = $event['total_slots'];

        for ($i = 0; $i < $slots; $i++) {
            $rows[] = (array) ['event_id' => $event['id']];
        }

        return $rows;
    }

    public function update(array $attributes, $id)
    {
        try {
            $event = $this->eventModel::find($id);

            DB::beginTransaction();
            DB::table('slots')->insert($this->createSlots($event));
            DB::commit();

            $event->total_slots = $attributes['total_slots'];
            $event->category_id = $attributes['category_id'];
            $event->name = $attributes['name'];
            $event->description = $attributes['description'];

            $event->save();
            return $event;

        } catch (\PDOException $e) {
            DB::rollBack();

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