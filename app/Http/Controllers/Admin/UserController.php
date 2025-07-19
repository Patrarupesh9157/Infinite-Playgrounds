<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = User::all(); // Fetch all users

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("admin.users.show", [$row->id]) . '" class="text-body mx-1" data-toggle="tooltip" title="View Details">
                        <i class="ti ti-eye ti-sm"></i>
                    </a>';
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('F j, Y, g:i A');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with(['reviews', 'likes'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
} 