<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CoursesRequest;
use Inertia\Inertia;

use App\Models\Category;
use App\Models\Courses;

class CoursesController extends Controller
{

    public function getCourses($request)
    {
        return Courses::when($request->input('search'), function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('price', 'like', '%' . $search . '%');
            })->paginate(10)->through(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'status' => $item->status,
                    'price' => $item->price,
                    'date_ini' => $item->date_ini,
                    'vacancies' => $item->vacancies
                ];
            });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        return Inertia::render('Courses/CoursesPage', ['categories' => Category::all(), 'courses' => $this->getCourses($request)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoursesRequest $request)
    {
        //
        $path = null;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $fileName = time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('images/avatar/courses/', $fileName, 'public');
        }

        Courses::create([
                            'title' => $request->input('title'),
                            'avatar' => $path,
                            'category_id' => $request->input('category'),
                            'price' => $request->input('price'),
                            'vacancies' => $request->input('vacancies'),
                            'date_ini' => $request->input('date_ini'),
                            'date_end' => $request->input('date_end'),
                            'status' => $request->input('status'),
                            'description' => $request->input('description'),
                            'materials' => $request->input('materials')
                                        ? json_encode($request->input('materials'))
                                        : null,
                        ]);

        return to_route('courses')->with('message', 'Curso criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $course = Courses::findOrFail($id);
        return response()->json($course);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $course = Courses::findOrFail($id);
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoursesRequest $request, string $id) 
    {
        $course = Courses::findOrFail($id);

        $path = $course->avatar; 

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $fileName = time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('images/avatar/courses/', $fileName, 'public');
        }

        $course->update([
            'title' => $request->input('title'),
            'avatar' => $path,
            'category_id' => $request->input('category'),
            'price' => $request->input('price'),
            'vacancies' => $request->input('vacancies'),
            'date_ini' => $request->input('date_ini'),
            'date_end' => $request->input('date_end'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'materials' => $request->input('materials') ? json_encode($request->input('materials')) : null,
            'updated_by' => auth()->user()->id, 
        ]);

        return to_route('courses')->with('message', 'Curso atualizado com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Courses::findOrFail($id)->delete();

        return to_route('courses')->with('message', 'Curso deletado com sucesso!');
    }
}
