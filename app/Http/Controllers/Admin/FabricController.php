<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fabric;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;

class FabricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Fabric::query(); // Use query builder
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<a href="javascript:;" class="text-body edit-record mx-1" data-toggle="tooltip" data-bs-target="#fabricform" data-bs-toggle="offcanvas" data-id="' . $row->id . '" data-url="' . route("admin.category.fabric.update", [$row->id]) . '" data-fetch-url="' . route("admin.category.fabric.edit", [$row->id]) . '">
            <i class="ti ti-edit ti-sm"></i>
        </a>';
                    $btn .= '<a href="javascript:;" class="text-body delete-record mx-1" data-id="' . $row->id . '" data-url="' . route("admin.category.fabric.destroy", [$row->id]) . '">
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

        return view('admin.fabric.index');
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
        Fabric::create(['name' => $request->name]);
        return Redirect::route('admin.category.fabric.index')->with('success', 'Fabric added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fabric = Fabric::findOrFail($id);
        return response()->json($fabric);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $fabric = Fabric::findOrFail($id);
        $fabric->name = $request->input('name');
        $fabric->save();
        return redirect()->route('admin.category.fabric.index')->with([
            'toastStatus' => 'success',
            'message' => 'Fabric updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fabric = Fabric::findOrFail($id);
        $fabric->delete();

        return response()->json(['success' => 'Fabric deleted successfully']);
    }
}
