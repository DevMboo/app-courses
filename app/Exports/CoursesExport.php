<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Carbon\Carbon;

class CoursesExport implements FromCollection, WithHeadings, WithMapping
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

    public function headings(): array
    {
        return [
            'Nome do Curso',
            'Descrição',
            'Data de Início',
            'Data de Término',
            'Criado em',
        ];
    }

    public function map($course): array
    {
        return [
            $course->title,
            $course->description,
            $course->date_ini ? Carbon::parse($course->date_ini)->format('d/m/Y') : '',
            $course->date_end ? Carbon::parse($course->date_end)->format('d/m/Y') : '',
            $course->created_at ? Carbon::parse($course->created_at)->format('d/m/Y H:i') : '',
        ];
    }
}
