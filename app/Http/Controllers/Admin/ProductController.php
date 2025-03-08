<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Concept;
use App\Models\Fabric;
use App\Models\Panna;
use App\Models\Product;
use App\Models\TechnicallyConcept;
use App\Models\UseIn;
use App\Models\Yarn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $areas = Area::all();
        $concepts = Concept::all();
        $fabrics = Fabric::all();
        $pannas = Panna::all();
        $technicalConcepts = TechnicallyConcept::all();
        $useIns = UseIn::all();
        $yarns = Yarn::all();
        $data = Product::with(['area', 'concept', 'fabric', 'panna', 'technicalConcept', 'useIn', 'yarn'])->get();
        // dd($data);
        if ($request->ajax()) {

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('area', function ($row) {
                    return $row->area ? $row->area->name : '-';
                })
                ->addColumn('concept', function ($row) {
                    return $row->concept ? $row->concept->name : '-';
                })
                ->addColumn('fabric', function ($row) {
                    return $row->fabric ? $row->fabric->name : '-';
                })
                ->addColumn('panna', function ($row) {
                    return $row->panna ? $row->panna->name : '-';
                })
                ->addColumn('technical_concept', function ($row) {
                    return $row->technicalConcept ? $row->technicalConcept->name : '-';
                })
                ->addColumn('use_in', function ($row) {
                    return $row->useIn ? $row->useIn->name : '-';
                })
                ->addColumn('yarn', function ($row) {
                    return $row->yarn ? $row->yarn->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.products.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= '<form method="POST" action="' . route('admin.products.destroy', $row->id) . '" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="delete btn btn-danger btn-sm">Delete</button>
                         </form>';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<a href="javascript:;" class="text-body edit-record mx-1" data-toggle="tooltip" data-bs-target="#productform" data-bs-toggle="offcanvas" data-id="' . $row->id . '" data-url="' . route("admin.products.update", [$row->id]) . '" data-fetch-url="' . route("admin.products.edit", [$row->id]) . '">
            <i class="ti ti-edit ti-sm"></i>
        </a>';
                    $btn .= '<a href="javascript:;" class="text-body delete-record mx-1" data-id="' . $row->id . '" data-url="' . route("admin.products.destroy", [$row->id]) . '">
            <i class="ti ti-trash ti-sm"></i>
        </a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.products.index', compact('areas', 'concepts', 'fabrics', 'pannas', 'technicalConcepts', 'useIns', 'yarns'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::all();
        $concepts = Concept::all();
        $fabrics = Fabric::all();
        $pannas = Panna::all();
        $technicalConcepts = TechnicallyConcept::all();
        $useIns = UseIn::all();
        $yarns = Yarn::all();

        return view('admin.products.create', compact('areas', 'concepts', 'fabrics', 'pannas', 'technicalConcepts', 'useIns', 'yarns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'concept_id' => 'required|exists:concept,id',
            'fabric_id' => 'required|exists:fabrics,id',
            'panna_id' => 'required|exists:pannas,id',
            'technical_concept_id' => 'required|exists:technically_concepts,id',
            'use_in_id' => 'required|exists:use_ins,id',
            'yarn_id' => 'required|exists:yarns,id',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Storing images if available
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $images[] = $path;
            }
        }

        // Storing product data
        Product::create([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'concept_id' => $request->concept_id,
            'fabric_id' => $request->fabric_id,
            'panna_id' => $request->panna_id,
            'technical_concept_id' => $request->technical_concept_id,
            'use_in_id' => $request->use_in_id,
            'yarn_id' => $request->yarn_id,
            'price' => $request->price,
            'images' => json_encode($images),
            'design_name' => $request->design_name,
            'rate' => $request->rate,
            'height' => $request->height,
            'stitches' => $request->stitches,
            'date' => Carbon::now()
        ]);


        return Redirect::route('admin.products.index')->with('success', 'Product added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $areas = Area::all();
        $concepts = Concept::all();
        $fabrics = Fabric::all();
        $pannas = Panna::all();
        $technicalConcepts = TechnicallyConcept::all();
        $useIns = UseIn::all();
        $yarns = Yarn::all();
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd('hello');
        // Validation rules
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'area_id' => 'required|exists:areas,id',
        //     'concept_id' => 'required|exists:concept,id',
        //     'fabric_id' => 'required|exists:fabrics,id',
        //     'panna_id' => 'required|exists:pannas,id',
        //     'technical_concept_id' => 'required|exists:technically_concepts,id',
        //     'use_in_id' => 'required|exists:use_ins,id',
        //     'yarn_id' => 'required|exists:yarns,id',
        //     'price' => 'required|numeric|min:0',
        //     'height' => 'required|integer|min:1|max:100',
        //     'rate' => 'required|numeric',
        //     'stitches' => 'nullable|string|max:255',
        //     'design_name' => 'required|string|max:255',
        //     'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'date' => 'required|date'
        // ]);
        // dd('hello',$request->all());

        // Find the product
        $product = Product::findOrFail($id);

        // Handle new images if uploaded
        $images = json_decode($product->images, true) ?? [];  // Keep existing images if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $images[] = $path;
            }
        }

        // Update product data
        $product->update([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'concept_id' => $request->concept_id,
            'fabric_id' => $request->fabric_id,
            'panna_id' => $request->panna_id,
            'technical_concept_id' => $request->technical_concept_id,
            'use_in_id' => $request->use_in_id,
            'yarn_id' => $request->yarn_id,
            'price' => $request->price,
            'images' => json_encode($images),
            'design_name' => $request->design_name,
            'rate' => $request->rate,
            'height' => $request->height,
            'stitches' => $request->stitches,
            'date' => Carbon::now()
        ]);

        return redirect()->route('admin.products.index')->with([
            'toastStatus' => 'success',
            'message' => 'Product updated successfully!'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully']);
    }
}
