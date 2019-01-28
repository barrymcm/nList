<?php

namespace App;

use App\Http\Requests\EventRequest;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['slots', 'category_id', 'name', 'description'];

    public function category()
    {
        return Category::find($this->id)->name;
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function updateEvent(EventRequest $request)
    {
        $this->name = $request['name'];
        $this->description = $request['description'];
        $this->slots = $request['slots'];
        $this->category_id = $request['category_id'];

        return $this->save();
    }
}
