<?php

namespace App\Repositories;

use App\Models\EventOrganiser;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventOrganiserRepository implements RepositoryInterface
{
    private $eventOrganiserModel;

    public function __construct(EventOrganiser $eventOrganiserModel)
    {
        $this->eventOrganiserModel = $eventOrganiserModel;
    }

    public function all()
    {
        try {
            return $this->eventOrganiserModel::all();
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function find(int $id)
    {
        try {
            return $this->eventOrganiserModel::find($id);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function findBy(int $userId): EventOrganiser
    {
        try {
            return $this->eventOrganiserModel::where('user_id', $userId)->first();
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function create(array $eventOrganiser, int $id = null)
    {
        try {
            return $this->eventOrganiserModel::create($eventOrganiser);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function update(array $eventOrganiser, int $id)
    {
        try {
            return $this->eventOrganiserModel::update($eventOrganiser);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function softDelete(int $id)
    {
    }

    public function hardDelete()
    {
    }
}
