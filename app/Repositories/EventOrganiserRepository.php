<?php

namespace App\Repositories;

use App\Models\EventOrganiser;
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

    public function find($id)
    {
        try {
            return $this->eventOrganiserModel::find($id);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function create(array $eventOrganiser, $id = null)
    {
        try {
            return $this->eventOrganiserModel::create($eventOrganiser);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function update(array $eventOrganiser, $id)
    {
    }

    public function softDelete(int $id)
    {
    }

    public function hardDelete()
    {
    }
}
