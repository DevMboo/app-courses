<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Courses;
use App\Models\Buying;
use App\Models\User;

class DashboardController extends Controller
{   

    public function totals()
    {
        $totals = [];

        $totals['courses'] = Courses::count();
        $totals['students'] = User::where('is_admin', 0)->count();
        $totals['admin'] = User::where('is_admin', 1)->count();
        $totals['budget'] = Buying::where('status', 'payment_confirmed')->sum('price');

        return $totals;
    }

    public function getBuyings($request)
    {
        return Buying::with('course')
        ->with('user')
        ->whereIn('status', ['payment_created', 'payment_confirmed'])
        ->where(function ($query) use ($request) {
            if (!empty($request->input('search'))) {
                $searchTerm = "%" . $request->input('search') . "%";
                $query->whereHas('user', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'like', $searchTerm);
                })->orWhereHas('course', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('title', 'like', $searchTerm);
                });
            }
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)->through(function ($item) {
            return [
                'id' => $item->id,
                'email' => $item->email,
                'avatar' => $item->course->avatar,
                'user_name' => $item->user->name,
                'name' => $item->course->title,
                'status' => $item->status,
                'price' => $item->price,
                'qrCode' => $item->pix_qr_code_url,
                'created_at' => $item->created_at
            ];
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        return Inertia::render('Dashboard/DashboardPage', ['totals' => $this->totals(), 'buyings' => $this->getBuyings($request)]);
    }

}
