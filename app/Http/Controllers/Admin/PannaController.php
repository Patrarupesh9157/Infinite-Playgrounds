<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Panna; // Updated model
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;

class PannaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Panna::query(); // Use query builder
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    
                    // Edit icon link
                    $btn .= '<a href="javascript:;" class="text-body edit-record mx-1" data-toggle="tooltip" data-bs-target="#pannaform" data-bs-toggle="offcanvas" data-id="' . $row->id . '" data-url="' . route("admin.category.panna.update", [$row->id]) . '" data-fetch-url="' . route("admin.category.panna.edit", [$row->id]) . '">
                        <i class="ti ti-edit ti-sm"></i>
                    </a>';

                    // Delete icon link
                    $btn .= '<a href="javascript:;" class="text-body delete-record mx-1" data-id="' . $row->id . '" data-url="' . route("admin.category.panna.destroy", [$row->id]) . '">
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

        return view('admin.panna.index'); // Ensure this points to your panna index view
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
        Panna::create(['name' => $request->name]);
        return Redirect::route('admin.category.panna.index')->with('success', 'Panna added successfully.');
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
        $panna = Panna::findOrFail($id);
        return response()->json($panna);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Find the panna by ID
        $panna = Panna::findOrFail($id);

        // Update the panna with request data
        $panna->name = $request->input('name');
        $panna->save();

        // Redirect back to the panna list with a success message
        return redirect()->route('admin.category.panna.index')->with([
            'toastStatus' => 'success',
            'message' => 'Panna updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $panna = Panna::findOrFail($id);

        // Attempt to delete the panna
        $panna->delete();

        // Redirect back to the panna list with a success message
        return response()->json(['success' => 'Panna deleted successfully']);
    }
}
