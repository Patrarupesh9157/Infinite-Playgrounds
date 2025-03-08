<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Concept::query(); // Use query builder
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    // $btn = '<div class="d-flex align-items-center justify-content-center">';
    
                    // Edit icon link
                    $btn .= '<a href="javascript:;" class="text-body edit-record mx-1" data-toggle="tooltip" data-bs-target="#conceptform" data-bs-toggle="offcanvas" data-id="' . $row->id . '" data-url="' . route("admin.category.concept.update", [$row->id]) . '" data-fetch-url="' . route("admin.category.concept.edit", [$row->id]) . '">
            <i class="ti ti-edit ti-sm"></i>
        </a>';

                    // Delete icon link
                    $btn .= '<a href="javascript:;" class="text-body delete-record mx-1" data-id="' . $row->id . '" data-url="' . route("admin.category.concept.destroy", [$row->id]) . '">
            <i class="ti ti-trash ti-sm"></i>
        </a>';

                    // $btn .= '</div>';
    
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

        return view('admin.concepts.index'); // Ensure this points to your Concept index view
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
        // dd($request->all());
        Concept::create(['name' => $request->name]);
        return Redirect::route('admin.category.concept.index')->with('success', 'Concept added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Concept $concept)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // dd('edit');
        $concept = concept::findOrFail($id);
        return response()->json($concept);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        // Find the concept by ID
        $concept = Concept::findOrFail($id);

        // Update the concept with request data
        $concept->name = $request->input('name');
        $concept->save();

        // Redirect back to the concept list with a success message
        return redirect()->route('admin.category.concept.index')->with([
            'toastStatus' => 'success',
            'message' => 'Concept updated successfully!'
        ]);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the concept by its ID
        $concept = Concept::findOrFail($id);

        // Attempt to delete the concept
        $concept->delete();

        // Redirect back to the concept list with a success message
        return response()->json(['success' => 'Concept deleted successfully']);
    }

}