<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TechnicallyConcept;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;

class TechnicallyConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TechnicallyConcept::query(); // Use query builder
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';

                    // Edit icon link
                    $btn .= '<a href="javascript:;" class="text-body edit-record mx-1" data-toggle="tooltip" data-bs-target="#technicallyConceptForm" data-bs-toggle="offcanvas" data-id="' . $row->id . '" data-url="' . route("admin.category.technically-concept.update", [$row->id]) . '" data-fetch-url="' . route("admin.category.technically-concept.edit", [$row->id]) . '">
                        <i class="ti ti-edit ti-sm"></i>
                    </a>';

                    // Delete icon link
                    $btn .= '<a href="javascript:;" class="text-body delete-record mx-1" data-id="' . $row->id . '" data-url="' . route("admin.category.technically-concept.destroy", [$row->id]) . '">
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

        return view('admin.technical_concept.index'); // Ensure this points to your technicallyConcept index view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        TechnicallyConcept::create(['name' => $request->name]);
        return Redirect::route('admin.category.technically-concept.index')->with('success', 'Technically Concept added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $technicallyConcept = TechnicallyConcept::findOrFail($id);
        return response()->json($technicallyConcept);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Find the technically concept by ID
        $technicallyConcept = TechnicallyConcept::findOrFail($id);

        // Update the technically concept with request data
        $technicallyConcept->name = $request->input('name');
        $technicallyConcept->save();

        // Redirect back to the technically concept list with a success message
        return redirect()->route('admin.category.technically-concept.index')->with([
            'toastStatus' => 'success',
            'message' => 'Technically Concept updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $technicallyConcept = TechnicallyConcept::findOrFail($id);

        // Attempt to delete the technically concept
        $technicallyConcept->delete();

        // Redirect back to the technically concept list with a success message
        return response()->json(['success' => 'Technically Concept deleted successfully']);
    }
}
