<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Game::all(); // Fetch all games

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<a href="javascript:;" class="text-body edit-record mx-1" data-toggle="tooltip" data-bs-target="#gameform" data-bs-toggle="offcanvas" data-id="' . $row->id . '" data-url="' . route("admin.games.update", [$row->id]) . '" data-fetch-url="' . route("admin.games.edit", [$row->id]) . '">
                        <i class="ti ti-edit ti-sm"></i>
                    </a>';
                    $btn .= '<a href="javascript:;" class="text-body delete-record mx-1" data-id="' . $row->id . '" data-url="' . route("admin.games.destroy", [$row->id]) . '">
                        <i class="ti ti-trash ti-sm"></i>
                    </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.games.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'html' => 'nullable|string',
            'css' => 'nullable|string',
            'js' => 'nullable|string',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store images if available
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('game_images', 'public');
                $images[] = $path;
            }
        }

        // Store game data
        Game::create([
            'name' => $request->name,
            'html_code' => $request->html,
            'css_code' => $request->css,
            'js_code' => $request->js,
            'description' => $request->description,
            'images' => json_encode($images),
        ]);

        return Redirect::route('admin.games.index')->with('success', 'Game added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $game = Game::findOrFail($id);
        return response()->json($game);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'html' => 'nullable|string',
            'css' => 'nullable|string',
            'js' => 'nullable|string',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $game = Game::findOrFail($id);

        // Update images if new ones are provided
        $images = json_decode($game->images, true) ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('game_images', 'public');
                $images[] = $path;
            }
        }

        // Update game data
        $game->update([
            'name' => $request->name,
            'html_code' => $request->html,
            'css_code' => $request->css,
            'js_code' => $request->js,
            'description' => $request->description,
            'images' => json_encode($images),
        ]);

        return redirect()->route('admin.games.index')->with([
            'toastStatus' => 'success',
            'message' => 'Game updated successfully!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return response()->json(['success' => 'Game deleted successfully']);
    }
}
