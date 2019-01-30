<?php

namespace App\Models;

use App\Http\Requests\StoreEvent;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'description', 'total_slots', 'category_id'];

    public function category()
    {
        return Category::find($this->category_id);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function createEvent($attributes)
    {
        return Event::create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'total_slots' => $attributes['slots'],
            'category_id' => $attributes['category_id'],
        ]);
    }

    public function updateEvent(StoreEvent $request)
    {
        $this->name = $request['name'];
        $this->description = $request['description'];
        $this->total_slots = $request['slots'];
        $this->category_id = $request['category_id'];

        return $this->save();
    }
}
