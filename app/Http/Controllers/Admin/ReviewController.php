<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameReview;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = GameReview::with(['user', 'game'])->get(); // Fetch all reviews with relationships

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("admin.reviews.show", [$row->id]) . '" class="text-body mx-1" data-toggle="tooltip" title="View Details">
                        <i class="ti ti-eye ti-sm"></i>
                    </a>';
                    return $btn;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user ? $row->user->name : 'N/A';
                })
                ->addColumn('game_name', function ($row) {
                    return $row->game ? $row->game->name : 'N/A';
                })
                ->addColumn('rating_stars', function ($row) {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $row->rating) {
                            $stars .= '<i class="ti ti-star-filled text-warning"></i>';
                        } else {
                            $stars .= '<i class="ti ti-star text-muted"></i>';
                        }
                    }
                    return $stars;
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('F j, Y, g:i A');
                })
                ->rawColumns(['action', 'rating_stars'])
                ->make(true);
        }

        return view('admin.reviews.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $review = GameReview::with(['user', 'game'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }
} 