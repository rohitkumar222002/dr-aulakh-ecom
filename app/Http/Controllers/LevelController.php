<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $levels = Level::orderBy('level')->get();
        return view('admin.levels.index', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required|integer|unique:levels,level',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        Level::create($request->only('level', 'percentage'));

        return redirect()->back()->with('success', 'Level created successfully.');
    }

    public function update(Request $request, Level $level)
    {
        $request->validate([
            'level' => 'required|integer|unique:levels,level,' . $level->id,
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $level->update($request->only('level', 'percentage'));

        return redirect()->back()->with('success', 'Level updated successfully.');
    }

    public function destroy(Level $level)
    {
        $level->delete();
        return redirect()->back()->with('success', 'Level deleted successfully.');
    }
}
