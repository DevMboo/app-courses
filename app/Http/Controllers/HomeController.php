<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Courses;
use App\Models\Buying;
use App\Models\User;

class HomeController extends Controller
{   

    public function totals()
    {
        $totals = [];

        $totals['courses'] = Courses::count();
        $totals['students'] = User::where('is_admin', 0)->count();
        $totals['admin'] = User::where('is_admin', 1)->count();
        $totals['budget'] = Buying::where('status', 'payment_confirmed')
                            ->whereHas('course')
                            ->with('course')
                            ->get()
                            ->sum(function ($buying) {
                                return $buying->course->price ?? 0;
                            });

        return $totals;
    }

    public function getBuyings($request)
    {
        return Buying::with('course')
        ->with('user')
        ->whereIn('status', ['payment_created', 'payment_confirmed'])
        ->whereHas('user', function ($query) use ($request) {
            if (!empty($request->input('search'))) {
                $query->where('name', 'like', "%".$request->input('search')."%");
            }
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)->through(function ($item) {
            return [
                'email' => $item->email,
                'avatar' => $item->course->avatar,
                'user_name' => $item->user->name,
                'name' => $item->course->title,
                'status' => $item->status,
                'price' => $item->course->price,
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
        return Inertia::render('Home/HomePage', ['totals' => $this->totals(), 'buyings' => $this->getBuyings($request)]);
    }

}
