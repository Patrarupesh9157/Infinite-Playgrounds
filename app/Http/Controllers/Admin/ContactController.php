<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Contact::all(); // Fetch all contacts

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("admin.contacts.show", [$row->id]) . '" class="text-body mx-1" data-toggle="tooltip" title="View Details">
                        <i class="ti ti-eye ti-sm"></i>
                    </a>';
                    return $btn;
                })
                ->addColumn('full_name', function ($row) {
                    return $row->name . ' ' . $row->surname;
                })
                ->addColumn('message_preview', function ($row) {
                    return strlen($row->message) > 50 ? substr($row->message, 0, 50) . '...' : $row->message;
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('F j, Y, g:i A');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.contacts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }
} 