<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Yarn;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
class YarnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Yarn::query(); // Use query builder
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    // $btn = '<div class="d-flex align-items-center justify-content-center">';
    
                    // Edit icon link
                    $btn .= '<a href="javascript:;" class="text-body edit-record mx-1" data-toggle="tooltip" data-bs-target="#yarnform" data-bs-toggle="offcanvas" data-id="' . $row->id . '" data-url="' . route("admin.category.yarn.update", [$row->id]) . '" data-fetch-url="' . route("admin.category.yarn.edit", [$row->id]) . '">
            <i class="ti ti-edit ti-sm"></i>
        </a>';

                    // Delete icon link
                    $btn .= '<a href="javascript:;" class="text-body delete-record mx-1" data-id="' . $row->id . '" data-url="' . route("admin.category.yarn.destroy", [$row->id]) . '">
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

        return view('admin.yarn.index'); // Ensure this points to your yarn index view
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
        Yarn::create(['name' => $request->name]);
        return Redirect::route('admin.category.yarn.index')->with('success', 'Yarn added successfully.');
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
        $yarn = Yarn::findOrFail($id);
        return response()->json($yarn);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        // Find the yarn by ID
        $yarn = Yarn::findOrFail($id);

        // Update the yarn with request data
        $yarn->name = $request->input('name');
        $yarn->save();

        // Redirect back to the yarn list with a success message
        return redirect()->route('admin.category.yarn.index')->with([
            'toastStatus' => 'success',
            'message' => 'Yarn updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $yarn = Yarn::findOrFail($id);

        // Attempt to delete the yarn
        $yarn->delete();

        // Redirect back to the yarn list with a success message
        return response()->json(['success' => 'Yarn deleted successfully']);
    }
}
