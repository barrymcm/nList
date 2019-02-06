<?php


namespace App\Services;


use App\Repositories\RepositoryInterface;

class EventService
{
    private $eventRepository;

    public function __construct(RepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function assignAttributes(array $attributes) : array
    {
        return [
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'total_slots' => $attributes['slots'],
            'category_id' => $attributes['category_id']
        ];
    }
}