<?php

namespace App\Exports;

use App\Models\Courses;
use Maatwebsite\Excel\Concerns\FromCollection;

class CoursesExport implements FromCollection
{
    protected $courses;

    public function __construct($courses)
    {
        $this->courses = $courses;
    }

    public function collection()
    {
        return $this->courses;
    }
}