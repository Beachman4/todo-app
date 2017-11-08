<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\TodoItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'date' => 'required'
        ]);

        $array = $request->only(['title', 'date', 'reminder', 'url', 'description']);
        $array['date'] = Carbon::parse($array['date']);

        $todoItem = $this->user()->todoItems()->create($array);

        return response()->json([
            'todo' => $todoItem
        ]);
    }

    public function list()
    {
        $items = $this->user()->todoItems;
        $time = Carbon::now($this->user()->setting('timezone'));

        $formatted = [];

        for($i = 0; $i < 14; $i++) {
            $array = $items->filter(function($item) use($time) {
                return $item->date == $time->toDateString();
            });

            if (count($array) > 0) {
                $formatted[$time->toDateString()] = $array;
            }

            $time = $time->addDay();
        }

        return response()->json([
            'items' => $formatted
        ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'date' => 'required'
        ]);

        $todoItem = TodoItem::find($id);

        $todoItem->update($request->all());

        return response()->json($todoItem);
    }

    public function view($id)
    {
        return response()->json(TodoItem::find($id));
    }
}
