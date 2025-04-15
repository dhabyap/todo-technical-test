<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    public function index()
    {
        $checklists = Checklist::where('user_id', Auth::id())->get();

        return response()->json($checklists);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $checklist = Checklist::create([
            'name' => $request->name,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'message' => 'Checklist created',
            'data' => $checklist
        ], 201);
    }

    public function destroy($id)
    {
        $checklist = Checklist::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$checklist) {
            return response()->json(['message' => 'Checklist not found'], 404);
        }

        $checklist->delete();

        return response()->json(['message' => 'Checklist deleted']);
    }
}
