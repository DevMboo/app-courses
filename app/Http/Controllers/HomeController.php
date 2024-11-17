<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Courses;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $totals = [];

        $totals['courses'] = Courses::count();
        $totals['students'] = User::where('is_admin', 0)->count();
        $totals['admin'] = User::where('is_admin', 1)->count();

        return Inertia::render('Home/HomePage', ['totals' => $totals]);
    }

}
