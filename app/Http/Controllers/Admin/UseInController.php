<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UseIn; // Updated model
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;

class UseInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UseIn::query(); // Use query builder for UseIn
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';

                    // Edit icon link
                    $btn .= '<a href="javascript:;" class="text-body edit-record mx-1" data-toggle="tooltip" data-bs-target="#useinform" data-bs-toggle="offcanvas" data-id="' . $row->id . '" data-url="' . route("admin.category.usein.update", [$row->id]) . '" data-fetch-url="' . route("admin.category.usein.edit", [$row->id]) . '">
            <i class="ti ti-edit ti-sm"></i>
        </a>';

                    // Delete icon link
                    $btn .= '<a href="javascript:;" class="text-body delete-record mx-1" data-id="' . $row->id . '" data-url="' . route("admin.category.usein.destroy", [$row->id]) . '">
            <i class="ti ti-trash ti-sm"></i>
        </a>';

                    return $btn;
                })
                ->editColumn('name', function ($row) {
                    return $row->name ?? '-';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '-';
                })
                ->orderColumn('created_at', function ($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.usein.index'); // Ensure this points to your UseIn index view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        UseIn::create(['name' => $request->name]);
        return Redirect::route('admin.category.usein.index')->with('success', 'UseIn added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $useIn = UseIn::findOrFail($id);
        return response()->json($useIn);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Find the UseIn by ID
        $useIn = UseIn::findOrFail($id);

        // Update the UseIn with request data
        $useIn->name = $request->input('name');
        $useIn->save();

        // Redirect back to the UseIn list with a success message
        return redirect()->route('admin.category.usein.index')->with([
            'toastStatus' => 'success',
            'message' => 'UseIn updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $useIn = UseIn::findOrFail($id);

        // Attempt to delete the UseIn
        $useIn->delete();

        // Return success response
        return response()->json(['success' => 'UseIn deleted successfully']);
    }
}
