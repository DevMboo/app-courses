<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Buying;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $buying = Buying::with('course')->where('user_id', auth()->id())->where('status', 'payment_created')
                    ->orderBy('created_at', 'desc')
                    ->first();

        $myBuyings = Buying::with('course')
                            ->where('user_id', auth()->id())
                            ->whereIn('status', ['payment_created', 'payment_confirmed'])
                            ->whereHas('course', function ($query) use ($request) {
                                if (!empty($request->input('search'))) {
                                    $query->where('title', 'like', "%{$request->input('search')}%");
                                }
                            })
                            ->orderBy('created_at', 'desc')
                            ->paginate(10)->through(function ($item) {
                                return [
                                    'email' => $item->email,
                                    'avatar' => $item->course->avatar,
                                    'name' => $item->course->title,
                                    'status' => $item->status,
                                    'price' => $item->course->price,
                                    'qrCode' => $item->pix_qr_code_url,
                                    'created_at' => $item->created_at
                                ];
                            });

        return Inertia::render('Payment/PaymentPage', ['buying' => $buying, 'myBuyings' => $myBuyings]);
    }

}
