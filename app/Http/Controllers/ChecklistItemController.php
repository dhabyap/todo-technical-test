<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistItemController extends Controller
{
    public function index($id)
    {
        $checklist = Checklist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($checklist->items);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
        ]);

        $checklist = Checklist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        dd($checklist);

        $item = $checklist->items()->create([
            'item_name' => $request->item_name,
        ]);

        return response()->json([
            'message' => 'Item added',
            'data' => $item
        ], 201);
    }

    public function show($checklistId, $itemId)
    {
        $item = Item::where('id', $itemId)
            ->where('checklist_id', $checklistId)
            ->firstOrFail();

        return response()->json($item);
    }

    public function rename(Request $request, $checklistId, $itemId)
    {
    
        $request->validate([
            'item_name' => 'required',
        ]);
    
        $item = Item::where('id', $itemId)
            ->where('checklist_id', $checklistId)
            ->firstOrFail();
    
        $item->update(['item_name' => $request->item_name]);
    
        return response()->json([
            'message' => 'Item renamed',
            'data' => $item
        ]);
    }
    
    public function toggle($checklistId, $itemId)
    {
        $item = Item::where('id', $itemId)
            ->where('checklist_id', $checklistId)
            ->firstOrFail();

        $item->is_complete = !$item->is_complete;
        $item->save();

        return response()->json([
            'message' => 'Item status updated',
            'data' => $item
        ]);
    }

    public function destroy($checklistId, $itemId)
    {
        $item = Item::where('id', $itemId)
            ->where('checklist_id', $checklistId)
            ->firstOrFail();

        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }
}
