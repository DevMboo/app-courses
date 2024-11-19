<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use Inertia\Inertia;

use App\Models\Buying;

class PaymentController extends Controller
{

    public function getMyBuying($request)
    {
        return Buying::with('course')
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
                            'price' => $item->price,
                            'qrCode' => $item->pix_qr_code_url,
                            'created_at' => $item->created_at
                        ];
                    });
    }

    public function getBuying()
    {
        return Buying::with('course')->where('user_id', auth()->id())->where('status', 'payment_created')
                    ->orderBy('created_at', 'desc')
                    ->first();
    }


    public function edit(string $id)
    {
        $buying = Buying::findOrFail($id);
        return response()->json($buying);
    }

    public function destroy(string $id)
    {
        Buying::findOrFail($id)->delete();

        return to_route('dashboard')->with('message', 'Pagamento deletado com sucesso!');
    }

    public function update(PaymentRequest $request, string $id)
    {   
        $buying = Buying::findOrFail($id);

        $buying->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'cpf' => $request->input('cpfCnpj'),
            'phone' => $request->input('phone'),
            'price' =>  $request->input('price'),
            'user_id' => $request->input('user_id'),
            'course_id' => $request->input('course_id'),
            'status' => $request->input('status') == 'payment_created' ? 'reprocess_payment' : $request->input('status'),
        ]);

        return to_route('dashboard')->with('message', 'Pagamento atualizado com sucesso!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        return Inertia::render('Payment/PaymentPage', ['buying' => $this->getBuying(), 'myBuyings' => $this->getMyBuying($request)]);
    }

}
