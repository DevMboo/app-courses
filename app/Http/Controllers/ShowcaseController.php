<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShowcaseRequest;

use App\Jobs\ProcessBuying;

use Inertia\Inertia;

use App\Models\Buying;
use App\Models\Courses;

class ShowcaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $courses = Courses::when($request->input('search'), function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('description', 'like', '%' . $search . '%')
                         ->orWhere('price', 'like', '%' . $search . '%');
        })->paginate(10)->through(function ($item) {
            return [
                'id' => $item->id,
                'avatar' => $item->avatar,
                'title' => $item->title,
                'status' => $item->status,
                'price' => $item->price,
                'date_ini' => $item->date_ini,
                'vacancies' => $item->vacancies
            ];
        });

        return Inertia::render('Showcase/ShowcasePage', ['courses' => $courses]);
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
    public function store(ShowcaseRequest $request, string $id)
    {
        //
        $buying = Buying::where('course_id', $id)->where('user_id', auth()->user()->id)->whereNot('status', 'sent')->first();

        if(!$buying) {
            $buying = Buying::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'cpf' => $request->input('cpfCnpj'),
                'phone' => $request->input('phone'),
                'user_id' => auth()->id(),
                'course_id' => $id,
                'status' => 'pending'
            ]);

            ProcessBuying::dispatch($buying);

            return to_route('payment')->with('message', 'Solicitação de compra criada, seu qrcode está sendo gerado para pagamentos PIX!');
        }

        return to_route('showcase')->with('info', 'Você já possuí uma solicitação de compra criada para esse curso, verifique seu perfil e visualize!');
        
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
