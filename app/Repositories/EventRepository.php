<?php


namespace App\Repositories;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventRepository implements RepositoryInterface
{

    private $eventModel;

    public function __construct(Event $event)
    {
        $this->eventModel = $event;
    }

    public function all()
    {
        return $this->eventModel::all();
    }

    public function find($eventId)
    {
        $event = $this->eventModel::find($eventId);
        $category = Category::find($event->category_id);
        $event->category_name = $category->name;

        return $event;

    }

    public function create(array $event)
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

    public function update(array $attributes)
    {
        $event = $this->eventModel::find($attributes['event_id']);

        $event->total_slots = $attributes['total_slots'];
        $event->category_id = $attributes['category_id'];
        $event->name = $attributes['name'];
        $event->description = $attributes['description'];

        $event->save();

        return $event;
    }

    public function softDelete($id)
    {

    }

    public function hardDelete()
    {

    }
}